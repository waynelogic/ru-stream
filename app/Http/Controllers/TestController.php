<?php

namespace App\Http\Controllers;

use App\Models\Video;

class TestController extends Controller
{
    public function index()
    {
        $obVideo = Video::find(2);
        dd($obVideo->generatePoster());
    }
}
