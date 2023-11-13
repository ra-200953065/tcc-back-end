<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\Mail;
use App\Models\PasswordResetToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Validate Token
    |--------------------------------------------------------------------------
    */
    public function validateToken()
    {
        $userId = auth()->user()->id;

        if (!$userId) {
            return response()->json([
                'message' => 'Token inválido.'
            ], HTTP_CODE_UNAUTHENTICATED);
        }

        $user = User::find($userId);

        return response()->json(['user' => $user]);
    }

    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credenciais inválidas.'], HTTP_CODE_UNAUTHENTICATED);
        }

        if (!$user->email_verified_at || PasswordResetToken::where('email', $user->email)->first()) {
            return response()->json([
                'message' => 'Senha expirada.',
            ], HTTP_CODE_USER_LOCKED);
        }

        return response()->json([
            'user' => $user,
            'token' => $user->createToken($user->email)->plainTextToken,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Forgot Password
    |--------------------------------------------------------------------------
    */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $user = User::where('email', $request->email)->first();

        $password = substr(md5($request->email . now()), 0, 4);
        $hashedPassword = Hash::make($password);

        $user->update([
            'password' => $hashedPassword,
        ]);

        $user->tokens()->delete();

        PasswordResetToken::where('email', $user->email)->delete();

        PasswordResetToken::create([
            'email' => $user->email,
            'token' => hash('ripemd320', $request->email . now()),
        ]);

        if (env('APP_ENV') == 'local') {
            return response()->json([
                'message' => 'Uma nova senha foi enviada para seu e-mail.',
                'modo_local_senha' => $password,
            ]);
        }

        $mailResponse = Mail::send([
            'to' => $request->email,
            'subject' => env('APP_NAME') . ' - Recuperação de acesso',
            'body' => 'Sua nova senha é: ' . $password,
        ]);

        if ($mailResponse != true) {
            return response()->json([
                'message' => 'Não foi possível enviar o e-mail.'
            ], HTTP_CODE_INTERNAL_ERROR);
        }

        return response()->json(['message' => 'Uma nova senha foi enviada para seu e-mail.']);
    }

    /*
    |--------------------------------------------------------------------------
    | Reset Password
    |--------------------------------------------------------------------------
    */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'current_password' => 'required|string',
            'new_password' => 'required|string|confirmed'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Registro não encontrado.'
            ], HTTP_CODE_NOT_FOUND);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'A senha atual está incorreta.'
            ], HTTP_CODE_UNAUTHENTICATED);
        }

        $hashedPassword = Hash::make($request->new_password);

        $user->update([
            'password' => $hashedPassword,
            'email_verified_at' => $user->email_verified_at ?? now(),

        ]);

        PasswordResetToken::where('email', $user->email)->delete();

        return response()->json([
            'user' => $user,
            'token' => $user->createToken($user->email)->plainTextToken
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Change Password
    |--------------------------------------------------------------------------
    */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|confirmed'
        ]);

        $user = User::find(auth()->user()->id);

        if (!$user) {
            return response()->json([
                'message' => 'Registro não encontrado.'
            ], HTTP_CODE_NOT_FOUND);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'A senha atual está incorreta.'
            ], HTTP_CODE_UNAUTHENTICATED);
        }

        $hashedPassword = Hash::make($request->new_password);

        $user->update([
            'password' => $hashedPassword,
        ]);

        $user->tokens()->delete();

        return response()->json([
            'user' => $user,
            'token' => $user->createToken($user->email)->plainTextToken,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Change Profile
    |--------------------------------------------------------------------------
    */
    public function changeProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'email|unique:users,email,' . auth()->user()->id . ',id',
        ]);

        $user = User::find(auth()->user()->id);

        if (!$user) {
            return response()->json([
                'message' => 'Registro não encontrado.'
            ], HTTP_CODE_NOT_FOUND);
        }


        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return response()->json(['message' => 'Perfil alterado com sucesso.']);
    }

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout efetuado com sucesso'
        ]);
    }
}
