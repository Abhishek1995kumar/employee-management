<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DynamicFormComponent extends Component {
    public $fields, $method, $types, $ids, $action, $button;

    public function __construct($fields, $method = 'POST', $types = [], $ids = [], $action = '', $button = 'submit') {
        $this->fields = $fields;
        $this->method = $method;
        $this->types = $types;
        $this->ids = $ids;
        $this->action = $action;
        $this->button = $button;
    }


    protected function validationCheck() {
        foreach ($this->fields as $field) {
            if (empty($field)) {
                return false;
            }
        }
        return true;
    }


    public function render(): View|Closure|string {
        return view('components.dynamic-form-component');
    }
}
