<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role() {
        return $this->belongsTo(Admin\Role::class, 'role_id');
    }

    // User → Role → Permission (Many-to-Many through pivot)
    public function permissions() {
        return $this->role->permissions();
    }

    // Direct relation (if you want to eager load in one query)
    public function rolePermissions() {
        return $this->hasManyThrough(
            Admin\Permission::class,
            Admin\RolePermission::class,
            'role_id',         // Foreign key on role_permission table
            'id',              // Foreign key on permissions table
            'role_id',         // Local key on users table
            'permission_id'    // Local key on role_permission table
        );
    }

    public function hasPermissionToRoute1($router) {
        $role = DB::table('roles')->where('id', $this->role_id)->first();
        if ($role && $role->slug === 'super_admin') {
            return [
                'role_id'    => $role->id,
                'role_name'  => $role->name,
                'permissions'=> [[
                    'id'     => 0,
                    'name'   => 'All Permissions',
                    'routes' => ['*'] // * matlab sab routes
                ]]
            ];
        }
        
        // Step 1: Role ke base par permissions nikaalo
        $permission = DB::select("SELECT
                            rp.role_id,
                            GROUP_CONCAT(DISTINCT rp.permission_id ORDER BY rp.permission_id) AS permission_ids,
                            r.name AS role_name,
                            GROUP_CONCAT(DISTINCT p.name ORDER BY p.name SEPARATOR ', ') AS permission_names
                        FROM role_permission rp
                        JOIN roles r ON r.id = rp.role_id
                        JOIN permissions p ON FIND_IN_SET(p.id, rp.permission_id) > 0
                        WHERE rp.role_id = ?
                        GROUP BY rp.role_id, r.name
                    ", [$this->role_id]
                );
        
        if (empty($permission)) {
            return null;
        }
        $row = $permission[0]; // ek role ke liye ek hi row aayegi

        // Step 2: Permissions ko tod lo
        $permissionIds   = explode(',', $row->permission_ids);
        $permissionNames = explode(', ', $row->permission_names);

        // Step 3: Har permission ke liye uske routes collect karo
        $finalPermissions = [];
        foreach ($permissionIds as $index => $perId) {
            $routes = DB::select("
                SELECT rop.route_name
                FROM route_permission rop
                WHERE rop.permission_id = ?
            ", [(int) $perId]);
            
            // routes ko array me convert karo
            $routeNames = array_map(fn($r) => $r->route_name, $routes);
            $finalPermissions[] = [
                'id'     => (int) $perId,
                'name'   => $permissionNames[$index] ?? null,
                'routes' => $routeNames
            ];
        }
        
        // Step 4: Final structured result return karo
        return [
            'role_id'    => $row->role_id,
            'role_name'  => $row->role_name,
            'permissions'=> $finalPermissions
        ];
        
    }


    static function hasPermissionToRoute($router) {
        $role = DB::table('roles')->where('id', Auth::user()->role_id)->first();
        if ($role && $role->slug === 'super_admin') {
            return true;
        }

        // Step 1: Role ke base par permissions nikaalo
        $permissions = DB::select("SELECT rp.permission_id, p.name permission_name
                                FROM role_permission rp
                                JOIN permissions p ON p.id = rp.permission_id
                                WHERE rp.role_id = ?
                            ", [4]
                        );
                        
        if (empty($permissions)) {
            return false;
        }
        
        // Step 2: Har permission ke liye uske routes collect karo aur router se match karo
        foreach ($permissions as $per) {
            $routes = DB::select("SELECT rop.route_name
                                FROM route_permission rop
                                WHERE rop.permission_id = ?
                            ", [$per->permission_id]
                        );
            foreach ($routes as $r) {
                if (\Str::is($r->route_name, $router)) {
                    return true;
                }
            }
        }

        return false;
    }


    public function hasPermission($permissionName) {
        $role = DB::table('roles')->where('id', $this->role_id)->first();

        if ($role && $role->slug === 'super_admin') {
            return true;
        }

        return DB::table('role_permission')
            ->where('role_id', $this->role_id)
            ->where('permission_name', $permissionName)
            ->exists();
    }


    public function department() {
        return $this->belongsTo(Admin\Department::class, 'department_id', 'id');
    }

    public function designation() {
        return $this->belongsTo(Admin\Designation::class, 'designation_id', 'id');
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy() {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function deletedBy() {
        return $this->belongsTo(User::class, 'deleted_by', 'id');
    }

    public function attendance() {
        return $this->hasMany(Admin\Attendance::class, 'user_id', 'id');
    }
}
