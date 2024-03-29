<?php

namespace App\Http\Controllers;

use App\Helper\RazkyFeb;
use App\Models\News;
use App\Models\SodaqoCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SodaqoCategoryController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function viewCreate()
    {
        return view('sodaqo_category.create');
    }

    /**
     * Show the form for managing existing resource.
     */
    public function viewManage()
    {
        $datas = SodaqoCategory::all();
        return view('sodaqo_category.manage')->with(compact('datas'));
    }

    /**
     * See News on The Web
     */
    public function viewSeeWeb(Request $request)
    {
        $data = Sodaqo::findOrFail($request->id);
        return view('sodaqo_category.see')->with(compact('data'));
    }

    /**
     * Show the edit form for editing armada
     *
     * @return \Illuminate\Http\Response
     */
    public function viewUpdate($id)
    {
        $data = SodaqoCategory::findOrFail($id);
        return view('sodaqo_category.edit')->with(compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $data = new SodaqoCategory();
        $data->name = $request->title;
        $data->description = $request->news_content;
        if ($request->hasFile('photo')) {

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

        return $this->SaveData($data, $request);
    }


    /**
     * update created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function update(Request $request, $id)
    {
//        dd($request->all());
        $data = SodaqoCategory::findOrFail($id);
        $data->name = $request->title;
        $data->description = $request->m_content;
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
        $data = SodaqoCategory::findOrFail($id);

        if ($data->delete()) {
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
     * @param SodaqoCategory $data
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function SaveData(SodaqoCategory $data, Request $request)
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
