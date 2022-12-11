<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSodaqo extends Model
{
    protected $appends = ['photo_path','user_detail','donation_account',"merchant"];
    use HasFactory;


    function getMerchantAttribute(){

    }

    function getDonationAccountAttribute(){
        return DonationAccount::find($this->payment_id);
    }

    function getPhotoPathAttribute()
    {
        return asset($this->photo);
    }


    function getUserDetailAttribute(){
        $user = User::find($this->user_id);
        return $user;
    }
}
