<?php

namespace Modules\Log\Http\Controllers\Web;

use Core\Facades\Breadcrumb\Breadcrumb;
use Core\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Modules\Log\Services\LogService;

class LogController extends Controller
{
    private $logService;

    public function __construct(LogService $logService)
    {
        $this->logService = $logService;

    }

    public function index(Request $request)
    {
        Breadcrumb::push(trans('log::text.log management home'), route('cp.logs.index'));
        $obj = $request->all();
        $assign['checkDataStart'] = array_key_exists('start_date', $obj);
        $assign['checkDataEnd'] = array_key_exists('end_date', $obj);
        $assign['list'] = $this->logService->getAll($request,['with_load' => 'customer'], 20);

        if ($assign['list']->currentPage() > $assign['list']->lastPage())
            return redirect()->route('cp.logs.index', ['page' => $assign['list']->lastPage()]);

        return view('log::log.index', $assign);
    }

    public function destroy(Request $request)
    {
        if ($request->id) {
            $check = $this->logService->getByListId($request->id);
            $this->logService->deleteMultiRecord($request->id);
            try {
                $response = Http::get(config('api.url_ai') . 'reload-database' );
            }catch (\Exception $e) {

            }
            return response()->json([
                'code' => 200,
                'message' => (count($check) > 0) ? 'レコードが正常に削除されました。' : 'レコードが削除されました。',
                'count' => count($check)
            ]);
        }

        return false;
    }

    public function deleteAll(Request $request)
    {
        $this->logService->deleteAll();
        try {
            $response = Http::get(config('api.url_ai') . 'reload-database' );
        }catch (\Exception $e) {

        }
        return redirect()->route('cp.logs.index')->with('fail', trans('core::message.notify.delete success'));
    }

    public function export(Request $request)
    {
        $this->logService->export($request);
        die;
    }

    public function download(Request $request)
    {
        return $this->logService->download($request);
    }
}
