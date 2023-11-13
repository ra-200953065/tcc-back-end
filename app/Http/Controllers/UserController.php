<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Mail\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index()
    {
        // return ['data' => User::all()];
        // return ['data' => User::dbSelect()];

        return ['users' => UserResource::collection(User::all())];
    }

    public function restrictList()
    {
        return ['users' => User::dbSelect()];
    }

    // Código OK
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'is_admin' => 'boolean'
        ]);

        // $password = Hash('crc32', $request->email . now());
        $password = substr(md5($request->email . now()), 0, 4);
        $hashedPassword = Hash::make($password);

        $user = User::create(array_merge($request->all(), ['password' => $hashedPassword]));

        //////////////////////////////////////////////////////////////////////////////////
        if (env('APP_ENV') == 'local') {
            return response()->json([
                'user' => $user,
                // 'user' => User::find($user->id),
                'senha' => $password,
                'mensagem' => 'A senha foi passada aqui para não ficar enviando email.'
            ], HTTP_CODE_CREATED);
        }
        //////////////////////////////////////////////////////////////////////////////////

        $mailResponse = Mail::send([
            'to' => $request->email,
            'subject' => env('APP_NAME') . ' - Novo usuário',
            'body' => 'Sua senha é: ' . $password,
        ]);

        if ($mailResponse != true) {
            return response()->json(['message' => $mailResponse['messge']], HTTP_CODE_INTERNAL_ERROR);
        }

        return response()->json(['user' => $user], HTTP_CODE_CREATED);
    }

    public function show(string $id)
    {
        $user = User::find($id);

        if ($user) {
            return ['user' => new UserResource($user)];
        }

        return response()->json([
            'message' => 'Registro não encontrado.'
        ], HTTP_CODE_NOT_FOUND);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'email|unique:users,email,' . $id . ',id',
            'is_admin' => 'boolean'
        ]);

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Registro não encontrado.'
            ], HTTP_CODE_NOT_FOUND);
        }

        $user->update($request->all());

        // $user->tokens()->delete();

        return response()->json(['user' => $user]);
    }

    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Registro não encontrado.'
            ], HTTP_CODE_NOT_FOUND);
        }

        User::destroy($id);

        return response()->json([
            'message' => 'Registro excluído com sucesso.'
        ], HTTP_CODE_OK);
    }
}
