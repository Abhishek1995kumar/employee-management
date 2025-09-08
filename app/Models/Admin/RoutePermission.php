<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoutePermission extends Model {
    use HasFactory;
    protected $table = 'route_permission';
    protected $guarded = [];

    public function route() {
        return $this->belongsTo(Role::class);
    }
    
    public function permission() {
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}
