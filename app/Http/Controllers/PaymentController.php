<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PaymentsGatewaySwitch\Facades\PaymentsGatewaySwitch;

class PaymentController extends Controller
{
    //
    public function processPayment(Request $request)
    {

        // dd("isisjs");
        $data = [
            'amount' => $request->input('amount'),
            'location' => $request->input('location'),
        ];
       

        try {
            $response = PaymentsGatewaySwitch::pay($data);
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
