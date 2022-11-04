<?php

namespace App\Http\Controllers;

use App\Helper\RazkyFeb;
use App\Models\PaymentMerchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentMerchantController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewCreate()
    {
        return view('payment_merchant.create');
    }

    /**
     * Show the form for managing existing resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewManage()
    {
        $datas = PaymentMerchant::all();
        return view('payment_merchant.manage')->with(compact('datas'));
    }

    /**
     * Show the edit form for editing armada
     *
     * @return \Illuminate\Http\Response
     */
    public function viewUpdate($id)
    {
        $data = PaymentMerchant::findOrFail($id);
        return view('payment_merchant.edit')->with(compact('data'));
    }

    /**
     * Show the edit form for editing armada
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $data = PaymentMerchant::findOrFail($id);
        $file_path = public_path() . $data->photo;
        RazkyFeb::removeFile($file_path);

        if ($data->delete()) {
            if ($request->is('api/*'))
                return RazkyFeb::responseSuccessWithData(
                    200, 1, 200,
                    "Berhasil Menyimpan Data",
                    "Success",
                    $data,
                );

            return back()->with(["success" => "Berhasil Menghapus Data"]);
        } else {
            if ($request->is('api/*'))
                return RazkyFeb::responseErrorWithData(
                    400, 3, 400,
                    "Berhasil Menginput Data",
                    "Success",
                    ""
                );
            return back()->with(["errors" => "Gagal Menghapus Data"]);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        $data = new PaymentMerchant();
        $data->name = $request->name;
        $data->m_description = $request->m_description;
        $data->status = $request->status;
        $data->created_by = Auth::id();
        if ($request->hasFile('photo')) {
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
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function update(Request $request, $id)
    {
        $data = PaymentMerchant::findOrFail($id);
        $data->name = $request->name;
        $data->created_by = Auth::id();
        $data->m_description = $request->m_description;
        $data->status = $request->status;
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

    public function SaveData(PaymentMerchant $data, Request $request)
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
