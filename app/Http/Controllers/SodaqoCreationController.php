<?php

namespace App\Http\Controllers;

use App\Helper\RazkyFeb;
use App\Models\DonationAccount;
use App\Models\PaymentMerchant;
use App\Models\Sodaqo;
use App\Models\SodaqoCategory;
use App\Models\SodaqoTimeline;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SodaqoCreationController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function viewCreate()
    {
        $categories = SodaqoCategory::all();
        return view('sodaqo.create')->with(compact('categories'));
    }

        /**
     */
    public function editPhoto(Request $request)
    {
        $data = Sodaqo::findOrFail($request->id);
        if ($request->hasFile('photo')) {
            $file_path = public_path() . $data->photo;
            RazkyFeb::removeFile($file_path);

            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension(); // you can also use file name
            $fileName = time() . '.' . $extension;

            $savePath = "/web_files/payment_merchant/";
            $savePathDB = "$savePath$fileName";
            $path = public_path() . "$savePath";
            $file->move($path, $fileName);

            $photoPath = $savePathDB;
            $data->photo = $photoPath;
        }
        return $this->SaveData($data, $request);
    }

    /**
     * Show the form for managing existing resource.
     */
    public function viewManage()
    {
        $datas = $this->getSodaqosManage();
//        return $datas;
        return view('sodaqo.manage')->with(compact('datas'));
    }

    /**
     * See News on The Web
     */
    public function viewSeeWeb(Request $request)
    {
        $data = Sodaqo::findOrFail($request->id);
        return view('sodaqo.see')->with(compact('data',));
    }

    /**
     * Show the edit form for editing armada
     *
     * @return \Illuminate\Http\Response
     */
    public function viewUpdate($id)
    {
        $data = Sodaqo::findOrFail($id);
        $timelines = SodaqoTimeline::where("sodaqo_id","=",$id)->get();
        $categories = SodaqoCategory::all();

        $compact = compact('data','timelines','categories');
        return view('sodaqo.edit')->with($compact);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        $data = new Sodaqo();
        $data->owner_id = Auth::id();
        $data->category_id = $request->merchant_id;
        $data->name = $request->name;
        $data->admin_fee_percentage = $request->admin_fee;
        $data->fundraising_target = $request->fundraising_target;
        $data->story = $request->m_description;
        $data->time_limit = $request->time_limit;
        $data->status = 1;
        if ($request->hasFile('photo')) {

            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension(); // you can also use file name
            $fileName = time() . '.' . $extension;

            $savePath = "/web_files/sodaqo/";
            $savePathDB = "$savePath$fileName";
            $path = public_path() . "$savePath";
            $file->move($path, $fileName);

            $photoPath = $savePathDB;
            $data->photo = $photoPath;
        }

        return $this->SaveData($data, $request);
    }


    /**
     * update created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function update(Request $request, $id)
    {
        $data = Sodaqo::findOrFail($request->id);
        $data->category_id = $request->merchant_id;
        $data->name = $request->name;
        $data->admin_fee_percentage = $request->admin_fee;
        $data->fundraising_target = $request->fundraising_target;
        $data->story = $request->story;
        $data->time_limit = $request->time_limit;
        $data->status = $request->status;
        if ($request->hasFile('photo')) {

            $file_path = public_path() . $data->photo;
            RazkyFeb::removeFile($file_path);

            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension(); // you can also use file name
            $fileName = time() . '.' . $extension;

            $savePath = "/web_files/news/";
            $savePathDB = "$savePath$fileName";
            $path = public_path() . "$savePath";
            $file->move($path, $fileName);
            $photoPath = $savePathDB;
            $data->photo = $photoPath;
        }

        if ($data->save()) {
            if ($request->is('api/*'))
                return RazkyFeb::responseSuccessWithData(
                    200, 1, 200,
                    "Berhasil Mengupdate Konten",
                    "Success",
                    $data,
                );

            return back()->with(["success" => "Berhasil Mengupdate Konten"]);
        } else {
            if ($request->is('api/*'))
                return RazkyFeb::responseErrorWithData(
                    400, 3, 400,
                    "Gagal Mengupdate Konten",
                    "Success",
                    ""
                );
            return back()->with(["errors" => "Gagal Mengupdate Konten"]);
        }

    }

    /**
     * Delete Armada by filling deleted_by_id
     * @param @id of armada
     * return json or view
     */
    public function delete(Request $request, $id)
    {
        $data = Sodaqo::findOrFail($id);
        $data->is_deleted=1;
        if ($data->save()) {
            if ($request->is('api/*'))
                return RazkyFeb::responseSuccessWithData(
                    200, 1, 200,
                    "Berhasil Menghapus Data",
                    "Success",
                    Auth::user(),
                );
            return back()->with(["success" => "Berhasil Menghapus Data"]);
        } else {
            if ($request->is('api/*'))
                return RazkyFeb::responseErrorWithData(
                    400, 3, 400,
                    "Berhasil Mengupdate Data",
                    "Success",
                    ""
                );
            return back()->with(["errors" => "Gagal Menghapus Data"]);
        }
    }


    public function get(Request $request)
    {
        $datas = Sodaqo::all();
        if ($request->type != "") {
            $datas = Sodaqo::where('type', '=', $request->type)->get();
        }
        return $datas;
    }

    /**
     * @param Sodaqo $data
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function SaveData(Sodaqo $data, Request $request)
    {
        if ($data->save()) {
            if ($request->is('api/*'))
                return RazkyFeb::responseSuccessWithData(
                    200, 1, 200,
                    "Berhasil Menyimpan Data",
                    "Success",
                    $data,
                );

            return back()->with(["success" => "Berhasil Menyimpan Data"]);
        } else {
            if ($request->is('api/*'))
                return RazkyFeb::responseErrorWithData(
                    400, 3, 400,
                    "Berhasil Menginput Data",
                    "Success",
                    ""
                );
            return back()->with(["errors" => "Gagal Menyimpan Data"]);
        }
    }

    private function getSodaqosManage()
    {
        $search = "";
        $start_date = "";
        $end_date = "";
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
            ->where("s.owner_id", '=', Auth::id())
            ->whereNull('s.is_deleted');

        if ($search != '') {
            $results = $results->where(function ($query) use ($search) {
                $query->orWhere('s.name', 'like', '%' . $search . '%');
                $query->orWhere('s.description', 'like', '%' . $search . '%');
                $query->orWhere('s.created_at', 'like', '%' . $search . '%');
                $query->orWhere('u2.name', 'like', '%' . $search . '%');
                $query->orWhere('c.name', 'like', '%' . $search . '%');
            });
        }

        if ($start_date != '') {
            $results = $results->where('s.created_at', '>=', $start_date);
        }

        if ($end_date != '') {
            $results = $results->where('s.created_at', '<=', $end_date);
        }

        $results = $results->groupBy('s.id')->get()
            ->map(function ($item) {
                $item->total_nominal = (double)$item->total_nominal;
                $item->total_nominal_net = (double)$item->total_nominal;
                $item->total_nominal_formatted = 'Rp ' . number_format($item->total_nominal, 2, ',', '.');
                $item->total_nominal_net_formatted = 'Rp ' . number_format($item->total_nominal_net, 2, ',', '.');
                $item->fundraising_target_formatted = 'Rp ' . number_format($item->fundraising_target, 2, ',', '.');

                $item->story = "";
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
}
