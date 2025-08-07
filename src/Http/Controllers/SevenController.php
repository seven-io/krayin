<?php

namespace Seven\Krayin\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Seven\Krayin\Services\Seven;
use Webkul\Contact\Repositories\PersonRepository;

class SevenController extends Controller {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(
        protected Seven            $seven,
        protected PersonRepository $personRepository
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View {
        return view('seven::index', ['entityType' => 'persons']);
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
            $errors = $this->seven->sms($request);

            if (count($errors)) return redirect()->back();
        }

        return redirect()->back();
    }
}
