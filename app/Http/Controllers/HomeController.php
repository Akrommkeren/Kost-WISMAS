<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Facility;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $rooms = Room::all();
        $facilities = Facility::all();

        if (auth()->check() && auth()->user()->isOwner() && $request->query('view') !== 'preview') {
            return view('owner', compact('rooms', 'facilities'));
        }

        return view('home', compact('rooms', 'facilities'));
    }

    public function getRoomsData()
    {
        $rooms = Room::all();
        return response()->json($rooms);
    }
}
