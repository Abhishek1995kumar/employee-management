<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RolePermission extends Model {
    use HasFactory;

    protected $table = 'role_permission';
    protected $guarded = [];

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function permission() {
        return $this->belongsTo(Permission::class);
    }

    static function getPermission($permission, $roleId) {
        // $rolePermission = DB::select("SELECT rp.id
        //                                 FROM role_permission rp
        //                                 JOIN permissions p ON p.id = rp.permission_id
        //                                 WHERE p.name = ? and rp.role_id = ?
        //                     ", [$permission, $roleId]);
        // if ($rolePermission) {
        //     $permissionIds = explode(',', $rolePermission->permission_id);
        //     $permissions = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();
        //     return $permissions;
        // }

        $count = DB::table('role_permission')
                    ->join('permissions', 'permissions.id', '=', 'role_permission.permission_id')
                    ->where('permissions.name', $permission)
                    ->where('role_permission.role_id', $roleId)
                    ->count();
                    
    }
}
