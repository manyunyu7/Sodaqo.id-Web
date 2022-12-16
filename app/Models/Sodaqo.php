<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sodaqo extends Model
{
    use HasFactory;

    protected $appends = ['photo_path', 'creator', "isHaveTarget",
        "fundraising_target_formatted","category_name","accumulated_amount"];

    public function scopeIsNotDeleted($query)
    {
        return $query->whereNull('is_deleted');
    }

    function getPhotoPathAttribute()
    {
        return asset($this->photo);
    }

    function getCreatorAttribute()
    {
        $user = User::find($this->owner_id);
        return $user;
    }

    function getCategoryNameAttribute()
    {
        $cat = SodaqoCategory::find($this->id);
        if ($cat!=null){
            return $cat->name;
        }
        return "";
    }


    function getFundraisingTargetFormattedAttribute()
    {
        return number_format($this->fundraising_target, 0, ".", ",");
    }

    function getAccumulatedAmountAttribute()
    {
        $data = UserSodaqo::where([
            ['sodaqo_id', '=', $this->id],
            ['status', '=', 1],
        ])->get();

        // Create an array of the nominal_net values
        $nominalNetValues = [];
        foreach ($data as $item) {
            $nominalNetValues[] = $item->nominal_net;
        }

        // Get the sum of the nominal_net values
        $nominalNetSum = array_sum($nominalNetValues);

        // Use the sum of the nominal_net values
        return $nominalNetSum;
    }

    function getIsHaveTargetAttribute()
    {
        $isHaveTarget = false;
        if (isset($this->fundraising_target) && !empty($this->fundraising_target)) {
            $isHaveTarget = true;
        }
        return $isHaveTarget;
    }


}
