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
        try{
            $fcmTokens = "f5B88Vy_TMeIN4McMg3Cmk:APA91bGjM0Pv6DsbfTOLNHkTmiHWaIkcVzCoGgIaK_ihSuRiV5vJDR87FE7kSUJUkf37Ez3q9QU8gnfm3EJlYuldcLoN_6Vx2CRDx23m2B1hNLM1MMPse1UNHMEgyVBGA5BDZBgaGQQF";
            return Larafirebase::withTitle('Test Title')
                ->withBody('Test body')
                ->withImage('https://firebase.google.com/images/social.png')
                ->withIcon('https://seeklogo.com/images/F/firebase-logo-402F407EE0-seeklogo.com.png')
                ->withSound('default')
                ->withClickAction('https://www.google.com')
                ->withPriority('high')
                ->withAdditionalData([
                    'color' => '#rrggbb',
                    'badge' => 0,
                    'agus' => 0,
                ])
                ->sendNotification($fcmTokens);

            return 'Notification Sent Successfully!!';

        }catch(\Exception $e){
            report($e);
            return $e;
        }
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
