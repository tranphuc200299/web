<?php

namespace Modules\Log\Http\Controllers\Web;

use Core\Http\Controllers\Controller;
use Modules\Log\Services\LogService;
use Modules\Log\Entities\Models\LogModel;

class LogController extends Controller
{
    private $logService;

    public function __construct(LogService $logService)
    {
        $this->logService = $logService;

    }

    public function index()
    {
        $assign['list'] = $this->logService->getAll(['with_load' => 'customer']);

        return view('log::log.index', $assign);
    }

//    public function ajaxSearch()
//    {
//        $assign['list'] = $this->logService->ajaxSearch([], 30);
//
//        return json_encode($assign['list']);
//    }

//

    public function destroy(LogModel $Log)
    {
        try {
            $Log->delete();
        } catch (\Exception $e) {

        };

        return redirect()->route("cp.logs.index")->with('success', 'Deleted successfully.');
    }
}
