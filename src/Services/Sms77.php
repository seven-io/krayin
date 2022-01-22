<?php

namespace Sms77\Krayin\Services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Sms77\Krayin\Exception\UnprocessableEntityTypeException;
use Sms77\Krayin\Models\Sms;
use Webkul\Contact\Models\Organization;
use Webkul\Contact\Models\Person;
use Webkul\Contact\Repositories\OrganizationRepository;
use Webkul\Contact\Repositories\PersonRepository;
use Webkul\Core\Eloquent\Repository;

class Sms77 {
    /** @var string $apiKey */
    protected $apiKey;

    /** @var Client $client */
    protected $client;

    /** @var PersonRepository $personRepository */
    protected $personRepository;

    /** @var OrganizationRepository $organizationRepository */
    protected $organizationRepository;

    /**
     * @param PersonRepository $personRepository
     * @param OrganizationRepository $organizationRepository
     */
    public function __construct(
        PersonRepository       $personRepository,
        OrganizationRepository $organizationRepository
    ) {
        $this->personRepository = $personRepository;
        $this->organizationRepository = $organizationRepository;
        $this->apiKey = config('services.sms77.api_key');
        $this->client = new Client([
            'base_uri' => 'https://gateway.sms77.io/api/',
            RequestOptions::HEADERS => [
                'SentWith' => 'KrayinCRM',
                'X-Api-Key' => $this->apiKey,
            ],
        ]);
    }

    protected function getContactsNumbers(...$persons): string {
        $numbers = [];

        foreach ($persons as $person) {
            $contactNumbers = $person->getAttributeValue('contact_numbers');

            foreach ($contactNumbers ?? [] as $contactNumber)
                $numbers[] = $contactNumber['value'];
        }

        return implode(',', array_unique($numbers));
    }

    /**
     * @param Request $request
     * @return Person[]
     */
    protected function getPersons(Request $request): array {
        $entityType = $request->post('entityType');
        $id = $request->post('id');

        switch ($entityType) {
            case 'persons':
                return [$this->personRepository->find($id)];
            case 'organizations':
                /** @var Collection $collection */
                $collection = $this->personRepository
                    ->findByField('organization_id', $id);
                return $collection->all();
            default:
                throw new UnprocessableEntityTypeException($entityType, $id);
        }
    }

    public function sms(Request $request): array {
        $persons = $this->getPersons($request);

        if (empty($persons)) {
            $error = __('sms77::app.no_recipients');
            $errors[] = $error;
            session()->flash('error', $error);
        } else {
            $cost = 0.0;
            $msgCount = 0;
            $receivers = 0;

            $text = $request->post('text');
            $errors = [];
            $requests = [];
            $matches = [];
            preg_match_all('{{{+[a-z]*_*[a-z]+}}}', $text, $matches);
            $hasPlaceholders = is_array($matches) && !empty($matches[0]);

            if ($hasPlaceholders) foreach ($persons as $person) {
                $pText = $text;

                foreach ($matches[0] as $match) {
                    $key = trim($match, '{}');
                    $replace = '';
                    $attr = $person->getAttribute($key);
                    if ($attr) $replace = $attr;
                    $pText = str_replace($match, $replace, $pText);
                    $pText = preg_replace('/\s+/', ' ', $pText);
                    $pText = str_replace(' ,', ',', $pText);
                }

                $requests[] = [
                    'text' => $pText,
                    'to' => $this->getContactsNumbers($person),
                ];
            }
            else $requests[] = [
                'text' => $text,
                'to' => $this->getContactsNumbers(...$persons),
            ];

            $smsParams = [
                'flash' => filter_var($request->post('flash'), FILTER_VALIDATE_BOOLEAN),
                'from' => $request->post('from'),
                'json' => 1,
            ];

            foreach ($requests as $req) {
                try {
                    $response = $this->client->post('sms',
                        [RequestOptions::JSON => array_merge($smsParams, $req)])
                        ->getBody()->getContents();
                    (new Sms)->fill(
                        array_merge($req, compact('response'), ['to' => [$req['to']]]))
                        ->save();
                    $response = json_decode($response);

                    Log::info('sms77 responded to SMS dispatch.', compact('response'));

                    if (is_object($response)) {
                        $cost += (float)$response->total_price;

                        foreach ($response->messages as $message) {
                            $msgCount += $message->parts;
                            $receivers++;
                        }
                    }
                } catch (Exception $e) {
                    $error = $e->getMessage();
                    $errors[] = $error;
                    Log::error('sms77 failed to send SMS.', compact('error'));
                }
            }

            session()->flash('warning',
                __('sms77::app.sms_sent', compact('cost', 'msgCount', 'receivers')));
        }

        return $errors;
    }
}