<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\PlanFeatuers;
use App\Traits\ImageUpload;

class PlanService
{
    use ImageUpload;

    public function index($request)
    {
        $planQuery = Plan::query()
            ->when($request->get('search'), function ($query) use ($request) {
                $query->search($request);
            })
            ->when($request->get('status'), function ($query) use ($request) {
                $query->where('status', $request->get('status'));
            });

        if ($request->has('paginate')) {
            $plans = $planQuery->get();
            $plans->each(function ($plan) {
                $plan->makeHidden('created_by', 'updated_by', 'deleted_at', 'created_at', 'updated_at');
            });

            return $plans->load('features:id,plan_id,title');
        } else {
            $plans = $planQuery->paginate($request->get('per_page', 10));
            $plans->getCollection()->each(function ($plan) {
                $plan->makeHidden('created_by', 'updated_by', 'deleted_at', 'created_at', 'updated_at');
            });

            return $plans;
        }

    }

    public function store($request)
    {
        $data = $request->validated();
        $image = $request->image;
        if ($image) {
            $data['image'] = $this->base64FileStore($image, 'images/plan/', $request->title);
        }
        $plan = Plan::create($data);

        $dataArray = [];
        \Log::info($request->input('features'));
        foreach ($request->input('features') as $item) {
            $dataArray[] = [
                'plan_id' => $plan->id,
                'title' => $item['title'],
                'model' => $item['model'],
                'quote' => $item['quote'],
            ];
        }
        PlanFeatuers::insert($dataArray);
    }

    public function update($request, $plan)
    {
        $requestedData = $request->all();
        $image = $request->image;
        if ($image) {
            if (file_exists($plan->image)) {
                unlink($plan->image);
            }
            $requestedData['image'] = $this->base64FileStore($image, 'images/plan/', $request->title);
        } else {
            $requestedData = Arr::except($requestedData, ['image']);
        }
        $plan->fill($requestedData)->save();
        foreach ($request->input('features') as $item) {
            if (isset($item['id'])) {
                PlanFeatuers::updateOrInsert(
                    ['id' => $item['id']],
                    [
                        'plan_id' => $plan->id,
                        'title' => $item['title'],
                        'model' => $item['model'],
                        'quote' => $item['quote'],
                    ]
                );
            } else {
                PlanFeatuers::insert([
                    'plan_id' => $plan->id,
                    'title' => $item['title'],
                    'model' => $item['model'],
                    'quote' => $item['quote'],
                ]);
            }
        }
    }

    public function getpharmacyPlan()
    {
        $currentPlanId = auth()->user()->pharmacy->plan_id;
        $plan = Plan::where('id', $currentPlanId)->first();
        $plan->load('features:id,plan_id,title,quote');
        $plan['expired_at'] = auth()->user()->pharmacy->expire_date;

        return $plan;
    }
}
