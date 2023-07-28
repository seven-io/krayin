<?php

namespace Seven\Krayin\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Seven\Krayin\Repositories\SmsRepository;
use Seven\Krayin\Services\Seven;
use Webkul\Contact\Repositories\PersonRepository;

class SevenController extends Controller {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var PersonRepository $personRepository */
    protected PersonRepository $personRepository;

    /** @var Seven $seven */
    protected Seven $seven;

    /** @var SmsRepository $smsRepository */
    protected SmsRepository $smsRepository;

    /**
     * @param Seven $seven
     * @param SmsRepository $smsRepository
     * @param PersonRepository $personRepository
     */
    public function __construct(
        Seven            $seven,
        SmsRepository    $smsRepository,
        PersonRepository $personRepository
    ) {
        $this->seven = $seven;
        $this->smsRepository = $smsRepository;
        $this->personRepository = $personRepository;
    }

    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View {
        return view('seven::index', ['entityType' => 'persons']);
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
        return view('seven::sms', compact('entityType', 'id'));
    }

    public function smsSend(): RedirectResponse {
        $request = request();

        if ($request->method() === 'POST') {
            $errors = $this->seven->sms($request);

            if (count($errors)) return redirect()->back();
        }

        return redirect()->back();
    }
}
