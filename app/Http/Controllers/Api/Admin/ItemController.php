<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item = Item::all();

        return response()->json([
            'success' => true,
            'message' => 'List Data Item',
            'data' => $item
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
        ]);

        $auth = auth()->user();

        if ($auth->role == 'admin') {
            $item = Item::create([
                'game_id' => $request->game_id,
                'name' => $request->name,
                'price' => $request->price,
            ]);

            if ($item) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item Created',
                    'data' => $item
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Item Failed to Save',
                    'data' => $item
                ], 409);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
                'data' => ''
            ], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Item',
            'data' => $item
        ], 200);
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


        $auth = auth()->user();

        if ($auth->role == 'admin') {
            $item = Item::findOrFail($id);

            $item->update([
                'name' => $request->name ?? $item->name,
                'price' => $request->price ?? $item->price,
            ]);

            if ($item) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item Updated',
                    'data' => $item
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Item Failed to Update',
                    'data' => $item
                ], 409);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
                'data' => ''
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
        $auth = auth()->user();

        if ($auth->role == 'admin') {
            $item = Item::findOrFail($id);

            $item->delete();

            if ($item) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item Deleted',
                    'data' => $item
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Item Failed to Delete',
                    'data' => $item
                ], 409);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
                'data' => ''
            ], 401);
        }
    }
}
