<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TinyEditor extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $content;
    public function __construct($content=null)
    {
        $this->content = $content;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tiny-editor')->with('content',$this->content);
    }
}
