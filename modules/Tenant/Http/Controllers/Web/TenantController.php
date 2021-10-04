<?php

namespace Modules\Tenant\Http\Controllers\Web;

use Core\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Entities\Mail\NewAccount;
use Modules\Auth\Entities\Models\Role;
use Modules\Auth\Entities\Models\User;
use Modules\Auth\Services\UserService;
use Modules\Tenant\Constants\TenantConst;
use Modules\Tenant\Entities\Models\TenantModel;
use Modules\Tenant\Http\Requests\TenantRequest;
use Modules\Tenant\Services\TenantService;

class TenantController extends Controller
{
    private $tenantService;
    private $userService;

    public function __construct(TenantService $tenantService, UserService $userService)
    {
        $this->tenantService = $tenantService;
        $this->userService = $userService;
    }

    public function index()
    {
        $assign['list'] = $this->tenantService->paginate(['with_load' => ['owner']], 10);

        return view('tenant::tenant.index', $assign);
    }

    public function ajaxSearch()
    {
        $assign['list'] = $this->tenantService->ajaxSearch([], 30);

        return json_encode($assign['list']);
    }

    public function create()
    {
        return view('tenant::tenant.create');
    }

    public function store(TenantRequest $request)
    {
        begin_transaction();

        /* @var $tenant TenantModel */
        $tenant = $this->tenantService->create($request->only(['name', 'email', 'phone', 'address']));

        if (empty($tenant)) {
            return redirect()->back()->with('error', trans('core::error.something is wrong'));
        }

        $tenant->config()->create();

        $dataUser = $request->only(['user.name', 'user.email', 'user.password']);

        $email = $dataUser['user']['email'];
        $password = $dataUser['user']['password'] ?? $this->userService->makePassword();
        $dataUser['user']['password'] = Hash::make($dataUser['user']['password']);

        /* @var $user User */
        $user = $this->userService->create($dataUser['user']);

        if (empty($user)) {
            return redirect()->back()->with('error', trans('core::error.something is wrong'));
        }

        $user->detail()->create(['tenant_id' => $tenant->id]);
        $user->attachRoleByName(TenantConst::ROLE_TENANT_ADMIN);

        commit_transaction();
        activity()->send(new NewAccount($email, $password));

        return redirect()->route('cp.tenants.index')->with('success', trans('core::message.notify.create success'));
    }

    public function show(TenantModel $tenant)
    {
        $assign['model'] = $tenant;
        $assign['id'] = $tenant->id;

        if (empty($assign['model'])) {
            return redirect(route("cp.tenants.index"))->with('error', 'Item not found.');
        }

        return view('tenant::tenant.show', $assign);
    }

    public function edit(TenantModel $tenant)
    {
        $assign['model'] = $tenant;
        $assign['id'] = $tenant->id;

        if (empty($assign['model'])) {
            return redirect(route("cp.tenants.index"))->with('error', 'Item not found.');
        }

        return view('tenant::tenant.edit', $assign);
    }

    public function update(TenantModel $tenant, Request $request)
    {
        $status = $this->tenantService->update($tenant->id, $request->only(['name', 'email', 'phone', 'address']));

        return redirect()->back()->with('success', 'Updated successfully.');
    }

    public function destroy(TenantModel $tenant)
    {
        try {
            $tenant->delete();
        } catch (\Exception $e) {

        };

        return redirect()->route("cp.tenants.index")->with('success', 'Deleted successfully.');
    }
}
