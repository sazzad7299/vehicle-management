<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeSalaryRequest;
use App\Http\Requests\UpdateEmployeeSalaryRequest;
use App\Models\Employee;
use App\Models\EmployeeSalary;
use App\Services\EmployeeService;
use Illuminate\Http\Request;

class EmployeeSalaryController extends Controller
{
    protected $employee;

    public function __construct(EmployeeService $employee)
    {
        $this->employee = $employee;
    }

    public function index(Request $request)
    {
        $salary = $this->employee->salary($request);

        return $this->respondSuccess($salary, 'Salary Retrieved Successfully');
    }

    public function getPaidSalary(Employee $employee, $date)
    {

        $salary = $this->employee->paidSalary($employee, $date);

        return $this->respondSuccess($salary, 'Salary Retrieved Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeSalaryRequest $request, EmployeeSalary $salary)
    {
        $salary = $this->employee->storeSalary($salary, $request);

        return $this->respondSuccess($salary, 'Salary Retrieved Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeSalary $employeeSalary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeSalary $employeeSalary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeSalaryRequest $request, EmployeeSalary $employeeSalary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeSalary $employeeSalary)
    {
        //
    }
}
