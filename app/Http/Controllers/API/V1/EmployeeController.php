<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    protected $employee;
    // protected $pharmacyId;

    public function __construct(EmployeeService $employee)
    {
        $this->employee = $employee;
        // $this->pharmacyId = auth('sanctum')->user()->pharmacy_id;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employee = $this->employee->index($request);

        return $this->respondSuccess($employee, 'Employee Retrieved Successfully');
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
    public function store(StoreEmployeeRequest $request, Employee $employee)
    {
        if (hasExceededQuota(get_class($employee))) {
            return $this->respondExpireLimit();
        }
        try {
            DB::beginTransaction();
            if (! empty(auth('sanctum')->user()->pharmacy_id)) {
                $request['pharmacy_id'] = auth('sanctum')->user()->pharmacy_id;
            }
            $employee = $this->employee->store($request, $employee);
            DB::commit();

            return $this->respondCreated($employee, 'employee Created Successfully');
        } catch (\Throwable $e) {
            DB::rollback();

            return error_exception($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $employee = $this->employee->show($employee);

        return $this->respondSuccess($employee, 'employee Details Retrive');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {

        return $this->respondSuccess($employee, 'Employee Retrive successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        try {
            $this->employee->update($request, $employee);

            return $this->respondSuccess($employee, 'employee Updated Successfully');
        } catch (\Throwable $e) {
            return error_exception($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        if ($employee) {
            if (auth('sanctum')->user()->pharmacy_id == $employee->pharmacy_id && $employee->name !== 'Walking employee') {

                $employee->delete();

                return $this->respondDelete('employee Deleted Successfully');
            } else {
                return $this->respondDelete("This employee Can't Deletabel");
            }
        } else {
            return $this->respondNotFound('employee Not Found');
        }
    }
}
