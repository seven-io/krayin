<?php

namespace Seven\Krayin\Listeners;

use Illuminate\Support\Facades\Log;
use Seven\Krayin\Services\Configuration;
use Seven\Krayin\Services\Seven;
use Webkul\Contact\Models\Person;
use Webkul\Contact\Repositories\PersonRepository;

abstract readonly class AbstractListener {
    public function __construct(
        protected Configuration $configuration,
        protected Seven $seven,
        protected PersonRepository $personRepository
    ) {
    }

    protected function hasPhone(Person $person): bool {
        $contactNumbers = $person->getAttribute('contact_numbers') ?? [];
        $phone = empty($contactNumbers) ? null : $contactNumbers[0]['value'];
        if (empty($phone)) {
            Log::debug('seven: phone not set for person', $person->toArray());
            return false;
        }

        return true;
    }
}

