<?php

namespace Seven\Krayin\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Seven\Krayin\Services\Personell;
use Seven\Krayin\Services\RequestHandler;
use Seven\Krayin\Services\Seven;

class SevenController extends Controller {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(
        protected Seven            $seven,
        protected  Personell $personell
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View {
        $entityType = 'persons';
        return view('seven::index', compact('entityType'));
    }

    /**
     * Compose SMS for destined for a single person.
     */
    public function smsPerson(int $id): View {
        return $this->sms('persons', $id);
    }

    /**
     * Compose SMS for destined for a single organization.
     */
    public function smsOrganization(int $id): View {
        return $this->sms('organizations', $id);
    }

    protected function sms(string $entityType, int $id): View {
        return view('seven::sms', compact('entityType', 'id'));
    }

    public function smsSend(): RedirectResponse {
        $request = request();

        if ($request->method() === 'POST') {
            $requestHandler = new RequestHandler($request);
            $requestHandler->validateSmsParams();
            $errors = $this->seven->sms(
                $requestHandler->buildSmsParams(),
                ...$this->personell->getPersons($request)
            );

            if (count($errors)) return redirect()->back();
        }

        return redirect()->back();
    }
}
