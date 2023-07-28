<?php

namespace Seven\Krayin\Providers;

use Seven\Krayin\Models\Sms;
use Webkul\Core\Providers\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider {
    protected $models = [
        Sms::class,
    ];
}
