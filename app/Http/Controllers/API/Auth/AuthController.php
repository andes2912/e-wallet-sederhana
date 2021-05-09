<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use App\Models\{User,auth_activity,saldo_user};
use Auth;

class AuthController extends Controller
{

    //  Register
    public function register(Request $request)
    {
      $validator = Validator::make($request->all(),[
        'name'      => 'required|max:55',
        'email'     => 'email|required|unique:users',
        'password'  => ['required', 'confirmed', Password::min(8)
            ->mixedCase()
            ->letters()
            ->numbers()
            ->symbols()
            // ->uncompromised(),
        ],
      ]);

       if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }


      $user = User::create([
        'name'                    => $request->name,
        'email'                   => $request->email,
        'password'                => bcrypt($request->password),
        'password_confirmation'   => bcrypt($request->password_confirmation),
      ]);

      // Jika user berhasil register input id user ke table saldo
      if ($user) {
        $saldo = saldo_user::create([
          'user_id' => $user->id
        ]);
      }

      $accessToken = $user->createToken('ApiToken')->accessToken;

      return response()->json([
        'user'          => $user,
        'access_token'  => $accessToken,
        'saldo'         => $saldo
      ],200);

    }


    // Login
    public function login(Request $request)
    {
      try {
        if (Auth::attempt($request->only('email','password'))) {
          $user = Auth::user();
          $tokenResult = $user->createToken('Personal Access Token');
          $token = $tokenResult->accessToken;

          // Log
          $log = auth_activity::create([
            'user_id' => $user->id,
            'ip'      => $request->ip(),
            'user_agent'  => $request->header('User-Agent'),
            'method'    => 'Login'
          ]);
          return \response()->json([
            'success' => true,
            'token'   => $token,
            'user'    => $user,
            'log'     => $log,
          ], 200);
        }
      } catch (\Exception $expection) {
        return \response()->json([
          'message' => $expection->getMessage()
        ], 400);
      }


      return \response()->json([
        'success' => false,
        'message' => 'Invalid Username/Password'
      ]);
    }

    // User
    public function me()
    {
      return Auth::user();
    }

    public function logout(Request $request)
    {
      if (Auth::user()) {
        $user = Auth::user()->token();
        $user->revoke();

        return response()->json([
          'success' => true,
          'message' => 'Logout successfully'
        ],200);
      }else {
        return response()->json([
          'success' => false,
          'message' => 'Unable to Logout'
        ],400);
      }
    }

}
