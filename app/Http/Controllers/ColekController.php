<?php

namespace App\Http\Controllers;

use App\Models\SodaqoCategory;
use Goutte\Client as Goute;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Schema;
use Kutia\Larafirebase\Facades\Larafirebase;
use Illuminate\Http\Request;

class ColekController extends Controller
{
    public function fcm(Request $request)
    {

    }


    public function colek()
    {
        $qotd = Inspiring::quote();

        $message_id = "";
        $message_en = "";

        $changeLog = array();

        $response = [
            'http_response' => 200,
            'version' => "0.0.1",
            'quotes_of_the_day' => $qotd,
            'message_id' => $message_id,
            'message_en' => $message_en,
            'changeLog' => $changeLog,
        ];

        return response($response, 200);
    }

    public function bdm()
    {
        $client = new Goute();

        // Set the authorization header
        $website = $client->request('GET', 'https://stockbit.com/');

        return $website->html();
    }

    public function drop($schemeName)
    {
        Schema::dropIfExists("$schemeName");
    }
}
