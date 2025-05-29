<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CKEditorController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // Create directory if it doesn't exist
            $uploadPath = public_path('uploads/ckeditor-images');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            // Move the file directly to public directory
            $file->move($uploadPath, $fileName);
            
            // Generate URL (relative to public directory)
            $url = asset('uploads/ckeditor-images/' . $fileName);
            
            return response()->json([
                'url' => $url
            ]);
        }
        
        return response()->json([
            'error' => 'No image file provided.'
        ], 400);
    }
} 