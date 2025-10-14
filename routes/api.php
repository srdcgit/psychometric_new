<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Example public route
Route::get('/hello', function () {
    return response()->json(['message' => 'Hello from testing Career Map API!']);
});
