<?php

namespace App\Http\Controllers;

use App\Models\CaseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $cases = CaseItem::take(3)->get();
        return Inertia::render('Home', [
            'cases' => $cases
        ]);
    }
}
