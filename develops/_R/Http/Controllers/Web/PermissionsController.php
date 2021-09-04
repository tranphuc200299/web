<?php

namespace Develops\_R\Http\Controllers\Web;

use Core\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Develops\_R\Entities\Models\Entities;
use Modules\Auth\Entities\Models\Permission;
use Modules\Auth\Entities\Models\Role;

class PermissionsController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        $assign['listRoles'] = Role::with(['permissions'])->get();
        $assign['listEntities'] = Entities::all();
        $assign['listPermissions'] = Permission::all();

        return view('r::permissions.index', $assign);
    }

    public function create()
    {
        return view('r::permissions.create');
    }

    public function sync(Request $request)
    {
        $allRoles = Role::all();
        $roleData = $request->get('roles');
        foreach ($allRoles as $role) {
            if (empty($roleData[$role->id])) {
                $role->permissions()->sync([]);
            } else {
                $permissions = Permission::whereIn('id', $roleData[$role->id])->get();
                $role->permissions()->sync($permissions);
            }
        }

        return redirect()->back();
    }
}
