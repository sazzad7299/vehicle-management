<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Models\Type;
use App\Services\TypeService;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    protected $type;

    public function __construct(TypeService $type)
    {
        $this->type = $type;
    }

    public function index(Request $request)
    {
        $type = $this->type->index($request);

        return $this->respondSuccess($type, 'Type Retrieved Successfully');
    }

    public function create()
    {

    }

    public function store(StoreTypeRequest $request, Type $type)
    {
        try {
            $requestedData = $request->all();
            if ($requestedData['status'] === true) {
                $requestedData['status'] = 1;
            }
            $type->fill($requestedData)->save();

            return $this->respondCreated($type, 'Type Insert Successfully!!!');
        } catch (\Throwable$e) {
            return $this->respondError($e, 'Type Insert Failed');
        }
    }

    public function show(Type $type)
    {
        //
    }

    public function edit(Type $type)
    {
        //
    }

    public function update(UpdateTypeRequest $request, Type $type)
    {
        try {
            $requestedData = $request->all();
            if ($requestedData['status'] === true) {
                $requestedData['status'] = 1;
            }
            $type->fill($requestedData)->save();

            return $this->respondSuccess($type, 'Type Updated Successfully!');
        } catch (\Throwable$e) {
            return error_exception($e);
        }
    }

    public function destroy(Type $type)
    {
        $type->delete();

        return $this->respondDelete('Type Deleted Successfully');
    }

    public function trash(Request $request)
    {
        $data = Type::query()->pharmacy()->active()->search($request)->onlyTrashed()->get();

        return response()->json($data, 200);
    }

    public function restore($id)
    {
        Type::pharmacy()->where('id', $id)->withTrashed()->restore();

        return response()->json('Restore Successfully!');
    }

    public function forceDelete($id)
    {
        Type::pharmacy()->where('id', $id)->withTrashed()->forceDelete();

        return response()->json('Permanent Deteled Successfully!');
    }
}
