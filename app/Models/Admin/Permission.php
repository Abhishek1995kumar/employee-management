<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'permissions';
    protected $guarded = [];
    
    public function roles() {
        return $this->belongsToMany(
            Role::class,
            'role_permission',
            'permission_id',
            'role_id'
        );
    }

    public function routes() {
        return $this->hasMany(RoutePermission::class, 'permission_id');
    }

    
}
