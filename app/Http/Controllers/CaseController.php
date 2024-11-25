<?php

namespace App\Http\Controllers;

use App\Models\CaseItem;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CaseController extends Controller
{
    public function index()
    {
        return Inertia::render('Guest/Cases',[
            'cases' => Inertia::lazy(fn () => CaseItem::all() ),
        ]);
    }
}
