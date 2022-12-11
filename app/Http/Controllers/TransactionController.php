<?php

namespace App\Http\Controllers;

use App\Models\DonationAccount;
use App\Models\Sodaqo;
use App\Models\UserSodaqo;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function viewManage($id)
    {
        $datas = UserSodaqo::where("sodaqo_id","=",$id)->get();
        $programName = Sodaqo::findOrFail($id)->name;
        return view('user_sodaqo_check.manage')->with(compact('datas','programName'));
    }
}
