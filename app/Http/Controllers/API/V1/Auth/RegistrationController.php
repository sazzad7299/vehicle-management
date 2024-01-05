<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Models\Customer;
use App\Models\PaymentMethod;
use App\Models\Pharmacy;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    const AUTH_TOKEN = 'pharmacy';

    public function __invoke(RegistrationRequest $request)
    {
        try {
            DB::beginTransaction();

            $pharmacy = Pharmacy::create([
                'company_name' => $request->pharmacy_name,
                'mobile_no' => $request->pharmacy_phone,
                // 'expire_date' => '2024-11-23',
                // 'plan_id' => 18,
            ]);
            $user = User::create([
                'pharmacy_id' => $pharmacy->id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->pharmacy_phone,
                'password' => bcrypt($request->password),
            ]);
            $customer = Customer::create([
                'pharmacy_id' => $pharmacy->id,
                'name' => 'Walking Customer',
            ]);
            $cash = PaymentMethod::create([
                'pharmacy_id' => $pharmacy->id,
                'name' => 'Cash',
                'descirption' => 'Cash Drawer',
            ]);
            $role = Role::query()->where('name', 'owner')->firstOrFail();
            $user->roles()
                ->attach(
                    $role->id,
                    [
                        'model_type' => get_class($user),
                    ]);
            event(new Registered($user));
            DB::commit();
            $user->token = $user->createToken(self::AUTH_TOKEN)->plainTextToken;
            $user->load('roles:id,name');
            $user->load('pharmacy');

            return $this->respondCreated($user, 'User Registration successful');
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->respondInternalError($th->getMessage());
        }

    }
}
