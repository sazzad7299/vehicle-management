<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShelfNumberRequest;
use App\Http\Requests\UpdateShelfNumberRequest;
use App\Models\ShelfNumber;
use App\Services\ShelfService;
use Illuminate\Http\Request;

class ShelfNumberController extends Controller
{
    protected $shelfNumber;

    public function __construct(ShelfService $shelfNumber)
    {
        $this->shelfNumber = $shelfNumber;
    }

    public function index(Request $request)
    {
        $shelfNumber = $this->shelfNumber->index($request);

        return $this->respondSuccess($shelfNumber, 'Shelf Retrieved Successfully');
    }

    public function create()
    {
        //
    }

    public function store(StoreShelfNumberRequest $request, ShelfNumber $shelf)
    {
        try {

            $shelf = $this->shelfNumber->store($request, $shelf);

            return $this->respondCreated($shelf, 'Shelf Insert Successfully!!!');
        } catch (\Throwable $e) {
            return $this->respondError($e, 'Shelf Insert Failed');
        }
    }

    public function show(ShelfNumber $shelfNumber)
    {
        //
    }

    public function edit(ShelfNumber $shelfNumber)
    {
        //
    }

    public function update(UpdateShelfNumberRequest $request, ShelfNumber $shelf)
    {
        try {
            $this->shelfNumber->update($request, $shelf);

            return $this->respondSuccess($shelf, 'Type Updated Successfully!!!');
        } catch (\Throwable $e) {
            return $this->respondError($e, 'shelf Update Failed');
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->shelfNumber->delete($id);

            return $this->respondDelete('Shelf Deleted Successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Data Not Found', 'status' => 404], 404);
        } catch (\Throwable $th) {
            return $this->respondError($th, 'Sorry! Something went wrong');
        }
    }

    public function trash(Request $request)
    {
        $data = ShelfNumber::query()->pharmacy()->active()->search($request)->onlyTrashed()->get();

        return response()->json($data, 200);
    }

    public function restore($id)
    {
        ShelfNumber::pharmacy()->where('id', $id)->withTrashed()->restore();

        return response()->json('Restore Successfully!');
    }

    public function forceDelete($id)
    {
        ShelfNumber::pharmacy()->where('id', $id)->withTrashed()->forceDelete();

        return response()->json('Permanent Deteled Successfully!');
    }
}
