<?php

namespace App\Http\Controllers;

use App\Models\DonationAccount;
use App\Models\Sodaqo;
use App\Models\SodaqoCategory;
use App\Models\SodaqoTimeline;
use Illuminate\Http\Request;

class MobileSodaqoAllController extends Controller
{

    public function getPaymentAccount(){
        return DonationAccount::where("status","=",1)->get();
    }

    public function getAll(){
        return Sodaqo::all();
    }


    public function getDetailSodaqo(Request $request, $id){
         $sodaqo = Sodaqo::findOrFail($id);
         $cat = SodaqoCategory::find($sodaqo->category_id);
         $categoryName = ""; 
         if($cat!=null){
            $categoryName = $cat->name; 
         }
         $timeline = SodaqoTimeline::where("sodaqo_id","=",$id)->limit(1)->get();
         return response()->json([
            'sodaqo' => $sodaqo,
            'timeline' => $timeline,
            'category_name' => $categoryName,
        ]);
    }


    public function recent(){
        return Sodaqo::all();
    }
}
