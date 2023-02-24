<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Session;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

  /**
   * show register form
   * 
   * @return view
   */
  public function showRegisterForm()
  {
    return view('register');
  }

  /**
   * Register new user
   * 
   * @param request
   * @return json
   */
  public function register(Request $request)
  {

    $validator = Validator::make($request->all(), [
        'username' => 'required|string|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'address' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $user = User::create([
        'username' => $request['username'],
        'password' => Hash::make($request['password']),
        'name' => $request['name'],
        'surname' => $request['surname'],
        'address' => $request['address'],
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'User registered successfully!',
        'token' => $token,
        'redirect' => '/dashboard',
    ], 201);
  }

  /**
   * Login form page
   * @return 
   */
  public function showLoginForm()
  {
      return view('login');
  }


  /**
   * login function
   * 
   * @param request
   * @return json
   */
  public function login(Request $request)
  {
    if (Auth::check()) {
      return Redirect('dashboard');
    }

    $validator = Validator::make($request->all(), [
      'username' => 'required',
      'password' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $credentials = $request->only('username', 'password');
    if (Auth::attempt($credentials)) {
      return response()->json([
          'redirect' => '/dashboard',
        ], 200);
    }

    return response()->json(['message' => 'Invalid credentials'], 401);
  }

  /**
   * logout function
   * 
   * @param request
   * @return json
   */
  public function logout() {
    if (Auth::check()) {
      Session::flush();
      Auth::logout();
    }
    
    return Redirect('login');
  }

  /**
   * daashboard manager
   * 
   * @return view
   */
  public function dashboard()
  {
    if (Auth::check()) {
      $user = Auth::user();
        
      return view('dashboard', compact('user'));
    }
    
    return view('login');
  }
}
