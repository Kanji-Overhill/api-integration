<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function insert(Request $request)
    {
        date_default_timezone_set("America/Lima");//Zona horaria de Peru
        $tiempoLog_1 = date("Y-m-d");
        $tiempoLog_2 = date("H:i:sT");
        $tiempoFinal = $tiempoLog_1."T".$tiempoLog_2.":00";

        $hashString = '1518.NTk0ZmYyYzg0YjM1MGVm.PcDqcSiTOvZXQCQrmirrvRFzuylj+GQ8dNIHreb8.'.$tiempoFinal;
        $hashString = hash('sha256', $hashString);


        $response = Http::post('https://pre1a.services.pagoefectivo.pe/v1/authorizations', [
            'accessKey' => 'NTk0ZmYyYzg0YjM1MGVm',
            'idService' => '1518',
            'dateRequest' => $tiempoFinal,
            'hashString' => $hashString
        ]);
        $response = strval($response->getBody());
        $response = json_decode($response);
        $token = $response->data->token;
        $expireToken = $response->data->tokenExpires;
        $token = "Bearer ".$token;

        $response_cip = Http::withHeaders([
            'content-type' => 'application/json',
            'accept-language' => 'en-PE',
            'origin' => 'web',
            'authorization' => $token
        ])->post("https://pre1a.services.pagoefectivo.pe/v1/cips", [
            "currency" => "PEN",
            "amount" => 1,
            "transactionCode" => "101",
            "adminEmail" => "integrationproject.pe6@gmail.com",
            "dateExpiry" => $expireToken,
            "paymentConcept" => "Prueba-Validar",
            "additionalData" => "datosadicionales",
            "userEmail" => "integrationproject.pe6@gmail.com",
            "userName" => "Victor",
            "userLastName" => "Avila",
            "userUbigeo" => "010101",
            "userCountry" => "PERU",
            "userDocumentType" => "DNI",
            "userDocumentNumber" => "12345678",
            "userCodeCountry" => "+51",
            "userPhone" => "956957535"
        ]);

        return $response_cip;
                // {"type":"User"...'
    }
    public function cip(Request $request)
    {
        $response = strval($request->getBody());
        $response = json_decode($response);
        return $response->data->transactionCode;
    }

}
