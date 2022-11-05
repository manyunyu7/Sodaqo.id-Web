<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationAccount extends Model
{
    use HasFactory;

    protected $appends = ['merchantNames','merchant_detail','merchant_photo'];

    public function getMerchantNamesAttribute()
    {
        return $this->getMerchantNames();
    }

    public function getMerchantPhotoAttribute(){
        return $this->getMerchantDetailAttribute()->photo_path;
    }

    public function getMerchantDetailAttribute()
    {
        return PaymentMerchant::find($this->payment_merchant_id);
    }

    public function getMerchantNames()
    {
        $merchants = PaymentMerchant::find($this->payment_merchant_id);
        if ($merchants==null)
            return "";
        return $merchants->name;
    }
}
