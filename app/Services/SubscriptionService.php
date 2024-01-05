<?php

namespace App\Services;

use App\Models\Pharmacy;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;

class SubscriptionService
{
    public function index($request)
    {
        $subscription = Subscription::query()->with('pharmacy:id,company_name', 'plan:id,name')
            // ->when(request()->get('search'), function ($query) {
            //     return $query->search(request()->get('search'));
            // })
            ->latest();
        if ($request->type && $request->type != null) {
            $subscription->where('type', $request->type);
        }
        if ($request->has('paginate')) {
            $subscription = $subscription->get();
        } else {
            $subscription = $subscription->paginate(request()->get('per_page', 10));
        }

        return $subscription;
    }

    public function subscribe($cartData)
    {
        $PlanId = $cartData['id'];
        $plan = Plan::where('id', $PlanId)->first();
        $userId = $cartData['userId'];
        $user = User::where('id', $userId)->first();

        if ($cartData['type'] == 'annually') {
            $amount = $plan->annually;
            $totalDays = 365;
            $type = 'annually';
        } else {
            $amount = $plan->monthly;
            $totalDays = 30;
            $type = 'monthly';
        }
        $company = Pharmacy::findOrFail($user->pharmacy_id);
        $currentEndDate = $company->expire_date;
        $endDate = ($currentEndDate && $currentEndDate > now())
            ? Carbon::parse($currentEndDate)->addDays($totalDays)
            : now()->addDays($totalDays);
        \Log::info($endDate);
        Subscription::create([
            'pharmacy_id' => $company->id,
            'plan_id' => $plan->id,
            'type' => $type,
            'price' => $amount,
            'started_at' => now(),
            'expired_at' => $endDate,
        ]);

        $company->update([
            'expire_date' => $endDate,
            'plan_id' => $plan->id]);

        return $amount;
    }
}
