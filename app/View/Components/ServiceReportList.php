<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ServiceReportList extends Component
{
    public $reports;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($reports)
    {
        $this->reports = $reports;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.service-report-list');
    }
}
