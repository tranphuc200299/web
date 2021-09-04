<?php

namespace Develops\_R\Http\Controllers\Web;

use Core\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Develops\_R\Entities\Models\Entities;
use Develops\_R\Services\GeneratorService;
use Develops\_R\Services\PackageControlService;

class BuilderController extends Controller
{
    /**
     * @var GeneratorService
     */
    private $generatorService;

    /**
     * @var PackageControlService
     */
    private $packageControlService;

    public function __construct(GeneratorService $generatorService, PackageControlService $packageControlService)
    {
        $this->generatorService = $generatorService;
        $this->packageControlService = $packageControlService;
    }

    public function create()
    {
        $assign = [];
        if (Session::get('data')) {
            $assign['config'] = Session::get('data');
        }

        return view('r::builder.create', $assign);
    }

    public function relation_field_template()
    {
        $assign['entities'] = Entities::all();

        return view('r::builder.relation-field-template', $assign);
    }

    public function field_template()
    {
        $assign['entities'] = Entities::all();

        return view('r::builder.field-template', $assign);
    }

    public function get_field_list(Request $request)
    {
        $model = $request->get('model');

        $entity = Entities::where('name', $model)->first();

        if ($entity && !empty($entity->config_json['fields'])) {
            $data = collect($entity->config_json['fields'])->pluck('name')->toArray();
            $response = [];
            foreach ($data as $field) {
                $response[] = [
                    'id'   => $field,
                    'text' => $field,
                ];
            }

            return $response;
        }

        return [];
    }

    public function generator_builder_generate()
    {
        $entity = Entities::where('name', request()->get('modelName'))->first();
        if ($entity) {
            $this->packageControlService->rollback($entity->module_name);
        }

        $entity = $this->generatorService->build();

        return json_encode([
            'status' => 'OK',
            'message' => "Generate ".request()->get('modelName')." successfully",
            'entity' => $entity,
            'url' => route('r.entities.edit', $entity->id),
            'request' => request()->all()
        ]);
    }

    public function preview(Request $request)
    {
        if ($request->hasFile('schemaFile')) {

            $data = json_decode($request->file('schemaFile')->get(), true);

            return redirect()->route('r.builder.create')->with('data', $data);
        }

        return redirect()->back();
    }
}
