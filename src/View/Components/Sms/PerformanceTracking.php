<?php

namespace Seven\Krayin\View\Components\Sms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PerformanceTracking extends Component
{
    public function __construct()
    {}

    public function render(): View|Closure|string
    {
        return view('seven::components.sms.performance-tracking');
    }
}
