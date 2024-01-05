<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeSalary extends BaseModel
{
    use CreatedUpdatedBy, HasFactory,SoftDeletes;

    protected $table = 'employee_salaries';

    protected $fillable = ['pharmacy_id', 'employee_id', 'payment_method_id', 'paid', 'date'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id')->withDefault([
            'name' => 'Unknow Employee',
            'email' => 'unknown@gmail.com',
            'status' => 0,
            'place' => 'unknown',
            'phone' => 'unknown',
            'address' => 'unknown',
        ]);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
