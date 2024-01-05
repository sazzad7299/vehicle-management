<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePharmacyRequest;
use App\Http\Requests\UpdatePharmacyRequest;
use App\Models\Pharmacy;
use App\Services\PharmacyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PharmacyController extends Controller
{
    protected $pharmacy;

    public function __construct(PharmacyService $pharmacy)
    {
        $this->pharmacy = $pharmacy;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pharmacies = Pharmacy::query()
            ->when(auth('sanctum')->user()->roles->contains('name', 'owner'), function ($query) {
                return $query->where('user_id', auth('sanctum')->user()->id);
            })
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->with(['owner:id,name'])
            ->paginate($request->get('per_page', 10));

        return $this->respondSuccess($pharmacies, 'Pharmacies Retrieved Successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePharmacyRequest $request, Pharmacy $pharmacy)
    {
        try {
            DB::beginTransaction();
            $this->pharmacy->store($request, $pharmacy);
            DB::commit();

            return $this->respondCreated($pharmacy, 'Pharmacy Created Successfully');
        } catch (\Throwable $e) {
            DB::rollback();

            return $this->respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pharmacy = DB::table('pharmacies')
            ->where('pharmacies.id', $id) // Specify the table alias for the 'id' column
            ->leftJoin('countries', 'pharmacies.country', '=', 'countries.id')
            ->leftJoin('divisions', 'pharmacies.division_id', '=', 'divisions.id')
            ->leftJoin('districts', 'pharmacies.district_id', '=', 'districts.id')
            ->leftJoin('upazilas', 'pharmacies.upazilas_id', '=', 'upazilas.id')
            ->leftJoin('unions', 'pharmacies.union_id', '=', 'unions.id')
            ->select('pharmacies.*', 'countries.name as country_name', 'divisions.name as division_name', 'districts.name as district_name', 'upazilas.name as upazilas_name', 'unions.name as union_name')
            ->first();

        if ($pharmacy) {
            return $this->respondSuccess($pharmacy, 'Pharmacies Retrieved Successfully');
        } else {
            // Handle the case where the pharmacy with the specified ID is not found
            return $this->respondNotFound('Pharmacy not found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pharmacy = DB::table('pharmacies')
            ->where('pharmacies.id', $id)->first();
        $pharmacy = [
            'id' => $pharmacy->id,
            'company_name' => $pharmacy->company_name,
            'mobile_no' => $pharmacy->mobile_no,
            'logo' => $pharmacy->logo,
            'website' => $pharmacy->website,
            'country' => (int) $pharmacy->country,
            'division_id' => (int) $pharmacy->division_id,
            'district_id' => (int) $pharmacy->district_id,
            'upazilas_id' => (int) $pharmacy->upazilas_id,
            'union_id' => (int) $pharmacy->union_id,
            'zip_code' => $pharmacy->zip_code,
            'street_address' => $pharmacy->street_address,
            'google_map_location' => $pharmacy->google_map_location,
            'reffer_by_name' => $pharmacy->reffer_by_name,
            'reffer_by_phone' => $pharmacy->reffer_by_phone,
            'status' => $pharmacy->status,
            'note' => $pharmacy->note,

        ];

        return $this->respondSuccess($pharmacy, 'Pharmacies Retrieved Successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePharmacyRequest $request, Pharmacy $pharmacy)
    {

        try {
            DB::beginTransaction();
            $this->pharmacy->update($request, $pharmacy);
            DB::commit();

            return $this->respondCreated($pharmacy, 'Pharmacy Update Successfully');
        } catch (\Throwable $e) {
            DB::rollback();

            return $this->respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pharmacy $pharmacy)
    {
        //
    }
}
