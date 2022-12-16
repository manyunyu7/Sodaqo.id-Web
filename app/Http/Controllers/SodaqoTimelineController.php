<?php

namespace App\Http\Controllers;

use App\Helper\RazkyFeb;
use App\Models\PaymentMerchant;
use App\Models\Sodaqo;
use App\Models\SodaqoTimeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SodaqoTimelineController extends Controller
{

    public function viewUpdate($id){
        $data = SodaqoTimeline::findOrFail($id);
        $con = $data->content;
        return view('sodaqo.edit_timeline')->with(compact("data","con"));
    }

    /**
     * update created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function editStory(Request $request)
    {
        $data = Sodaqo::findOrFail($request->id);
        $data->story = $request->story;
        if ($data->save()) {
            if (RazkyFeb::isAPI($request))
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

    public function store(Request $request)
    {
        $data = new SodaqoTimeline();
        $data->sodaqo_id = $request->id;
        $data->content = $request->story;
        $data->title = $request->title;
        $data->subtitle = $request->subtitle;
        $data->expense = $request->expense;
        $data->expense_admin = $request->expense_admin;
        $data->expense_desc = $request->expense_desc;
        return $this->SaveData($data, $request);
    }


    public function update(Request $request)
    {
        $data = SodaqoTimeline::findOrFail($request->id);
        $data->content = $request->story;
        $data->title = $request->title;
        $data->subtitle = $request->subtitle;
        $data->expense = $request->expense;
        $data->expense_admin = $request->expense_admin;
        $data->expense_desc = $request->expense_desc;
        return $this->SaveData($data, $request);
    }


    /**
     * @param Sodaqo $data
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function SaveData(SodaqoTimeline $data, Request $request)
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
