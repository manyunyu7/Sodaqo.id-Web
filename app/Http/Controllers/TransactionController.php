<?php

namespace App\Http\Controllers;

use App\Helper\RazkyFeb;
use App\Models\DonationAccount;
use App\Models\News;
use App\Models\Sodaqo;
use App\Models\UserSodaqo;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function viewManage($id)
    {

        $init = UserSodaqo::where("sodaqo_id", "=", $id)->get();
        $program = Sodaqo::findOrFail($id);
        $programName = $program->name;
        $programTarget = $program->fundraising_target;

        $summary = (object)$this->countVariables($init);

        $percentageFundraising = (($summary->sumOfNominalNetRaw / $programTarget) * 100);

        $neededRaw = $program->fundraising_target - $summary->sumOfNominalNetRaw;
        $needed = "Rp.".number_format($neededRaw, 0, ".", ",");


        $datas = $init;

        return view('user_sodaqo_check.manage')->with(
            compact('datas',
                'programName',
                'summary',
                'percentageFundraising',
                'program', 'needed'
            ));
    }

    function countVariables($data)
    {
        $verifiedCount = 0;
        $waitingCount = 0;
        $invalidCount = 0;
        $sumOfNominalNet = 0;

        foreach ($data as $record) {
            if ($record['status'] === '1') {
                $verifiedCount++;
            } else if ($record['status'] === '0') {
                $waitingCount++;
            } else if ($record['status'] === '2') {
                $invalidCount++;
            }

            $sumOfNominalNet += $record['nominal_net'];
        }

        // Calculate the percentage of each status from all of the data
        $totalCount = count($data);
        $verifiedPercent = round(($verifiedCount / $totalCount) * 100);
        $waitingPercent = round(($waitingCount / $totalCount) * 100);
        $invalidPercent = round(($invalidCount / $totalCount) * 100);

        $sumOfNominalNetRaw = $sumOfNominalNet;
        $sumOfNominalNet = number_format($sumOfNominalNet, 0, ".", ",");
        return array(
            'verifiedCount' => $verifiedCount,
            'waitingCount' => $waitingCount,
            'invalidCount' => $invalidCount,
            'sumOfNominalNet' => $sumOfNominalNet,
            'sumOfNominalNetRaw' => $sumOfNominalNetRaw,
            'verifiedPercent' => $verifiedPercent,
            'waitingPercent' => $waitingPercent,
            'invalidPercent' => $invalidPercent,
        );
    }

    public function update(Request $request)
    {
        $obj = UserSodaqo::findOrFail($request->id);
        $obj->nominal_net = $request->nominal_net;
        if ($obj->status != "")
            $obj->status = $request->status;

        $obj->notes_admin = $request->notes;

        return $this->SaveData($obj, $request);
    }


    public function SaveData($data, Request $request)
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
