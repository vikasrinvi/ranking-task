<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    
    public function index()
    {
        $players = Player::all();
        return response()->json(['data' => $players]);
    }
}
