<?php

namespace App\Http\Controllers;

use App\Models\DonationAccount;
use App\Models\Sodaqo;
use App\Models\SodaqoCategory;
use App\Models\SodaqoTimeline;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MobileSodaqoAllController extends Controller
{

    public function getPaymentAccount()
    {
        return DonationAccount::where("status", "=", 1)->get();
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
                $item->total_nominal = (double)$item->total_nominal;
                $item->total_nominal_net = (double)$item->total_nominal_net;
                $item->total_nominal_formatted = 'Rp ' . number_format($item->total_nominal, 2, ',', '.');
                $item->total_nominal_net_formatted = 'Rp ' . number_format($item->total_nominal_net, 2, ',', '.');
                $item->fundraising_target_formatted = 'Rp ' . number_format($item->fundraising_target, 2, ',', '.');

                $item->photo_path = strpos($item->photo, 'http') === false ? url('/') . $item->photo : $item->photo;
                $item->creator_photo_path = strpos($item->creator_photo, 'http') === false ? url('/') . $item->creator_photo : $item->creator_photo;


                $item->remaining_time = Carbon::parse($item->time_limit)->diffInDays(Carbon::now());
                Carbon::setLocale('id');
                $item->remaining_time_desc =
                $diff = Carbon::now()->diffForHumans(Carbon::parse($item->time_limit), true,);
                return $item;
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
                $item->total_nominal = (double)$item->total_nominal;
                $item->total_nominal_net = (double)$item->total_nominal_net;
                $item->total_nominal_formatted = 'Rp ' . number_format($item->total_nominal, 2, ',', '.');
                $item->total_nominal_net_formatted = 'Rp ' . number_format($item->total_nominal_net, 2, ',', '.');
                $item->fundraising_target_formatted = 'Rp ' . number_format($item->fundraising_target, 2, ',', '.');
                $item->photo_path = url('/') . $item->photo;
                $item->creator_photo_path = url('/') . $item->creator_photo;
                $item->remaining_time = Carbon::parse($item->time_limit)->diffInDays(Carbon::now());
                Carbon::setLocale('id');
                $item->remaining_time_desc =
                $diff = Carbon::now()->diffForHumans(Carbon::parse($item->time_limit), true,);
                return $item;
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
                $item->total_nominal = (double)$item->total_nominal;
                $item->total_nominal_net = (double)$item->total_nominal_net;
                $item->total_nominal_formatted = 'Rp ' . number_format($item->total_nominal, 2, ',', '.');
                $item->total_nominal_net_formatted = 'Rp ' . number_format($item->total_nominal_net, 2, ',', '.');
                $item->fundraising_target_formatted = 'Rp ' . number_format($item->fundraising_target, 2, ',', '.');
                $item->photo_path = url('/') . $item->photo;
                $item->creator_photo_path = url('/') . $item->creator_photo;
                Carbon::setLocale('id');
                $item->remaining_time = Carbon::parse($item->time_limit)->diffInDays(Carbon::now());

                if ($item->time_limit != 0) {
                    $item->remaining_time_desc = Carbon::now()->diffForHumans(Carbon::parse($item->time_limit), true,) . " lagi";
                } else {
                    $item->remaining_time_desc = "";
                }

                return $item;
            });


        return $results;
    }

}
