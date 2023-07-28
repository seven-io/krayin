<?php

namespace Seven\Krayin\Repositories;

use Webkul\Core\Eloquent\Repository;

class SmsRepository extends Repository {
    /**
     * Specify Model class name.
     * @return mixed
     */
    function model() {
        return 'Seven\Krayin\Contracts\Sms';
    }
}
