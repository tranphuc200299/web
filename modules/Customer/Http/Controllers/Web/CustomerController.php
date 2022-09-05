<?php

namespace Modules\Customer\Http\Controllers\Web;

use Core\Facades\Breadcrumb\Breadcrumb;
use Core\Http\Controllers\Controller;
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
        Breadcrumb::push('集計一覧', route('cp.customers.index'));
        $assign['list'] = $this->customerService->getAll([]);

       return view('customer::customer.index',$assign);
    }

}
