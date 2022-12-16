<?php

namespace App\Http\Controllers;

use App\Helper\RazkyFeb;
use App\Models\DonationAccount;
use App\Models\PaymentMerchant;
use App\Models\UserSodaqo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function viewCreate()
    {
        $merchants = PaymentMerchant::where('status', '=', '1')->get();
        return view('donation_account.create')->with(compact('merchants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function viewManage()
    {
        $datas = DonationAccount::isNotDeleted()->get();
        return view('donation_account.manage')->with(compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function viewUpdate($id)
    {
        $data = DonationAccount::findOrFail($id);
        $merchants = PaymentMerchant::isNotDeleted()->where('status', '=', '1')->get();
        return view('donation_account.edit')->with(compact('data', 'merchants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new DonationAccount();
        $data->name = $request->name;
        $data->m_description = $request->m_description;
        $data->status = $request->status;
        $data->account_number = $request->account_number;
        $data->account_number = $request->account_number;
        $data->created_by = Auth::id();
        $data->payment_merchant_id = $request->merchant_id;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension(); // you can also use file name
            $fileName = time() . '.' . $extension;

            $savePath = "/web_files/donation_account/";
            $savePathDB = "$savePath$fileName";
            $path = public_path() . "$savePath";
            $file->move($path, $fileName);

            $photoPath = $savePathDB;
            $data->photo = $photoPath;
        }

        return $this->SaveData($data, $request);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
    {
        return $this->viewUpdate($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, $id)
    {
        $data = DonationAccount::findOrFail($id);
        $data->name = $request->name;
        $data->account_number = $request->account_number;
        $data->m_description = $request->m_description;
        $data->status = $request->status;
        $data->created_by = Auth::id();
        $data->payment_merchant_id = $request->merchant_id;

        if ($request->hasFile('photo')) {
            $file_path = DonationAccountController . phppublic_path();
            RazkyFeb::removeFile($file_path);

            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension(); // you can also use file name
            $fileName = time() . '.' . $extension;

            $savePath = "/web_files/donation_account/";
            $savePathDB = "$savePath$fileName";
            $path = public_path() . "$savePath";
            $file->move($path, $fileName);

            $photoPath = $savePathDB;
            $data->photo = $photoPath;
        }

        return $this->SaveData($data, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        return "";
    }

    public function delete(Request $request, $id)
    {
        $data = DonationAccount::findOrFail($id);
        $py = UserSodaqo::where("payment_id",'=',$id)->count();
        if ($py == -99){
            $data->delete();
        }else{
            $data->is_deleted = 1;
            $data->status = -99;
            $data->name = $data->name." (Dihapus)";
            $data->save();
        }
        if ($data) {
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



    public
    function SaveData(DonationAccount $data, Request $request)
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

