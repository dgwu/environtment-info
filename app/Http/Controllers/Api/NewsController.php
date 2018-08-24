<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class NewsController extends Controller
{
    public function latest(Request $request) {

        $news = DB::table('news')
            ->where('news_type', 'N')
            ->when($request->has('start_from'), function($query) use ($request) {
                return $query->offset($request->start_from);
            })
            ->limit(10)
            ->get();

        return [
            'news' => $news,
        ];
    }

    public function latestreport(Request $request) {

        $reports = DB::table('news')
            ->where('news_type', 'R')
            ->when($request->has('start_from'), function($query) use ($request) {
                return $query->offset($request->start_from);
            })
            ->limit(10)
            ->get();

        return [
            'reports' => $reports,
        ];
    }

    public function report(Request $request) {
        // title
        // description
        // location_desc
        // location_longitude
        // location_latitude
        // image
        
        if ($request->has('title')
        ) {

        }
    }
}
