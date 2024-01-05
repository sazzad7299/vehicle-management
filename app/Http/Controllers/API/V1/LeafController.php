<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeafRequest;
use App\Http\Requests\UpdateLeafRequest;
use App\Models\Leaf;
use App\Services\LeafService;
use Illuminate\Http\Request;

class LeafController extends Controller
{
    protected $leaf;

    public function __construct(LeafService $leaf)
    {
        $this->leaf = $leaf;
    }

    public function index(Request $request)
    {

        $leaf = $this->leaf->index($request);

        //  return $leaf;
        return $this->respondSuccess($leaf, 'Leaf Retrieved Successfully');
    }

    public function create()
    {
        //
    }

    public function store(StoreLeafRequest $request, Leaf $leaf)
    {
        try {
            $this->leaf->store($request, $leaf);

            return $this->respondCreated($leaf, 'Leaf Insert Successfully!!!');
        } catch (\Throwable $th) {
            return $this->respondError($th, 'Leaf Insert Failed');
        }
    }

    public function show(Leaf $leaf)
    {
        //
    }

    public function edit(Leaf $leaf)
    {
        //
    }

    public function update(UpdateLeafRequest $request, Leaf $leaf)
    {
        try {
            $this->leaf->update($request, $leaf);

            return $this->respondSuccess($leaf, 'Type Updated Successfully!!!');
        } catch (\Throwable $e) {
            return $this->respondError($e, 'Leaf Update Failed');
        }
    }

    public function destroy(string $id)
    {

        try {
            $this->leaf->delete($id);

            return $this->respondDelete('Leaf Deleted Successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Data Not Found', 'status' => 404], 404);
        } catch (\Throwable $th) {
            return $this->respondError($th, 'Sorry! Something went wrong');
        }

    }

    public function trash(Request $request)
    {
        $data = Leaf::query()->pharmacy()->active()->search($request)->onlyTrashed()->get();

        return response()->json($data, 200);
    }

    public function restore($id)
    {
        Leaf::pharmacy()->where('id', $id)->withTrashed()->restore();

        return response()->json('Restore Successfully!');
    }

    public function forceDelete($id)
    {
        Leaf::pharmacy()->where('id', $id)->withTrashed()->forceDelete();

        return response()->json('Permanent Deteled Successfully!');
    }
}
