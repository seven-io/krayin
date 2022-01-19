<?php

namespace Sms77\Krayin\Services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Sms77\Krayin\Models\Sms;
use Webkul\Contact\Models\Person;
use Webkul\Contact\Repositories\PersonRepository;

class Sms77 {
    /** @var string $apiKey */
    protected $apiKey;

    /** @var Client $client */
    protected $client;

    /** @var PersonRepository $personRepository */
    protected $personRepository;

    /**
     * @param PersonRepository $personRepository
     */
    public function __construct(PersonRepository $personRepository) {
        $this->personRepository = $personRepository;
        $this->apiKey = config('services.sms77.api_key');
        $this->client = new Client([
            'base_uri' => 'https://gateway.sms77.io/api/',
            RequestOptions::HEADERS => [
                'SentWith' => 'KrayinCRM',
                'X-Api-Key' => $this->apiKey,
            ],
        ]);
    }

    protected function getContactNumbers(Person $person): array {
        $numbers = [];
        $contactNumbers = $person->getAttributeValue('contact_numbers');

        foreach ($contactNumbers ?? [] as $contactNumber)
            $numbers[] = $contactNumber['value'];

        return array_unique($numbers);
    }

    public function sms(Request $request): array {
        $id = $request->input('id');
        /** @var Model $model */
        $model = $this->personRepository->find($id);
        /** @var Person $user */
        $user = $model;
        $recipients = $this->getContactNumbers($user);

        if (empty($recipients)) {
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

            if ($hasPlaceholders) foreach ($recipients as $to) {
                $pText = $text;

                foreach ($matches[0] as $match) {
                    $key = trim($match, '{}');
                    $replace = '';
                    $attr = $user->getAttribute($key);
                    if ($attr) $replace = $attr;
                    $pText = str_replace($match, $replace, $pText);
                    $pText = preg_replace('/\s+/', ' ', $pText);
                    $pText = str_replace(' ,', ',', $pText);
                }

                $requests[] = ['text' => $pText, 'to' => $to];
            }
            else $requests[] = ['text' => $text, 'to' => implode(',', $recipients)];

            $smsParams = [
                'flash' => $request->post('flash', 0),
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