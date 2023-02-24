<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Session;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
  /**
   * Show edit profile page
   * 
   * @return view
   */
  public function editProfileForm()
  {
    return view('edit_profile');
  }

  /**
   * Get user profile
   * 
   * @return json
   */
  public function getProfile()
  {
      $user = Auth::user();
      $userData = json_decode($user, true);
      $imageUrl = Storage::url('images/' . $userData['profile_image']);

      return response()->json([
        'user' => $user,
        'imageSrc' => $imageUrl,
    ], 200);
  }

  /**
   * update user profile
   * 
   * @param request
   * @return json
   */
  public function updateProfile(Request $request)
  {
    $user = Auth::user();

    $validator = Validator::make($request->all(), [
      'name' => 'required|string|max:255',
      'surname' => 'required|string|max:255',
      'address' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
      return response()->json([
          'errors' => $validator->errors(),
      ], 422);
    }

    $user->name = $request->input('name');
    $user->surname = $request->input('surname');
    $user->address = $request->input('address');
    $user->save();

    return response()->json([
      'message' => 'Profile updated successfully!',
      'redirect' => '/dashboard',
    ], 201);
  }
}