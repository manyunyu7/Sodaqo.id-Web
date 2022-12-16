<?php

namespace App\Http\Controllers;

use App\Helper\RazkyFeb;
use App\Models\DonationAccount;
use App\Models\PaymentMerchant;
use App\Models\Sodaqo;
use App\Models\SodaqoCategory;
use App\Models\SodaqoTimeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $datas = Sodaqo::isNotDeleted()->orderBy("status","desc")->get();
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
        $data->story = $request->m_description;
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
}
