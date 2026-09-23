<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Facility;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        $facilities = Facility::all();

        return view('home', compact('rooms', 'facilities'));
    }

    public function getRoomsData()
    {
        $rooms = Room::all();
        return response()->json($rooms);
    }
}
