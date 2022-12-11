<?php

namespace App\Http\Controllers;

use App\Helper\RazkyFeb;
use App\Models\UserSodaqo;
use Illuminate\Http\Request;

class MobileSodaqoUserController extends Controller
{
    public function store(Request $request){

        $data = new UserSodaqo();
        $data->sodaqo_id = $request->sodaqo_id;
        $data->user_id = $request->user_id;
        $data->payment_id = $request->payment_id;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension(); // you can also use file name
            $fileName = time() . '.' . $extension;

            $savePath = "/web_files/user_donation/";
            $savePathDB = "$savePath$fileName";
            $path = public_path() . "$savePath";
            $file->move($path, $fileName);

            $photoPath = $savePathDB;
            $data->photo = $photoPath;
        }

        $data->nominal = $request->nominal;
        $data->is_anonym = $request->is_anonym;
        $data->is_whatsapp_enabled = $request->is_whatsapp_enabled;

        $data->doa = $request->doa;
        $data->status = 0;

        if($data->save()){
            return RazkyFeb::success(200,"Success");
        }else{
            return RazkyFeb::error(422,"Terjadi Kesalahan (Server)");
        }

    }
}
