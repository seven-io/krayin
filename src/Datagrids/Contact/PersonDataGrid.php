<?php

namespace Sms77\Krayin\Datagrids\Contact;

use Webkul\Admin\DataGrids\Contact\PersonDataGrid as BaseDataGrid;

class PersonDataGrid extends BaseDataGrid {
    /**
     * Prepare actions.
     * @return void
     */
    public function prepareActions() {
        parent::prepareActions();

        $this->addAction([
            'method' => 'GET',
            'icon' => 'sms77-icon',
            'route' => 'admin.sms77.sms',
            'title' => trans('sms77::app.send_sms'),
        ]);
    }
}