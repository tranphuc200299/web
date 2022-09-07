<?php

namespace Modules\Customer\Http\Controllers\Web;

use Core\Facades\Breadcrumb\Breadcrumb;
use Core\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Customer\Services\CustomerService;

class CustomerController extends Controller
{
    private $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;

    }

    public function index()
    {
        Breadcrumb::push(trans('customer::text.customer management'), route('cp.customers.index'));
        $assign['list'] = $this->customerService->getAllCustomer([]);

        return view('customer::customer.index', $assign);
    }

    public function destroy(Request $request)
    {
        if ($request->id) {
            $this->customerService->deleteMultiCustomer($request->id);
            return true;
        }

        return false;
    }

    public function deleteAll(Request $request)
    {
        $this->customerService->deleteAll();
        return redirect()->route('cp.customers.index')->with('fail', trans('core::message.notify.delete success'));
    }

    public function export()
    {
        $this->customerService->export();
        die;
    }

}
