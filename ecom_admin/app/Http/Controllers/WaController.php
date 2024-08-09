<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

use DataTables;
use Carbon\Carbon;

class WaController extends Controller
{

	public function scan(){

		$name = "notification";
		$islegacy = "false";

		$response = Http::post(env('URL_WA_SERVER').'/sessions/add', ['id' => $name, 'isLegacy' => $islegacy]);
		$response = json_decode($response->getBody());
		$data['result'] = $response->data->qr;

		return view('wa.qrcode',$data);

	}

	public function sendChat(){

		$receiver = '6282137870821';
		$message = 'Hello World';

		$response = Http::post(env('URL_WA_SERVER').'/chats/send?id=notification', [
			'receiver' => $receiver,
			'message'  => [ 'text' => $message ]
			]);
		
		$res = json_decode($response->getBody());
		return $res;

	}

}