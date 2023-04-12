<?php

namespace App\Http\Controllers;

use App\Models\DonationAccount;
use App\Models\Sodaqo;
use App\Models\SodaqoCategory;
use App\Models\SodaqoTimeline;
use App\Models\UserSodaqo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MobileSodaqoAllController extends Controller
{

    public function getPaymentAccount()
    {
        return DonationAccount::where("status", "=", 1)->isNotDeleted()->get();
    }

    public function getPeople(Request $request, $id)
    {
        $perPage = 1000000;
        $page = $request->page;
        $search = $request->search;

        if ($request->perPage!=null){
            $perPage = $request->perPage;
        }
        $sodaqoId = $id;


        $query = DB::table('user_sodaqos as t')
            ->select(
                'users.id as user_id',
                'users.name as user_name',
                'users.photo as user_photo',
                't.*',
                's.name as program_name',
                's.photo as sodaqo_photo',
                'a.account_number as payment_account_number',
                'm.name as payment_merchant_name', 'm.photo as payment_merchant_photo')
            ->leftJoin('sodaqos as s', 's.id', '=', 't.sodaqo_id')
            ->leftJoin('donation_accounts as a', 't.payment_id', '=', 'a.id')
            ->leftJoin('users', 't.user_id', '=', 'users.id')
            ->leftJoin('payment_merchants as m', 'm.id', '=', 'a.payment_merchant_id');

        if ($page!=null) {
            $query->skip(($page - 1) * $perPage)->take($perPage);
        }

        if ($search!=null) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('s.name', 'like', "%$search%")
                    ->orWhere('t.doa', 'like', "%$search%")
                    ->orWhere('a.account_number', 'like', "%$search%")
                    ->orWhere('m.name', 'like', "%$search%");
            });
        }

        if ($sodaqoId) {
            $query->where('t.sodaqo_id', '=', $sodaqoId);
        }
        $query->where('t.status', '=', "1");
        $query->whereNotNull('users.id');
        $query->orderBy("t.id","desc");
        $results = $query->get();

        $results->map(function ($result) {
            $count = UserSodaqo::where("user_id","=",$result->user_id)->get()->count();

            $result->photo_path = url("/") . $result->photo;
            $result->sodaqo_photo_path = url("/") . $result->sodaqo_photo;
            $result->user_photo_path = url("/") . $result->user_photo;
            $result->payment_merchant_photo_path = url("/") . $result->payment_merchant_photo;
            $result->nominal_formatted = 'Rp ' . number_format($result->nominal, 2, ',', '.');
            $result->nominal_net_formatted = 'Rp ' . number_format($result->nominal_net, 2, ',', '.');
            $result->data_count = $count ;

            $stat = "";
            $color1 = "#D38107";
            $color2 = "#FBE7C8";
            if ($result->status==0){
                $stat = "Menunggu Verifikasi";
            }
            if ($result->status==1){
                $color1 = "#ADD8E6";
                $color2 = "#EDFFEC";
                $stat = "Pembayaran Diterima";
            }
            if ($result->status==2){
                $color1 = "#D62F3F";
                $color2 = "#FFECEC";
                $stat = "Pembayaran Tidak Valid";
            }
            if ($result->status==4){
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


    public function getAll()
    {
        return Sodaqo::all();
    }

    //Get bY
    public function getByCategoryId(Request $request,$id, $search = '', $page = 1, $start_date = '', $end_date = '')
    {
        $perPage = 20;
        $page = $request->page;
        $search = $request->search;
        $results = DB::table('sodaqos as s')
            ->leftJoin('user_sodaqos as u', 's.id', '=', 'u.sodaqo_id')
            ->leftJoin('users as u2', 's.owner_id', '=', 'u2.id')
            ->leftJoin('sodaqo_categories as c', 's.category_id', '=', 'c.id')
            ->select(
                's.*',
                'u2.name as creator_name',
                'u2.photo as creator_photo',
                'c.name as sodaqo_category_name',
                DB::raw('SUM(u.nominal) as total_nominal'),
                DB::raw('SUM(u.nominal_net) as total_nominal_net'),
                DB::raw('COUNT(u.id) as transaction_count'),
            )
            ->where("s.category_id", '=', $id)
            ->whereNull('s.is_deleted');

        if ($search != null && $search!="") {
            $results = $results->where(function ($query) use ($search) {
                $query->orWhere('s.name', 'like', '%' . $search . '%');
//                $query->orWhere('s.created_at', 'like', '%' . $search . '%');
//                $query->orWhere('u2.name', 'like', '%' . $search . '%');
//                $query->orWhere('c.name', 'like', '%' . $search . '%');
            });
        }

        if ($start_date != '') {
            $results = $results->where('s.created_at', '>=', $start_date);
        }

        if ($end_date != '') {
            $results = $results->where('s.created_at', '<=', $end_date);
        }

        if ($page!=null) {
            $results->skip(($page - 1) * $perPage)->take($perPage);
        }

        $results = $results->groupBy('s.id')
            ->paginate(20, ['*'], 'page', $page)
            ->map(function ($item) {
                return $this->appendSodaqo($item);
            });

        return $results;
    }


    public function getDetailSodaqo(Request $request, $id)
    {
        $results = DB::table('sodaqos as s')
            ->leftJoin('user_sodaqos as u', 's.id', '=', 'u.sodaqo_id')
            ->leftJoin('users as u2', 's.owner_id', '=', 'u2.id')
            ->leftJoin('sodaqo_categories as c', 's.category_id', '=', 'c.id')
            ->select(
                's.*',
                'u2.name as creator_name',
                'u2.photo as creator_photo',
                'c.name as sodaqo_category_name',
                DB::raw('SUM(u.nominal) as total_nominal'),
                DB::raw('SUM(u.nominal_net) as total_nominal_net'),
                DB::raw('COUNT(u.id) as transaction_count'),
            )
            ->whereNull('s.is_deleted')
            ->where("s.id", '=', $id)
            ->groupBy('s.id')
            ->get()
            ->map(function ($item) {
                return $this->appendSodaqo($item);
            })->first();

        $timeline = SodaqoTimeline::where("sodaqo_id", "=", $id)->get();
        return response()->json([
            'sodaqo' => $results,
            'timeline' => $timeline,
        ]);
    }


    public function recent()
    {
        $results = DB::table('sodaqos as s')
            ->leftJoin('user_sodaqos as u', 's.id', '=', 'u.sodaqo_id')
            ->leftJoin('users as u2', 's.owner_id', '=', 'u2.id')
            ->select(
                's.*', 'u2.name as creator_name', 'u2.photo as creator_photo',
                DB::raw('SUM(u.nominal) as total_nominal'),
                DB::raw('SUM(u.nominal_net) as total_nominal_net'),
                DB::raw('COUNT(u.id) as transaction_count'),
            )
            ->whereNull('s.is_deleted')
            ->groupBy('s.id')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return $this->appendSodaqo($item);
            });


        return $results;
    }

    private function appendSodaqo($item)
    {
        $item->total_nominal = (double)$item->total_nominal;
        $item->total_nominal_net = (double)$item->total_nominal_net;
        $item->total_nominal_formatted = 'Rp ' . number_format($item->total_nominal, 2, ',', '.');
        $item->total_nominal_net_formatted = 'Rp ' . number_format($item->total_nominal_net, 2, ',', '.');
        $item->fundraising_target_formatted = 'Rp ' . number_format($item->fundraising_target, 2, ',', '.');
        $item->photo_path = url('/') . $item->photo;
        $item->creator_photo_path = url('/') . $item->creator_photo;
        Carbon::setLocale('id');
        $item->current_date = Carbon::now();


        $isInPast = $item->current_date > Carbon::parse($item->time_limit);
        $item->is_in_past = $isInPast;
        $diffDays = Carbon::parse($item->time_limit)->diffInDays($item->current_date);
        $item->remaining_time = $diffDays;

        if ($isInPast){
            $item->remaining_time = -$diffDays;
        }

        if ($item->time_limit != 0) {
            $item->remaining_time_desc = Carbon::now()->diffForHumans(Carbon::parse($item->time_limit), true,) . " lagi";
        } else {
            $item->remaining_time_desc = "";
        }

        return $item;
    }

}
