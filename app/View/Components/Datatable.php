<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Datatable extends Component
{
    public $rows;
    public $id;
    public $hideSearchInput;

    /**
     * Create a new component instance.
     */
    public function __construct($rows, $id, $hideSearchInput=false)
    {
        $this->rows = $rows;
        $this->id = $id;
        $this->hideSearchInput = $hideSearchInput; 
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.datatable');
    }
}
