<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AssetController extends Controller
{
    /**
     * save image to local
     * 
     * @param request
     * @return json
     */
    public function storeImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();
        $file = $request->file('image');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/images', $filename);

        $imageUrl = Storage::url('images/' . $filename);
        
        $user->profile_image = $filename;
        $user->save();

        return response()->json([
            'imageSrc' => $imageUrl,
            'message' => 'File uploaded successfully!'
        ]);
    }
}