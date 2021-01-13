<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\StaticContent;

class StaticContentController extends Controller
{
    //
    public function getContent($slug)
    {
        $staticDb = StaticContent::where('type', $slug)->firstOrFail();
        return response()->json(['content' => $staticDb->content]);
    }
}
