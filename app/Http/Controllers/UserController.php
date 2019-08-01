<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        //
    }

    public function create(Request $request)
    {
        $password = Hash::make($request->password);
        $request->merge(['password' => $password]);
        $user = User::create($request->all());
        if ($user) {
            $data = [
                'data' => $user,
                'text' => 'Usuário criado com sucesso!'
            ];
        } else {
            $data = [
                'data' => null,
                'text' => 'Não foi possível criar o usuário.'
            ];
        }
        return response()->json($data);
    }
}
