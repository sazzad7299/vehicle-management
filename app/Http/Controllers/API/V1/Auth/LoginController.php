<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    const AUTH_TOKEN = 'pharmacy';

    /**
     * Handle the incoming request.
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user->token = $user->createToken(self::AUTH_TOKEN)->plainTextToken;
            $user->load('roles:id,name');
            $user->load('pharmacy');
            $data = [
                'pharmacy_id' => $user->pharmacy_id,
                'user_id' => $user->id,
                'model_id' => $user->id,
                'model_name' => 'User',
                'activity_type' => 'Login',
                'activity' => 'Login successfully!',
            ];

            ActivityLog::create($data);

            return $this->respondSuccess($user, 'Login successful');

        }

        return $this->respondUnAuthorized('Invalid credentials');
    }

    public function forgotPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);
        try {

            $user = User::where('email', $request->email)->first();
            if ($user) {
                $token = Str::random(60);
                $data['email'] = $user->email;
                $data['name'] = $user->name;
                $encryptedEmail = encrypt($user->email);
                $url = 'http://pharmacy.amarlodge.com/reset-password?token='.$token.'&email='.$encryptedEmail;
                $data['url'] = $url;
                Mail::send('emails.resetpassword', ['data' => $data], function ($message) use ($data) {
                    $message->from('mypharmacity@gmail.com', 'MyPharmacity');
                    $message->sender('mypharmacity@gmail.com', 'MyPharmacity');

                    $message->to($data['email'], $data['email']);

                    $message->subject('Reset Your Password');

                    $message->priority(3);
                });
                $datetime = Carbon::now()->format('Y-m-d H:i:s');
                PasswordReset::updateOrCreate(
                    ['email' => $user->email],
                    [
                        'email' => $user->email,
                        'token' => $token,
                        'created_at' => $datetime,
                    ]
                );
                $data = [
                    'pharmacy_id' => $user->pharmacy_id,
                    'user_id' => $user->id,
                    'model_id' => $user->id,
                    'model_name' => 'User',
                    'activity_type' => 'Login',
                    'activity' => 'Reset Password successfully!',
                ];
                ActivityLog::create($data);

                return $this->respondSuccess($user, 'Reset Email send to your mail');
            }

        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8|same:password',
        ]);
        try {
            if ($request->has('token') && $request->has('email')) {
                $email = decrypt(request()->input('email'));
                $token = PasswordReset::where('email', $email)->where('token', $request->token)->first();
                if ($token) {
                    $password = Hash::make($request->password);
                    $user = User::where('email', $email)->first();
                    $user->update([
                        'password' => $password,
                    ]);
                    $token->delete();

                    return $this->respondSuccess(null, 'Password Reset Successfully');
                } else {
                    return $this->respondError('Your reset token is invalid');
                }

            }
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }
    }
}
