<?php

namespace Sms77\Krayin\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Sms77\Krayin\Repositories\SmsRepository;
use Sms77\Krayin\Services\Sms77;
use Webkul\Contact\Repositories\PersonRepository;

class Sms77Controller extends Controller {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var PersonRepository $personRepository */
    protected PersonRepository $personRepository;

    /** @var Sms77 $sms77 */
    protected Sms77 $sms77;

    /** @var SmsRepository $smsRepository */
    protected SmsRepository $smsRepository;

    /**
     * @param Sms77 $sms77
     * @param SmsRepository $smsRepository
     * @param PersonRepository $personRepository
     */
    public function __construct(
        Sms77            $sms77,
        SmsRepository    $smsRepository,
        PersonRepository $personRepository
    ) {
        $this->sms77 = $sms77;
        $this->smsRepository = $smsRepository;
        $this->personRepository = $personRepository;
    }

    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View {
        return view('sms77::index', ['entityType' => 'persons']);
    }

    /**
     * Compose SMS for destined for a single person.
     * @param int $id
     * @return View
     */
    public function smsPerson(int $id): View {
        return $this->sms('persons', $id);
    }

    /**
     * Compose SMS for destined for a single organization.
     * @param int $id
     * @return View
     */
    public function smsOrganization(int $id): View {
        return $this->sms('organizations', $id);
    }

    /**
     * @param string $entityType
     * @param int $id
     * @return View
     */
    protected function sms(string $entityType, int $id): View {
        return view('sms77::sms', compact('entityType', 'id'));
    }

    public function smsSend(): RedirectResponse {
        $request = request();

        if ($request->method() === 'POST') {
            $errors = $this->sms77->sms($request);

            if (count($errors)) return redirect()->back();
        }

        return redirect()->back();
        return redirect()->route('admin.contacts.persons.index');
    }
}
