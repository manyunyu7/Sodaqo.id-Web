<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationAccount extends Model
{
    use HasFactory;

    protected $appends = ['merchantNames', 'merchant_detail', 'merchant_photo','merchant_status'];

    public function scopeIsNotDeleted($query)
    {
        return $query->where('status','=',1);
    }

    public function countTransaction(){
        return UserSodaqo::where("payment_id",'=',$this->id)->count();
    }

    public function getMerchantStatusAttribute()
    {
        $merchant = $this->getMerchantDetailAttribute();
        if ($merchant==null) return -99;

        return $merchant->status;
    }

    public function getMerchantNamesAttribute()
    {
        return $this->getMerchantNames();
    }

    public function getMerchantPhotoAttribute()
    {
        if ($this->getMerchantDetailAttribute() != null)
            return $this->getMerchantDetailAttribute()->photo_path;
        else return "";
    }

    public function getMerchantDetailAttribute()
    {
        return PaymentMerchant::find($this->payment_merchant_id);
    }

    public function getMerchantNames()
    {
        $merchants = PaymentMerchant::find($this->payment_merchant_id);
        if ($merchants == null)
            return "";
        return $merchants->name;
    }
}
