<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\EmployeeSalary;
use App\Traits\ImageUpload;
use Illuminate\Support\Arr;

class EmployeeService
{
    use ImageUpload;
    //get employee

    public function index($request)
    {
        $employee = Employee::query()
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            // ->withSum('sales', 'total')
            // ->withSum('sale_payments', 'paid')
            // ->withSum('sale_return', 'price')
            // ->withSum('sale_return', 'returnAmount')
            ->latest();
        if ($request->has('paginate')) {
            return $employee->select('id', 'name', 'phone', 'salary')->get();
        } elseif ($request->has('report')) {
            return $employee->get();
        } else {
            return $employee->paginate(request()->get('per_page', 10));
        }
    }

    //employee store
    public function store($request, $employee)
    {
        $requestedData = $request->all();
        if ($request->has('image')) {
            $images = $request->image;
            if ($images) {
                $requestedData['image'] = $this->base64FileStore($images, 'images/employees/', rand(10000, 99999));
            }
        }
        if ($request->has('status')) {
            if ($requestedData['status'] == false) {
                $requestedData['status'] = 0;
            }
        }

        $employee->fill($requestedData)->save();

        return $employee;
    }

    public function update($request, $employee)
    {
        $requestedData = $request->all();
        $images = $request->image;
        if ($images) {
            if (file_exists($employee->image)) {
                unlink($employee->image);
            }
            $requestedData['image'] = $this->base64FileStore($images, 'images/employee/', rand(10000, 99999));
        } else {
            $requestedData = Arr::except($requestedData, ['image']);
        }
        if ($requestedData['status'] == false) {
            $requestedData['status'] = 0;
        }
        $employee->fill($requestedData)->save();
    }

    public function show($employee)
    {
        // $employee->loadSum('sales', 'total');
        // $employee->loadSum('sale_payments', 'paid');
        // $employee->loadSum('sale_return', 'price');
        // $employee->loadSum('sale_return', 'returnAmount');

        return $employee;

    }

    public function salary($request)
    {
        $salary = EmployeeSalary::query()->with('employee:id,name,phone')
            ->select(
                'id',
                'employee_id',
                \DB::raw('DATE_FORMAT(date, "%Y-%m") as month'),
                \DB::raw('SUM(paid) as totalPaid')
            )
            ->groupBy('employee_id', 'month')
            ->orderBy('employee_id')
            ->orderBy('month', 'desc')
            ->latest();
        if ($request->has('to_date')) {
            $salary->whereDate('date', '<=', $request->input('to_date'));
        }

        // Filter by 'from_date' if provided
        if ($request->has('from_date')) {
            $salary->whereDate('date', '>=', $request->input('from_date'));
        }

        // Filter by 'employee' if provided
        if ($request->has('employee')) {
            $salary->where('employee_id', $request->input('employee'));
        }
        if ($request->has('paginate')) {
            return $salary->select('id', 'name', 'phone')->get();
        } elseif ($request->has('report')) {
            return $salary->get();
        } else {

            return $salary->paginate(request()->get('per_page', 10));
        }

        // $salary = EmployeeSalary::query()->with('paymentMethod:id,name','employee:id,name,phone')
        // ->select(
        //     'id',
        //     'employee_id',
        //     'payment_method_id',
        //     \DB::raw('DATE_FORMAT(date, "%Y-%m") as month'),
        //     \DB::raw('SUM(paid) as totalPaid')
        // )
        // ->groupBy('employee_id', 'payment_method_id', 'month')
    }

    public function paidSalary($employee, $date)
    {
        $yearMonth = date('Y-m', strtotime($date));
        $salaries = EmployeeSalary::where('employee_id', $employee->id)
            ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$yearMonth])
            ->get();

        $totalPaid = $salaries->sum(function ($salary) {
            return (float) $salary->paid;
        });

        return $totalPaid;
    }

    public function storeSalary($salary, $request)
    {
        $requestData = $request->all();
        $requestData['pharmacy_id'] = auth()->user()->pharmacy_id;
        $salary->fill($requestData)->save();

        return $salary;
    }
}
