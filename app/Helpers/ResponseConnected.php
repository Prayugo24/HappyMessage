<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Str;

class ResponseConnected
{
    public static function SuccessResponse($NameEnd,$LogSave,$speed,$Message){
        $API_Message=array(
            "API_Message"=>array(
                "Version"=> "V1",
                "Times"=> Carbon::now()->format(DATE_ATOM),
                "NameEnd"=> $NameEnd,
                "Status"=> "Complete",
                "Message"=>array(
                    "Type"=> "Info",
                    "ShortText"=> $Message,
                    "Speed" => self::SpeedResponse($speed),
                    "Code" => 200
                ),
                "Body"=> array(
                    "Result"=> $LogSave
                )
            )
        );
        return $API_Message;
    }

    public static function ErrorResponse($NameEnd,$LogSave,$speed, $Message){
        $API_Message=array(
            "API_Message"=>array(
                "Version"=> "V1",
                "Times"=> Carbon::now()->format(DATE_ATOM),
                "NameEnd"=>$NameEnd,
                "Status"=> "Not Complete",
                "Message"=>array(
                    "Type"=> "Info",
                    "ShortText"=> $Message,
                    "Speed" => self::SpeedResponse($speed),
                    "Code" => 203
                ),
                "Body"=> array(
                    "Result"=>$LogSave
                )
            )
        );
        return $API_Message;
    }

    public static function SpeedResponse($awal){
        $akhir = microtime(true);
        $durasi = $akhir - $awal;
        $jam = (int)($durasi/60/60);
        $menit = (int)($durasi/60) - $jam*60;
        $detik = $durasi - $jam*60*60 - $menit*60;
        return $kecepatan = number_format((float)$detik, 2, '.', '');
    }
}