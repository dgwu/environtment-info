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
        $eventList = [];
        $userParticipatedEvents = [];
        $userData = [];

        if ($request->has('longitude') and $request->has('latitude')) {
            // query berdasarkan lokasi
        }

        if ($request->has('api_token') and !empty($request->api_token)) {
            $userData = DB::table('users')
                ->where('api_token', $request->api_token)
                ->first();

            if (!empty($userData)) {
                $userParticipatedEvents = DB::table('event_participants')
                    ->where('user_id', $userData->id)
                    ->where('status', 'A')
                    ->pluck('event_id')->toArray();
            }
        }

        $events = DB::table('events')
            ->where('status', 'A')
            ->get();

        if ($events->isNotEmpty()) {
            $isValid = true;

            foreach ($events as $event) {
                $eventList[] = [
                    'id' => $event->id,
                    'title' => $event->title,
                    'body' => $event->body,
                    'description' => $event->description,
                    'held_at' => \Carbon\Carbon::parse($event->held_at)->toDayDateTimeString(),
                    'location_desc' => $event->location_desc,
                    'location_latitude' => $event->location_latitude,
                    'location_longitude' => $event->location_longitude,
                    'photo_url' => $event->photo_url,
                    'is_participated' => in_array($event->id, $userParticipatedEvents),
                ];
            }
        }

        return response()->json([
            'isValid' => $isValid,
            'errorMessage' => $errorMessage,
            'events' => $eventList
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

    public function upcoming(Request $request) {
        $isValid = false;
        $errorMessage = '';
        $eventList = [];
        $userData = [];

        if ($request->has('api_token') and !empty($request->api_token)) {
            $userData = DB::table('users')
                ->where('api_token', $request->api_token)
                ->first();

            if (!empty($userData)) {
                $isValid = true;

                $todayDate = \Carbon\Carbon::now();

                $userParticipatedEvents = DB::table('event_participants')
                    ->where('user_id', $userData->id)
                    ->where('status', 'A')
                    ->pluck('event_id')->toArray();

                $eventList = DB::table('events')
                    ->whereIn('id', $userParticipatedEvents)
                    ->where('status', 'A')
                    ->whereDate('held_at', '>=', $todayDate)
                    ->get();
            }
        }

        return response()->json([
            'isValid' => $isValid,
            'errorMessage' => $errorMessage,
            'events' => (!empty($eventList) and count((array)$eventList)) ? $eventList : ''
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    public function participated(Request $request) {
        $isValid = false;
        $errorMessage = '';
        $eventList = [];
        $userData = [];

        if ($request->has('api_token') and !empty($request->api_token)) {
            $userData = DB::table('users')
                ->where('api_token', $request->api_token)
                ->first();

            if (!empty($userData)) {
                $isValid = true;

                $todayDate = \Carbon\Carbon::now();

                $userParticipatedEvents = DB::table('event_participants')
                    ->where('user_id', $userData->id)
                    ->where('status', 'A')
                    ->pluck('event_id')->toArray();

                $eventList = DB::table('events')
                    ->whereIn('id', $userParticipatedEvents)
                    ->where('status', 'A')
                    ->whereDate('held_at', '<', $todayDate)
                    ->get();
            }
        }

        return response()->json([
            'isValid' => $isValid,
            'errorMessage' => $errorMessage,
            'events' => (!empty($eventList) and count((array)$eventList)) ? $eventList : ''
        ], 200, [], JSON_NUMERIC_CHECK);
    }
}
