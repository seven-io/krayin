<?php

namespace Seven\Krayin\View\Components\Sms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Seven\Krayin\Services\Configuration;

class From extends Component
{
    public function __construct(protected readonly Configuration $configuration)
    {}

    public function render(): View|Closure|string
    {
        $smsFrom = $this->configuration->getSmsFrom();
        return view('seven::components.sms.from', compact('smsFrom'));
    }
}
