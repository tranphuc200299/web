<?php

namespace Modules\Auth\Http\Controllers\Web;

use Core\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Modules\Auth\Constants\AuthConst;
use Modules\Auth\Entities\Models\Role;
use Modules\Auth\Entities\Models\User;
use Modules\Auth\Services\UserService;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $assign['users'] = $this->userService->paginate(['with_load' => ['roles']]);

        return view('auth::user.index', $assign);
    }

    public function backToMainUser()
    {
        if (Session::get('adminId')) {
            Auth::loginUsingId(Session::get('adminId'));

            return redirect()->route('cp.users.index');
        }

        return redirect()->route('cp');
    }

    public function loginAsUser(User $user)
    {
        Auth::loginUsingId($user->id);

        return redirect()->route('cp');
    }

    public function create()
    {
        $assign['roles'] = Role::all();

        return view('auth::user.create', $assign);
    }

    public function store(Request $request)
    {
        $data = $request->only(['name', 'email', 'password']);
        $data['password'] = Hash::make($data['password']);

        /* @var $user User */
        $user = $this->userService->create($data);

        $user->assignRole($request->get('role_id'));

        return redirect()->route('cp.users.index');
    }

    public function show($id)
    {
        /* @var $assign ['user'] User */
        $assign['user'] = $this->userService->findOr404($id);

        $assign['roles'] = Role::all();
        $assign['user']->loadMissing('roles');

        return view('auth::user.show', $assign);
    }

    public function edit($id)
    {
        /* @var $assign ['user'] User */
        $assign['user'] = $this->userService->findOr404($id);

        $assign['roles'] = Role::all();
        $assign['user']->loadMissing('roles');

        return view('auth::user.edit', $assign);
    }

    public function update($id, Request $request)
    {
        $assign['user'] = $this->userService->findOr404($id);
        $data = $request->only(['name', 'password']);


        if ($data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user = $this->userService->update($id, $data);

        $roleIds = array_filter($request->get('role_id'), function ($value) {
            return !is_null($value) && $value !== '';
        });

        $user->roles()->sync($roleIds);

        return redirect()->route('cp.users.index');
    }

    public function destroy($id)
    {
        $assign['user'] = $this->userService->findOr404($id);
        $assign['user']->loadMissing('roles');

        if (!in_array(AuthConst::ROLE_SUPER_ADMIN, $assign['user']->roles->pluck('name')->toArray())) {
            $assign['user']->delete();
        }

        return redirect()->route('cp.users.index');
    }
}
