<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role == 'admin') {
            $transaction = Transaction::with(['item'])->get();

            return response()->json([
                'status' => 'success',
                'data' => $transaction,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'unauthorized',
            ], 401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = auth()->user();

        if ($user->role == 'admin') {
            $transaction = Transaction::with(['item'])->findOrFail($id);
            $payment = Payment::where('transaction_id', $id)->first();

            return response()->json([
                'status' => 'success',
                'data' => $transaction,
                'payment' => $payment,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'unauthorized',
            ], 401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();

        if ($user->role == 'admin') {
            $transaction = Transaction::where('id', $id)->update([
                'status' => 'SUCCESS',
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $transaction,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'unauthorized',
            ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
