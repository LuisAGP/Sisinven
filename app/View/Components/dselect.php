<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class dselect extends Component
{

    public $name;
    public $id;
    public $url;
    public $defaultValue;
    public $defaultText;

    public function __construct($id, $name, $url, $defaultValue="", $defaultText="")
    {
        $this->id = $id;
        $this->name = $name;
        $this->url = $url;
        $this->defaultValue = $defaultValue;
        $this->defaultText = $defaultText;
    }

    public function render(): View|Closure|string
    {
        return view('components.dselect');
    }
}
