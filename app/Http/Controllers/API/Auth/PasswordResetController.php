<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Models\{password_reset,User};
use Mail;
use Str;

class PasswordResetController extends Controller
{
    //Reset Password
    public function createreset(Request $request)
    {
      $validator = Validator::make($request->all(),[
        'email' => 'required|email'
      ]);

      if ($validator->fails()) {
        return response()->json(['error'=>$validator->errors()], 401);
      }

      $email = $request->email;

      if (User::where('email', $email)->doesntExist()) {
        return \response()->json([
          'message' => 'User done\'t exits'
        ], 404);
      }

      $token = Str::random(20);

      $reset = password_reset::create([
        'token' => $token,
        'email' => $email
      ]);

      $data = array(
        'nama'  => 'Annisa',
        'token' => $token
      );

      if ($reset) {
        Mail::send('Auth.reset', $data, function($mail) use ($email, $data){
          $mail->to($email,'no-replay')
                  ->subject("E-Laundry - Nomor Invoice");
          $mail->from('laundri.dev@gmail.com');
          });
      }

      return \response()->json([
        'message' => 'Please check your email'
      ]);

    }

    // Proses reset
    public function reset(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'token' => 'required',
        'password'  => ['required', 'confirmed', Password::min(8)
            ->mixedCase()
            ->letters()
            ->numbers()
            ->symbols()
        ],
      ]);

      if ($validator->fails()) {
          return response()->json(['error'=>$validator->errors()], 401);
      }

      $token = $request->token;

      if (!$passwordReset = password_reset::where('token', $token)->first()) {
        return \response()->json([
          'message' => 'Invalid token'
        ],400);
      }

      if (!$user = User::where('email',$passwordReset->email)->first()) {
        return \response()->json([
          'message' => 'User doesn\'t exist'
        ],404);
      }

      $user->password = bcrypt($request->password);
      $user->save();

      return \response()->json([
        'success' => true,
      ]);

    }
}
