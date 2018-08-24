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

        return response()->json([
            'isValid' => $isValid,
            'errorMessage' => $errorMessage,
            'events' => $events
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    public function participate(Request $request) {
        $isValid = false;
        $errorMessage = '';
        $user = '';

        $user = \Auth::guard('api')->user();

        if ($request->has('event_id')){
            $eventData = DB::table('events')
                ->where('id', $request->event_id)
                ->where('status', 'A')
                ->first();

            if (!empty($eventData)) {
                $isAlreadyParticipate = DB::table('event_participants')
                    ->where('user_id', $user->id)
                    ->where('event_id', $request->event_id)
                    ->first();

                try {
                    DB::beginTransaction();
                    if (!empty($isAlreadyParticipate)) {
                        if ($isAlreadyParticipate->status == 'I') {
                            // update
                            DB::table('event_participants')
                            ->where('id', $isAlreadyParticipate->id)
                            ->update([
                                'status' => 'A',
                                'updated_at' => \Carbon\Carbon::now(),
                            ]);
                        } else {
                            // do nothing
                        }
                        
                    } else {
                        // insert
                        DB::table('event_participants')
                        ->insert([
                            'event_id' => $request->event_id,
                            'user_id' => $user->id,
                            'status' => 'A',
                            'created_at' => \Carbon\Carbon::now(),
                        ]);
                    }
                    DB::commit();
                    $isValid = true;
                } catch (\Exception $e) {
                    DB::rollBack();
                    $errorMessage = e($e->getMessage());
                }
            } else {
                $errorMessage = 'event not found';
            }
        } else {
            $errorMessage = 'insufficient data provided';
        }

        return response()->json([
            'isValid' => $isValid,
            'errorMessage' => $errorMessage,
        ], 200, [], JSON_NUMERIC_CHECK);
    }
}
