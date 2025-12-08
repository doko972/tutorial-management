<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CKEditorController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $file = $request->file('upload');
        $filename = time() . '_' . $file->getClientOriginalName();
        
        $path = $file->storeAs('uploads/ckeditor', $filename, 'public');

        return response()->json([
            'url' => Storage::url($path)
        ]);
    }
}