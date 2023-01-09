<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class tinymceEditor extends Component
{
    public $value;
    public $fieldName;
    public $label;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($fieldName, $label, $value = '')
    {
        $this->fieldName = $fieldName;
        $this->label = $label;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.tinymce-editor')->with(['value',$this->value,'fieldName'=>$this->fieldName,'label'=>$this->label]);
    }
}
