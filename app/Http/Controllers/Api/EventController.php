<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class EventController extends Controller
{
    public function ongoing(Request $request) {
        $isValid = false;
        $errorMessage = '';
        $events = [];

        if ($request->has('longitude') and $request->has('latitude')) {
            // query berdasarkan lokasi
        }

        $events = DB::table('events')
            ->where('status', 'A')
            ->get();

        if ($events->isNotEmpty()) {
            $isValid = true;
        }


        return [
            'isValid' => $isValid,
            'errorMessage' => $errorMessage,
            'events' => $events
        ];
    }
}
