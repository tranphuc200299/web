<?php

namespace Develops\_R\Http\Controllers\Web;

use Core\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Auth\Entities\Models\Role;

class RolesController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        $assign['list'] = Role::all();

        return view('r::roles.index', $assign);
    }

    public function create()
    {
        return view('r::roles.create');
    }

    public function store(Request $request)
    {
        factory(Role::class)->create($request->only(['name', 'description']));

        return redirect(route('r.roles.index'))->with('success', 'Create role successfully');
    }

    public function destroy($id)
    {
        $role = Role::find($id);

        if ($role) {
            $role->delete();
        }

        return redirect()->route('r.roles.index');
    }
}
