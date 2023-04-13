<?php

namespace App\Http\Controllers;

use App\Helper\RazkyFeb;
use App\Models\PaymentMerchant;
use App\Models\User;
use App\Models\UserSodaqo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MobileSodaqoUserController extends Controller
{

    public function getDetailHistory(Request $request, $id)
    {
        $query = DB::table('user_sodaqos as t')
            ->selectRaw('
                t.*,
                s.name as program_name,
                s.photo as sodaqo_photo,
                a.account_number as payment_account_number,
                m.name as payment_merchant_name,
                COALESCE(a.m_description, "") as how_to_pay,
                m.photo as payment_merchant_photo
            ')
            ->leftJoin('sodaqos as s', 's.id', '=', 't.sodaqo_id')
            ->leftJoin('donation_accounts as a', 't.payment_id', '=', 'a.id')
            ->leftJoin('payment_merchants as m', 'm.id', '=', 'a.payment_merchant_id');

        $query->where('t.id', '=', $id);


        $results = $query->get();

        $results->map(function ($result) {
            $count = UserSodaqo::where("user_id", "=", $result->user_id)->get()->count();

            $result->photo_path = url("/") . $result->photo;
            $result->sodaqo_photo_path = url("/") . $result->sodaqo_photo;
            $result->payment_merchant_photo_path = url("/") . $result->payment_merchant_photo;
            $result->nominal_formatted = 'Rp ' . number_format($result->nominal, 2, ',', '.');
            $result->nominal_net_formatted = 'Rp ' . number_format($result->nominal_net, 2, ',', '.');
            $result->data_count = $count;

            $stat = "";
            $color1 = "#D38107";
            $color2 = "#FBE7C8";
            if ($result->status == 0) {
                $stat = "Menunggu Verifikasi";
            }
            if ($result->status == 1) {
                $color1 = "#ADD8E6";
                $color2 = "#EDFFEC";
                $stat = "Pembayaran Diterima";
            }
            if ($result->status == 2) {
                $color1 = "#D62F3F";
                $color2 = "#FFECEC";
                $stat = "Pembayaran Tidak Valid";
            }
            if ($result->status == 4) {
                $color1 = "#ADD8E6";
                $color2 = "#EDFFEC";
                $stat = "Diterima Dengan Catatan";
            }
            $result->status_desc = $stat;
            $result->color1 = $color1;
            $result->color2 = $color2;

            return $result;
        });

        return $results->first();
    }

    public function getSodaqoByUser(Request $request, $id)
    {
        $perPage = 20;
        $page = $request->page;
        $search = $request->search;
        $status = $request->status;
        $userId = $request->user_id;


        $query = DB::table('user_sodaqos as t')
            ->select('t.*', 's.name as program_name', 's.photo as sodaqo_photo', 'a.account_number as payment_account_number', 'm.name as payment_merchant_name', 'm.photo as payment_merchant_photo')
            ->leftJoin('sodaqos as s', 's.id', '=', 't.sodaqo_id')
            ->leftJoin('donation_accounts as a', 't.payment_id', '=', 'a.id')
            ->leftJoin('payment_merchants as m', 'm.id', '=', 'a.payment_merchant_id');

        if ($page != null) {
            $query->skip(($page - 1) * $perPage)->take($perPage);
        }

        if ($search != null) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('s.name', 'like', "%$search%")
                    ->orWhere('t.doa', 'like', "%$search%")
                    ->orWhere('a.account_number', 'like', "%$search%")
                    ->orWhere('m.name', 'like', "%$search%");
            });
        }

        if ($userId) {
            $query->where('t.user_id', '=', $userId);
        }


        $query->orderBy("t.created_at","desc");
        if ($status != null) {
            $query->where('t.status', '=', $status);
        }
        $results = $query->get();

        $results->map(function ($result) {
            $count = UserSodaqo::where("user_id", "=", $result->user_id)->get()->count();

            $result->photo_path = url("/") . $result->photo;
            $result->sodaqo_photo_path = url("/") . $result->sodaqo_photo;
            $result->payment_merchant_photo_path = url("/") . $result->payment_merchant_photo;
            $result->nominal_formatted = 'Rp ' . number_format($result->nominal, 2, ',', '.');
            $result->nominal_net_formatted = 'Rp ' . number_format($result->nominal_net, 2, ',', '.');
            $result->data_count = $count;

            $stat = "";
            $color1 = "#D38107";
            $color2 = "#FBE7C8";
            if ($result->status == 0) {
                $stat = "Menunggu Verifikasi";
            }
            if ($result->status == 1) {
                $color1 = "#ADD8E6";
                $color2 = "#EDFFEC";
                $stat = "Pembayaran Diterima";
            }
            if ($result->status == 2) {
                $color1 = "#D62F3F";
                $color2 = "#FFECEC";
                $stat = "Pembayaran Tidak Valid";
            }
            if ($result->status == 4) {
                $color1 = "#ADD8E6";
                $color2 = "#EDFFEC";
                $stat = "Diterima Dengan Catatan";
            }
            $result->status_desc = $stat;
            $result->color1 = $color1;
            $result->color2 = $color2;

            return $result;
        });

        return $results;
    }

    public function store(Request $request)
    {
        sleep(8);
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

        if ($data->save()) {
            return RazkyFeb::success(200, "Success");
        } else {
            return RazkyFeb::error(422, "Terjadi Kesalahan (Server)");
        }

    }

    public function update(Request $request)
    {

        $data = UserSodaqo::findOrFail($request->id);
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

        if ($data->save()) {
            return RazkyFeb::success(200, "Success");
        } else {
            return RazkyFeb::error(422, "Terjadi Kesalahan (Server)");
        }

    }

}
