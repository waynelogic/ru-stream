<?php namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Video;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $arVideos = Video::all()->append(['video_url', 'poster_url']);
        $arStories = Story::all()->append(['video_url', 'poster_url']);

        return Inertia::render('Dashboard/Index', [
            'videos' => $arVideos,
            'stories' => $arStories,
        ]);
    }
}
