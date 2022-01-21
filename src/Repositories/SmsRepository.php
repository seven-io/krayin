<?php

namespace Sms77\Krayin\Repositories;

use Webkul\Core\Eloquent\Repository;

class SmsRepository extends Repository {
    /**
     * Specify Model class name.
     * @return mixed
     */
    function model() {
        return 'Sms77\Krayin\Contracts\Sms';
    }
}