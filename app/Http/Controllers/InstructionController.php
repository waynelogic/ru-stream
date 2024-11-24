<?php

namespace App\Http\Controllers;

use App\Models\Instruction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InstructionController extends Controller
{
    public function index()
    {
        return Inertia::render('App/Instructions', [
            'instructions' => Inertia::lazy(fn () => Instruction::all() ),
        ]);
    }
}
