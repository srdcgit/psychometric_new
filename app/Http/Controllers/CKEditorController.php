<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CKEditorController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // Store the file directly in the storage/app/public folder
            $path = Storage::disk('public')->putFileAs('ckeditor-images', $file, $fileName);
            
            // Generate the correct URL using asset helper
            $url = asset('storage/' . $path);
            
            return response()->json([
                'url' => $url
            ]);
        }
        
        return response()->json([
            'error' => 'No image file provided.'
        ], 400);
    }
} 