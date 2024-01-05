<?php

namespace App\Rules;

use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Contracts\Validation\Rule;

class MonthlySalaryValidation implements Rule
{
    protected $employeeId;

    protected $paid;

    protected $date;

    public function __construct($employeeId, $paid, $date)
    {
        $this->employeeId = $employeeId;
    }

    public function passes($attribute, $value)
    {
        $employee = Employee::where('id', $this->employeeId)->where('status', 1)->first();
        if (! $employee) {
            return false;
        }
        $employeeService = new EmployeeService;
        $pastPaid = $employeeService->paidSalary($employee, $this->date);
        $payable = $employee->salary - $pastPaid;
        if ($this->paid > $payable) {
            return false;
        } else {
            return strtotime($value) >= strtotime($employee->joining_date);
        }

    }

    public function message()
    {
        return 'You can\'t pay salary this month';
    }
}
