<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlanRequest;
use App\Models\Plan;
use App\Services\PlanService;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanController extends Controller
{
    use ImageUpload;

    protected $plan;

    public function __construct(PlanService $plan)
    {
        $this->plan = $plan;
    }

    public function index(Request $request)
    {
        $plan = $this->plan->index($request);

        return $this->respondSuccess($plan, 'Plans Retrieved Successfully');
    }

    public function create()
    {
        //
    }

    public function store(StorePlanRequest $request, Plan $plan)
    {
        try {
            DB::beginTransaction();

            $this->plan->store($request);
            DB::commit();

            return $this->respondCreated($plan, 'plan Created Successfully');
        } catch (\Throwable $e) {
            DB::rollBack();

            return $this->respondError($e->getMessage());
        }
    }

    public function show(Plan $plan)
    {
        if ($plan->status == 2) {
            $plan->update(['status' => 1]);
        } else {
            $plan->update(['status' => 2]);
        }

        return $this->respondSuccess($plan, 'Plan Status Changed Successfully');
    }

    public function pharmacyplan()
    {
        $plan = $this->plan->getpharmacyPlan();

        return $this->respondSuccess($plan, 'Plan Retrive Successfully');
    }

    public function edit(Plan $plan)
    {
        $plan = $plan->load('features')->makeHidden('created_by', 'updated_by', 'deleted_at', 'created_at', 'updated_at');

        return $this->respondSuccess($plan, 'Plan Retrieved Successfully');
    }

    public function update(Request $request, Plan $plan)
    {
        try {
            DB::beginTransaction();
            // return $request->all();
            $this->plan->update($request, $plan);
            DB::commit();

            return $this->respondSuccess($plan, 'Plan Updated Successfully');
        } catch (\Throwable $e) {
            DB::rollBack();

            return $this->respondError($e->getMessage());
        }
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();

        return response()->json('Deleted successfully!!');
    }

    public function trash(Request $request)
    {
        $data = Plan::query()->search($request)->active()->onlyTrashed()->get();

        return response()->json($data, 200);
    }

    public function restore($id)
    {
        Plan::where('id', $id)->withTrashed()->restore();

        return response()->json('Restore Successfully!');
    }

    public function forceDelete($id)
    {
        $data = Plan::findOrFail($id);
        if (file_exists($data->image)) {
            unlink($data->image);
        }
        $data->withTrashed()->forceDelete();

        return response()->json('Permanent Deteled Successfully!!!');
    }

    public function modelfile()
    {
        $modelsPath = app_path('Models');
        $models = [];
        // Use the glob function to get all PHP files in the Models directory
        $files = glob($modelsPath.'/*.php');
        foreach ($files as $file) {
            // Extract the class name from the file path
            $className = 'App\\Models\\'.pathinfo($file, PATHINFO_FILENAME);

            // Check if the class exists and is an instance of Eloquent Model
            if (class_exists($className) && is_subclass_of($className, 'Illuminate\Database\Eloquent\Model')) {
                $models[] = $className;
            }
        }

        return response()->json($models, 200);
    }
}
