<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sodaqo extends Model
{
    use HasFactory;

    protected $appends = ['photo_path','creator'];

    function getPhotoPathAttribute()
    {
        return asset($this->photo);
    }

    function getCreatorAttribute(){
        $user = User::find($this->owner_id);
        if($user->role==1){
            return User::first();
        }else{
            return $user;
        }
    }

}
