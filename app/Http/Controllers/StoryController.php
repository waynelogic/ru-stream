<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
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
        $request->validate(
            rules: [
                'file' => ['required', 'file'],
                'title' => ['required', 'max:50'],
            ],
            attributes: [
                'file' => 'Видео файл',
                'title' => 'Название',
            ]
        );


        $obStory = new Story();
        $obStory->title = $request->title;
        $obStory->user_id = auth()->user()->id;
        $obStory->addMediaFromRequest('file')->toMediaCollection('stories');
        $obStory->save();
        $obStory->generatePoster();

        return back()->flashSuccess('История добавлена');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $obStory = Story::query()->find($id);
        $obStory->delete();

        return back()->flashSuccess('История удалена');
    }
}
