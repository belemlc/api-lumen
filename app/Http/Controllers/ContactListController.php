<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ContactList;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ContactListController extends Controller
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

    public function index(Request $request)
    {
        //
    }

    public function create(Request $request, $userid)
    {
        try {
            $request->merge(['user_id' => $userid]);
            ContactList::create($request->all());
            $data = [
                'code' => 200,
                'message' => 'Lista criada com sucesso.'
            ];
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            $data = [
                'code' => 403,
                'error' => 'Erro ao tentar criar uma lista.',
                'errorMessage' => $th->getMessage()
            ];
            return response()->json($data, 403);
        }
    }

    public function view(Request $request, $userid)
    {
        try {
            $listas = ContactList::where(['user_id' => $userid])->get();
            $data = [
                'code' => 200,
                'message' => '',
                'result' => $listas
            ];
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            $data = [
                'code' => 403,
                'error' => 'Erro ao tentar pegar as listas do usuário.',
                'errorMessage' => $th->getMessage()
            ];
            return response()->json($data, 403);
        }
    }

    public function edit($id, Request $request)
    {
        //
    }

    public function update(Request $request, $userid, $listid)
    {
        try {
            $request->merge(['user_id' => $userid]);
            ContactList::find($listid)->update($request->all());
            $data = [
                'code' => 200,
                'message' => 'Lista atualizada com sucesso.'
            ];
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            $data = [
                'code' => 403,
                'error' => 'Erro ao tentar atualizar uma lista.',
                'errorMessage' => $th->getMessage()
            ];
            return response()->json($data, 403);
        }
    }

    public function delete($id, Request $request)
    {
        //
    }
}