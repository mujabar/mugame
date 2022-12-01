<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $game = Game::with('item')->get();

        return response()->json([
            'status' => 'success',
            'data' => $game,
        ], 200);
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
        $user = auth()->user();

        if ($user->role == 'admin') {
            $request->validate([
                'name' => 'required|string|max:255',

            ]);

            $game = Game::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
            ]);

            if ($game) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Game Created',
                    'data' => $game,
                ], 201);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Game Failed to Save',
                    'data' => $game,
                ], 409);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'unauthorized',
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
        $game = Game::with('item')->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $game,
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
        $user = auth()->user();

        if ($user->role == 'admin') {
            $game = Game::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $game->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
            ]);

            if ($game) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Game Updated',
                    'data' => $game,
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Game Failed to Update',
                    'data' => $game,
                ], 409);
            }
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
        $user = auth()->user();

        if ($user->role == 'admin') {
            $game = Game::findOrFail($id);

            $game->delete();

            if ($game) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Game Deleted',
                    'data' => $game,
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Game Failed to Delete',
                    'data' => $game,
                ], 409);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'unauthorized',
            ], 401);
        }
    }
}
