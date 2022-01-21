<?php

namespace Sms77\Krayin\Exception;

use InvalidArgumentException;

class UnprocessableEntityTypeException extends InvalidArgumentException {
    /**
     * Create a new exception instance.
     * @param string $type
     * @param mixed $id
     * @return void
     */
    public function __construct($type, $id) {
        $id = (string)$id;

        parent::__construct(
            'Unprocessable entity type [' . $type . '] for ID [' . $id . '].');
    }
}
