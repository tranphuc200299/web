<?php

namespace Develops\_R\Http\Controllers\Web;

use Core\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Develops\_R\Entities\Models\Entities;
use Develops\_R\Services\GeneratorService;
use Develops\_R\Services\PackageControlService;

class EntitiesController extends Controller
{
    protected $generatorService;
    protected $packageControlService;

    public function __construct(GeneratorService $generatorService, PackageControlService $packageControlService)
    {
        $this->generatorService = $generatorService;
        $this->packageControlService = $packageControlService;
    }

    public function index()
    {
        $assign['listEntities'] = Entities::all();

        return view('r::entities.index', $assign);
    }

    public function edit($id)
    {
        $entity = Entities::find($id);

        if (empty($entity)) {
            return redirect(route('r.index'));
        }

        $assign['config'] = $entity->config_json;
        $assign['entity'] = $entity;

        return view('r::builder.create', $assign);
    }

    public function migrate($id)
    {
        $entity = Entities::find($id);
        $status = false;

        if ($entity) {
            $allEntities = Entities::where('module_name', $entity->module_name)->get();

            foreach ($allEntities as $e) {
                $e->status = 2;
                $e->save();
            }

            $status = $this->packageControlService->migrate($entity->module_name);
        }

        if ($status) {
            return redirect()->back()->with('success', 'Migrate successfully');
        }

        return redirect()->back()->with('fail', 'Migrate fail');
    }

    public function rollback($id)
    {
        $entity = Entities::find($id);

        if ($entity) {
            $allEntities = Entities::where('module_name', $entity->module_name)->get();
            foreach ($allEntities as $e) {
                $e->status = 1;
                $e->save();
            }

            $this->packageControlService->rollback($entity->module_name);
        }

        return redirect()->back()->with('warning', 'Rollback database successfully');
    }

    public function destroy($id)
    {
        $entity = Entities::find($id);
        if ($entity) {
            $this->packageControlService->destroy($entity->module_name, $entity->name);
            $entity->delete();
        }

        return redirect()->back()->with('fail', 'Rollback and destroy source code successfully');
    }

    public function factory($id)
    {
        $entity = Entities::find($id);
        if ($entity) {
            for ($i = 0; $i <= 19; $i++) {
                factory('Modules\\'.$entity->module_name.'\\Entities\\Models\\'.$entity->name.'Model')->create();
            }

            return redirect()->back()->with('info', 'Create new 20 items '.$entity->name);
        }

        return redirect()->back()->with('info', 'Entity not found!');
    }
}
