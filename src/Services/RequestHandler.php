<?php

namespace Seven\Krayin\Services;

use Illuminate\Http\Request;

readonly class RequestHandler {
    public function __construct(public Request $request) {
    }

    public function buildSmsParams(): array {
        return [
            'flash' => $this->request->post('flash') === '1',
            'from' => $this->request->post('from'),
            'performance_tracking' => $this->request->post('performance_tracking') === '1',
            'text' => $this->request->post('text')
        ];
    }

    public function validateSmsParams(): void {
        $this->request->validate([
            'from'  => [
                //'regex:/^([+]?[0-9]{1,16}|[a-zA-Z0-9 \-_+/()&$!,.@]{1,11})$/' // TODO
            ],
        ]);
    }
}
