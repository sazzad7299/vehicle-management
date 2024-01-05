<?php

namespace App\Services;

use App\Traits\ImageUpload;

class PharmacyService
{
    use ImageUpload;

    public function store($request, $pharmacy)
    {
        $data = $request->validated();
        $logo = $request->logo;
        if ($logo) {
            $data['logo'] = $this->base64FileStore($logo, 'images/pharmacy/', \Str::slug($request->company_name));
        }
        $pharmacy->fill($data)->save();
        $user = auth('sanctum')->user();

        // $user->update([
        //     'pharmacy_id' => $pharmacy->id,
        // ]);
        return $pharmacy;

    }

    public function update($request, $pharmacy)
    {
        $data = $request->validated();
        $logo = $request->logo;
        if ($logo) {
            $data['logo'] = $this->base64FileStore($logo, 'images/pharmacy/', \Str::slug($request->company_name));
        }
        $pharmacy->fill($data)->save();

        return $pharmacy;
    }
}
