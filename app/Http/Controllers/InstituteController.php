<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use Illuminate\Http\Request;

class InstituteController extends Controller
{
    public function index()
    {
        $institutes = Institute::all();
        return view('admin.institute.index', compact('institutes'));
    }
    public function create()
    {
        return view('admin.institute.create');
    }
}
