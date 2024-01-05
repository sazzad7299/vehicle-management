<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMedicineRequest;
use App\Models\Medicine;
use App\Models\PurchaseDetails;
use App\Services\MedicineService;
use App\Traits\ImageUpload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MedicineController extends Controller
{
    use ImageUpload;

    protected $medicine_service;

    public function __construct(MedicineService $medicine_service)
    {
        $this->medicine_service = $medicine_service;
    }

    public function index(Request $request)
    {
        $leaf = $this->medicine_service->index($request);

        //  return $leaf;
        return $this->respondSuccess($leaf, 'Vehicles Retrieved Successfully');
    }

    public function create()
    {
        //
    }

    public function store(StoreMedicineRequest $request, Medicine $medicine)
    {
        // return $request->all();
        try {
            $this->medicine_service->store($request, $medicine);

            return $this->respondCreated($medicine, 'Vehicles Insert Successfully!!!');
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }
    }

    public function show(Medicine $medicine)
    {
        return $this->respondSuccess($medicine, 'Vehicles Retrieved Successfully');
    }

    public function edit(Medicine $medicine)
    {
        return $medicine;
    }

    public function update(Request $request, Medicine $medicine)
    {
        // return $request->all();
        try {
            $this->medicine_service->update($request, $medicine);

            return $this->respondSuccess($medicine, 'Vehicles Insert Successfully!!!');
        } catch (\Throwable $e) {
            return $this->respondError($e->getMessage());
        }
    }

    public function destroy(Medicine $medicine)
    {
        try {
            $this->medicine_service->delete($medicine);

            return $this->respondDelete('Vehicles Deleted Successfully');
        } catch (\Throwable $th) {
            return $this->respondError('Something Went wrong,Try Again!');
        }
    }

    public function trash(Request $request)
    {
        $data = Medicine::query()->pharmacy()->active()->search($request)->onlyTrashed()->get();

        return response()->json($data, 200);
    }

    public function restore($id)
    {
        Medicine::pharmacy()->where('id', $id)->withTrashed()->restore();

        return response()->json('Restore Successfully!');
    }

    public function forceDelete($id)
    {
        $data = Medicine::pharmacy()->findOrFail($id);
        if (file_exists($data->image)) {
            unlink($data->image);
        }
        $data->withTrashed()->forceDelete();

        return response()->json('Permanent Deteled Successfully!');
    }

    public function get_medicine_By_barcode($barcode)
    {
        try {
            $medicine = Medicine::where('barcode', $barcode)->select(['id', 'name', 'barcode'])->first();
            if (! isset($medicine)) {
                $validator = Validator::make([], []);
                $validator->errors()->add('product_sku', 'Product not found');
                throw new ValidationException($validator);
            }

            return $this->respondSuccess($medicine, 'Medicine Retrieved Successfully');
        } catch (\Throwable $th) {
            return $this->respondNotFound('Item Not Found');
        }
    }

    public function get_by_content($content)
    {
        $data = $content;
        $medicines = Medicine::when($data, function ($query) use ($data) {
            $query->where('name', 'like', '%'.$data.'%')
                ->orWhere('generic', 'like', '%'.$data.'%');
        })
            ->select('name', 'barcode', 'generic')
            ->get();

        return $this->respondSuccess($medicines, 'Medicine Retrieved Successfully');
    }

    public function get_stock_by_barcode($barcode)
    {
        try {
            $medicine = Medicine::where('barcode', $barcode)->select(['id', 'name', 'barcode'])->first();

            if (! isset($medicine)) {
                $validator = Validator::make([], []);
                $validator->errors()->add('product_sku', 'Product not found');
                throw new ValidationException($validator);
            }
            $currentDate = Carbon::now();
            $totalStockByBatch = PurchaseDetails::where('medicine_id', $medicine->id)
                ->select('expire_date')
                ->whereDate('expire_date', '>=', $currentDate)
                ->groupBy('expire_date')
                ->whereRaw('(quantity + s_return) - (sale + p_return) > 0')
                ->get();
            // DB::raw('MAX(mrp) as highest_mrp'), DB::raw('SUM(quantity) as total_quantity')
            $medicine->stock_by_batch = $totalStockByBatch;

            return $this->respondSuccess($medicine, 'Medicine Retrieved Successfully');
        } catch (\Throwable $th) {
            return $this->respondNotFound('Item Not Found');
        }
    }

    public function get_stock_by_expiredate(Request $request)
    {
        $totalStockByBatch = PurchaseDetails::where('medicine_id', $request->medicine_id)
            ->where('expire_date', $request->expire_date)
            ->selectRaw('SUM((quantity + s_return )- (sale + p_return)) as total_quantity, MAX(mrp) as max_mrp')
            ->first();

        return $this->respondSuccess($totalStockByBatch, 'Medicine Retrieved Successfully');
    }
}
