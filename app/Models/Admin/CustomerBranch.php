<?php

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerBranch extends Model {
    use HasFactory, softDeletes;

    protected $table = 'customer_branches';
    protected $guarded = [];
}
