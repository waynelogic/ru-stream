<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = [
            'file' => 'Видео файл',
            'title' => 'Название',
            'description' => 'Описание',
        ];

        $request->validate([
            'file' => ['required', 'file'],
            'title' => ['required', 'max:50'],
        ], [], $attributes);

        $obVideo = new Video;

        $obVideo->title = (string) $request->title;
        $obVideo->description = (string) $request->description;
        $obVideo->user_id = (int) auth()->user()->id;
        $obVideo->addMediaFromRequest('file')->toMediaCollection('videos');
        $obVideo->save();
        $obVideo->generatePoster();

        return back()->flashSuccess('Видео добавлено');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => ['required', 'max:50'],
            'description' => ['max:120'],
        ]);

        $obVideo = Video::find($id);
        $obVideo->title = (string) $request->title;
        $obVideo->description = (string) $request->description;
        $obVideo->save();

        return back()->flashSuccess('Видео обновлено');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $obVideo = Video::find($id);
        $obVideo->delete();

        return back()->flashSuccess('Видео удалено');
    }
}
