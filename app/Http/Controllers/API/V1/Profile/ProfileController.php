<?php

namespace App\Http\Controllers\API\V1\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function updateInfo(ProfileUpdateRequest $request)
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();
        $user = $request->user();
        $user->token = $request->token;
        $user->load('roles:id,name');
        $user->load('pharmacy');

        return $this->respondSuccess($user, 'ProfileController Updated Successfully!');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return $this->respondSuccess(null, 'Password Updated Successfully!');
    }

    public function loginfo(Request $request)
    {
        // return $request;
        $logs = \DB::table('activity_log_view')->where('user_id', auth()->user()->id)->latest();
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $logs->where(function ($query) use ($searchTerm) {
                $query->where('activity', 'LIKE', '%'.$searchTerm.'%')
                    ->orWhere('activity_type', 'LIKE', '%'.$searchTerm.'%')
                    ->orWhere('extra_info', 'LIKE', '%'.$searchTerm.'%')
                    ->orWhere('user_name', 'LIKE', '%'.$searchTerm.'%')
                    ->orWhere('pharmacy_name', 'LIKE', '%'.$searchTerm.'%');
            });
        }

        if ($request->has('paginate')) {
            return $logs->get();
        } else {
            return $logs->paginate(request()->get('per_page', 10));
        }

        return $this->respondSuccess($logs, 'Employee Retrieved Successfully');
    }

    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
