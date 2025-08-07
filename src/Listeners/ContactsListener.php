<?php /** @noinspection PhpUnused */

namespace Seven\Krayin\Listeners;

use Illuminate\Support\Facades\Log;
use Webkul\Contact\Models\Person;

readonly class ContactsListener extends AbstractListener {
    public function afterCreatePerson(Person $person): void {
        if (!$this->hasPhone($person)) return;
        $text = $this->configuration->getPersonCreateAfterText();
        if (empty($text)) {
            Log::debug('seven: text not set for contacts::afterCreatePerson');
            return;
        }

        $from = $this->configuration->getSmsFrom();
        $smsParams = compact('from', 'text');
        $res = $this->seven->sms($smsParams, $person);
        Log::debug('seven: sent message for contacts::afterCreatePerson', $res);
    }
}

