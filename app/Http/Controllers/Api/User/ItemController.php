<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $item = Game::with('item')->get();

        return response()->json([
            'status' => 'success',
            'data' => $item,
        ]);
    }

    public function show($id)
    {
        $item = Item::find($id);

        return response()->json([
            'status' => 'success',
            'data' => $item,
        ]);
    }
}
