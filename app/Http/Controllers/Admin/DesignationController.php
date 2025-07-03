<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Traits\ValidationTrait;
use App\Http\Controllers\Controller;

class DesignationController extends Controller {
    use ValidationTrait;

    public function create(Request $request) {
        return view('admin.user-management.designations.index');
    }

    public function save(Request $request) {
        $data = $request->all();
        return $this->departmentValidate($data);
    }



}
