<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class NewsController extends Controller
{
    public function latest(Request $request) {

        $news = DB::table('news')
            ->when($request->has('start_from'), function($query) use ($request) {
                return $query->offset($request->start_from);
            })
            ->limit(10)
            ->get();

        return [
            'news' => $news,
            'request' => $request->all(),
        ];
    }
}
