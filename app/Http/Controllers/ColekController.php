<?php

namespace App\Http\Controllers;

use Goutte\Client as Goute;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Schema;

class ColekController extends Controller
{
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
        $client->setHeader('Authorization', 'Bearer wte1h6nbz23ax04a6wxrh0in1t5kugra');


        $crawler = $client->request('GET', 'https://neobdm.tech/dashboard/');

        $top_akumulasi_bandarmologi_harian = [];

        $crawler->filter('h3.card-title + table tr')->each(function ($tr) use (&$top_akumulasi_bandarmologi_harian) {
            $row = [];
            $tr->filter('td')->each(function ($td) use (&$row) {
                $row[] = $td->text();
            });

            if (count($row) > 0) {
                $top_akumulasi_bandarmologi_harian[] = $row;
            }
        });

        $top_akumulasi_bandarmologi_harian = json_encode($top_akumulasi_bandarmologi_harian);
        return $top_akumulasi_bandarmologi_harian;
    }

    public function drop($schemeName)
    {
        Schema::dropIfExists("$schemeName");
    }
}
