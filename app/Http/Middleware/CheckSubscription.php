<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSubscription
{
    use ApiResponse;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {

        try {
            $user = Auth::user();
            if ($user->pharmacy_id === null) {
                return $next($request);
            } elseif (! $user || ! $user->pharmacy || ! $user->pharmacy->expire_date) {
                return response()->json(['message' => 'Youre subscription plan expired. Renew Now', 'status' => 403, 'result' => null], 403);
            } else {
                $endDate = Carbon::parse($user->pharmacy->expire_date)->endOfDay();
                $endDate->addDays(7);
                $today = Carbon::now()->startOfDay();
                if ($today > $endDate) {
                    return response()->json(['message' => 'Youre subscription plan expired. Renew Now', 'status' => 403, 'result' => null], 403);
                }
            }

            return $next($request);
        } catch (Exception $exception) {
            // Log::error($exception->getMessage());

            // return response()->json($exception->getMessage(), 500);
        }
    }
}
