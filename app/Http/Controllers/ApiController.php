<?php

namespace App\Http\Controllers;
use App\Models\Pagos;
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
        $dateExpiry_1 = date("Y-m-d");
        $dateExpiry_1 = date("Y-m-d",strtotime($dateExpiry_1."+ 20 days")); 
        $dateExpiry_2 = date("H:i:sT");
        $dateExpiry = $dateExpiry_1."T".$dateExpiry_1.":00";

        $token = "Bearer ".$token; 
        $response_cip = Http::withHeaders([
            'content-type' => 'application/json',
            'accept-language' => 'en-PE',
            'origin' => 'web',
            'authorization' => $token
        ])->post("https://pre1a.services.pagoefectivo.pe/v1/cips", [
            "currency" => "PEN",
            "amount" => 100,
            "transactionCode" => "520",
            "adminEmail" => "integrationproject.pe6@gmail.com",
            "dateExpiry" => $dateExpiry,
            "paymentConcept" => "Interlan",
            "additionalData" => "INTERLAN-1518-Operador de Pagos",
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
    public function read(Request $request)
    {
        $date = date("Y-m-d");
        $factura = Http::post('http://clientes.interlanperu.com/api/v1/GetInvoice', [
            'token' => 'b1p5ZHB2M2NoY2FFUWNVTDllUWRsZz09',
            'idfactura' => 1647
        ]);
        $factura = strval($factura->getBody());
        $factura = json_decode($factura);
        $factura = $factura->factura;

        $cliente = Http::post('http://clientes.interlanperu.com/api/v1/GetClientsDetails', [
            'token' => 'b1p5ZHB2M2NoY2FFUWNVTDllUWRsZz09',
            'idcliente' => $factura->idcliente
        ]);
        $cliente = strval($cliente->getBody());
        $cliente = json_decode($cliente);
        $cliente = $cliente->datos[0];

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
        $total = $factura->total+1;

        $dateExpiry_1 = date("Y-m-d");
        $dateExpiry_1 = date("Y-m-d",strtotime($dateExpiry_1."+ 20 days")); 

        $dateExpiry_2 = date("H:i:sT");

        $dateExpiry = $dateExpiry_1."T".$dateExpiry_1.":00";

        $response_cip = Http::withHeaders([
            'content-type' => 'application/json',
            'accept-language' => 'en-PE',
            'origin' => 'web',
            'authorization' => $token
        ])->post("https://pre1a.services.pagoefectivo.pe/v1/cips", [
            "currency" => "PEN",
            "amount" => $total,
            "transactionCode" => $factura->id,
            "adminEmail" => "integrationproject.pe6@gmail.com",
            "dateExpiry" => $dateExpiry,
            "paymentConcept" => "Interlan",
            "additionalData" => "INTERLAN-1518-Operador de Pagos",
            "userEmail" => $cliente->correo,
            "userName" => $cliente->nombre,
            "userLastName" => $cliente->nombre,
            "userUbigeo" => "010101",
            "userCountry" => "PERU",
            "userDocumentType" => "DNI",
            "userDocumentNumber" => $cliente->codigo,
            "userCodeCountry" => "+51",
            "userPhone" => $cliente->movil
        ]);

        $response_cip = strval($response_cip->getBody());
        $response_cip = json_decode($response_cip);

        $register = Pagos::create([
            'id' => $response_cip->data->cip,
            'estatus' => 'No Pagado',
            'amount' => $response_cip->data->amount,
            'cipUrl' => $response_cip->data->cipUrl,
            'transactionCode' => $response_cip->data->transactionCode,
            'paymentConcept' => "Interlan",
            'additionalData' => "INTERLAN-1518-Operador de Pagos",
            "userEmail" => $cliente->correo,
            "userName" => $cliente->nombre,
            "userLastName" => $cliente->nombre,
            "userDocumentType" => "DNI",
            "userDocumentNumber" => $cliente->codigo,
            "userPhone" => $cliente->movil,
            'created_at' => $date,
            'updated_at' => $date
        ]);


        return $response_cip;

        
      
                // {"type":"User"...'
    }
    public function generateCip(Request $request)
    {
        $date = date("Y-m-d");
        $factura = Http::post('http://clientes.interlanperu.com/api/v1/GetInvoice', [
            'token' => 'b1p5ZHB2M2NoY2FFUWNVTDllUWRsZz09',
            'idfactura' => $request->factura
        ]);
        $factura = strval($factura->getBody());
        $factura = json_decode($factura);
        $factura = $factura->factura;

        $cliente = Http::post('http://clientes.interlanperu.com/api/v1/GetClientsDetails', [
            'token' => 'b1p5ZHB2M2NoY2FFUWNVTDllUWRsZz09',
            'idcliente' => $factura->idcliente
        ]);
        $cliente = strval($cliente->getBody());
        $cliente = json_decode($cliente);
        $cliente = $cliente->datos[0];

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
        $total = $factura->total+1;

        $dateExpiry_1 = date("Y-m-d");
        $dateExpiry_1 = date("Y-m-d",strtotime($dateExpiry_1."+ 20 days")); 

        $dateExpiry_2 = date("H:i:sT");

        $dateExpiry = $dateExpiry_1."T".$dateExpiry_1.":00";

        $response_cip = Http::withHeaders([
            'content-type' => 'application/json',
            'accept-language' => 'en-PE',
            'origin' => 'web',
            'authorization' => $token
        ])->post("https://pre1a.services.pagoefectivo.pe/v1/cips", [
            "currency" => "PEN",
            "amount" => $total,
            "transactionCode" => $factura->id,
            "adminEmail" => "integrationproject.pe6@gmail.com",
            "dateExpiry" => $dateExpiry,
            "paymentConcept" => "Interlan",
            "additionalData" => "INTERLAN-1518-Operador de Pagos",
            "userEmail" => $cliente->correo,
            "userName" => $cliente->nombre,
            "userLastName" => $cliente->nombre,
            "userUbigeo" => "010101",
            "userCountry" => "PERU",
            "userDocumentType" => "DNI",
            "userDocumentNumber" => $cliente->codigo,
            "userCodeCountry" => "+51",
            "userPhone" => $cliente->movil
        ]);

        $response_cip = strval($response_cip->getBody());
        $response_cip = json_decode($response_cip);

        $register = Pagos::create([
            'id' => $response_cip->data->cip,
            'estatus' => 'No Pagado',
            'amount' => $response_cip->data->amount,
            'cipUrl' => $response_cip->data->cipUrl,
            'transactionCode' => $response_cip->data->transactionCode,
            'paymentConcept' => "Interlan",
            'additionalData' => "INTERLAN-1518-Operador de Pagos",
            "userEmail" => $cliente->correo,
            "userName" => $cliente->nombre,
            "userLastName" => $cliente->nombre,
            "userDocumentType" => "DNI",
            "userDocumentNumber" => $cliente->codigo,
            "userPhone" => $cliente->movil,
            'created_at' => $date,
            'updated_at' => $date
        ]);

        $pagos = Pagos::take(150)->get();
        return view('dashboard',["pagos"=>$pagos]);

    }
    public function cip(Request $request)
    {   
        $pagos = Pagos::find($request->data["cip"]);
        $pagos->estatus = $request->eventType;
        $pagos->save();
        $response = Http::post('http://clientes.interlanperu.com/api/v1/PaidInvoice', [
            'token' => 'b1p5ZHB2M2NoY2FFUWNVTDllUWRsZz09',
            'idfactura' => $request->data["transactionCode"],
            'pasarela' => 'Interlan - Pago Efectivo'
        ]);
        return response($response)
            ->header('Content-Type', $type)
            ->header('X-Header-One', 'Header Value');
    }

}
