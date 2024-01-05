<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use App\Models\Subscription;
use App\Services\SubscriptionService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    protected $subsService;

    public function __construct(SubscriptionService $subsService)
    {
        $this->subsService = $subsService;
    }

    public function index(Request $request)
    {
        $subscription = $this->subsService->index($request);

        return $this->respondSuccess($subscription, 'Plans Retrieved Successfully');
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
    public function store(StoreSubscriptionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Subscription $subscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubscriptionRequest $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        //
    }

    public function renew($id)
    {

        $subscription = Subscription::findOrFail($id);
        if ($subscription) {
            // Determine the type of subscription
            $subscriptionType = $subscription->type;

            // Get the current expiration date as a Carbon instance
            $currentExpiredAt = Carbon::parse($subscription->expired_at);

            // Update the expiration date based on the type
            if ($subscriptionType == 'monthly') {
                // For type 1, add 1 month to the expiration date
                $newExpiredAt = $currentExpiredAt > Carbon::now()
        ? $currentExpiredAt->addMonth()
        : Carbon::now()->addMonth();
            } elseif ($subscriptionType == 'annually') {
                // For type 2, add 1 year to the expiration date
                $newExpiredAt = $currentExpiredAt > Carbon::now()
        ? $currentExpiredAt->addYear()
        : Carbon::now()->addYear();
            } else {
                // Handle other types if needed
                // ...
            }

            // Format the new expiration date as "Y-m-d"
            $formattedNewExpiredAt = $newExpiredAt->toDateString();

            // Update the expired_at field in the subscription model
            $subscription->expired_at = $formattedNewExpiredAt;

            // Save the changes to the subscription
            $subscription->save();
        }

        return $this->respondSuccess($subscription, 'Renew Subscription Successfully');
    }
}
