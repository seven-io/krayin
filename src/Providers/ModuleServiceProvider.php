<?php

namespace Sms77\Krayin\Providers;

use Sms77\Krayin\Models\Sms;
use Webkul\Core\Providers\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider {
    protected $models = [
        Sms::class,
    ];
}