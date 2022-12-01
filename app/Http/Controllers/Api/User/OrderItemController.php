<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function store($id, Request $request)
    {
        $user = auth()->user();

        $item = Item::findOrFail($id);

        if ($user->role == 'user') {
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
                'transaction_code' => 'TRX' . mt_rand(10000, 99999),
                'username' => $request->username,
                'user_id_ml' => $request->user_id_ml,
                'zone_id_ml' => $request->zone_id_ml,
                'status' => 'pending',
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $transaction,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not allowed to access this resource',
            ], 403);
        }
    }
}
