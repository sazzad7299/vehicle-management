<?php

namespace App\Observers;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GlobalObserve
{
    public function created(Model $model)
    {
        $this->logActivity($model, 'created');
    }

    public function updated(Model $model)
    {
        $this->logActivity($model, 'updated');
    }

    public function deleted(Model $model)
    {
        $this->logActivity($model, 'deleted');
    }

    private function addSpacesBeforeCapitalLetters($string)
    {
        return preg_replace('/(?<!\ )[A-Z]/', ' $0', $string);
    }

    protected function logActivity(Model $model, string $activityType, $activity = null)
    {
        $activity = $activity ?? $this->addSpacesBeforeCapitalLetters(class_basename($model)).' '.$activityType.' Successfully';
        ActivityLog::create([
            'pharmacy_id' => Auth::user()->pharmacy_id,
            'user_id' => Auth::id(),
            'model_id' => $model->id,
            'model_name' => get_class($model),
            'activity_type' => $activityType,
            'activity' => $activity,
            'extra_info' => $this->formatExtraInfo($model),
        ]);
    }

    protected function formatExtraInfo(Model $model): string
    {
        // Customize this method based on the extra information you want to include
        return json_encode($model->toArray());
    }
}
