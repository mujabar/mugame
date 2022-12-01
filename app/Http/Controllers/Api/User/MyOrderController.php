<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyOrderController extends Controller
{
    public function index()
    {
        $auth = auth()->user();

        if ($auth->role == 'user') {
            $order = Transaction::with(['item'])->where('user_id',  Auth::user()->id)->get();

            return response()->json([
                'status' => 'success',
                'data' => $order,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'unauthorized',
            ], 401);
        }
    }

    public function processPaymentOrder(Request $request)
    {
        $image = $request->file('image')->store('payment', 'public');

        $payment = Payment::create([
            'user_id' => Auth::user()->id,
            'transaction_id' => $request->transaction_id,
            'image' => $image,
            'name' => $request->name,
            'type' => $request->type,
        ]);


        Transaction::where('id', $request->transaction_id)->update([
            'status' => 'WAITING'
        ]);

        if ($payment) {
            return  response()->json([
                'status' => 'success',
                'message' => 'payment success',
            ], 200);
        } else {
            return  response()->json([
                'status' => 'error',
                'message' => 'payment failed',
            ], 400);
        }
    }
}
