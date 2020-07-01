<?php

namespace App\View\Components;

use Illuminate\View\Component;

class UploadList extends Component
{
    public $files;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($files)
    {
        $this->files = $files;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.upload-list');
    }
}
