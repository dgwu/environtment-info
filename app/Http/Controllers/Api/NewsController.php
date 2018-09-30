<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class NewsController extends Controller
{
    public function latest(Request $request) {
        $isValid = true;

        $news = DB::table('news')
            ->where('news_type', 'N')
            ->when($request->has('start_from'), function($query) use ($request) {
                return $query->offset($request->start_from);
            })
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'isValid' => $isValid,
            'news' => $news,
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    public function latestreport(Request $request) {
        $isValid = true;

        $reports = DB::table('news')
            ->where('news_type', 'R')
            ->when($request->has('start_from'), function($query) use ($request) {
                return $query->offset($request->start_from);
            })
            ->orderBy('id', 'desc')
            ->get();
            
        return response()->json([
            'isValid' => $isValid,
            'reports' => $reports,
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    public function postReport(Request $request) {
        $isValid = false;
        $errorMessage = '';
        $photoPath = 'https://via.placeholder.com/200?text=No+Image';

        $user = [];

        if ($request->has('api_token') and !empty($request->api_token)) {
            $user = DB::table('users')
                ->where('api_token', $request->api_token)
                ->first();
        }


        if ($request->has('title')
            and $request->has('body')
            and $request->has('location_desc')
            and $request->has('location_longitude')
            and $request->has('location_latitude')
            and !empty($user)) {

            try {
                DB::beginTransaction();

                // upload photo
                if ($request->hasFile('photo') and $request->file('photo')->isValid()) {
                    $fullPath = $request->file('photo')->store('public/photos/reports');
                    $fileName = basename($fullPath);
                    $photoPath = url('/') . "/storage/photos/reports/" . $fileName;
                }

                DB::table('news')
                    ->insert([
                        'title' => $request->title,
                        'body' => $request->body,
                        'description' => str_limit($request->body, 90),
                        'location_desc' => $request->location_desc,
                        'location_longitude' => $request->location_longitude,
                        'location_latitude' => $request->location_latitude,
                        'photo_url' => $photoPath,
                        'created_by' => $user->id,
                        'created_at' => \Carbon\Carbon::now(),
                        'news_type' => 'R',
                    ]);
                DB::commit();
                $isValid = true;
            } catch (\Exception $e) {
                DB::rollBack();
                $errorMessage = e($e->getMessage());
            }

        } else {
            $errorMessage = "insufficient data provided.";
        }

        return response()->json([
            'isValid' => $isValid,
            'errorMessage' => $errorMessage,
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    public function issuesReported(Request $request) {
        $isValid = false;
        $errorMessage = '';
        $reportList = [];
        $userData = [];

        if ($request->has('api_token') and !empty($request->api_token)) {
            $userData = DB::table('users')
                ->where('api_token', $request->api_token)
                ->first();

            if (!empty($userData)) {
                $isValid = true;
                $todayDate = \Carbon\Carbon::now();

                $reportList = DB::table('news')
                    ->where('created_by', $userData->id)
                    ->where('news_type', 'R')
                    ->get();
            }
        }

        return response()->json([
            'isValid' => $isValid,
            'errorMessage' => $errorMessage,
            'reports' => (!empty($reportList) and count((array)$reportList)) ? $reportList : ''
        ], 200, [], JSON_NUMERIC_CHECK);
    }
}
