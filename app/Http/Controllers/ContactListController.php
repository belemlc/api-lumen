<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ContactList;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Contact;

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

    public function index(Request $request, $userid)
    {
        try {
            $contacts = ContactList::where(['user_id' => $userid])->with('contacts')->get();
            $data = [
                'code' => 200,
                'message' => '',
                'result' => $contacts
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
            $listas = ContactList::where(['user_id' => $userid])->with('contacts')->get();
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

    public function destroy(Request $request, $userid, $listid)
    {
        try {
            $contacts = Contact::where(['contact_list_id' => $listid])->count();
            if ($contacts > 0) {
                throw new Exception("Não foi possível remover a lista, existe contatos.", 1);
            }
            ContactList::find($listid)->delete();
            $lists = ContactList::where(['user_id' => $userid])->with('contacts')->count();
            $data = [
                'code' => 200,
                'message' => 'Lista de contato removida com sucesso.',
                'results' => $lists
            ];
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            $data = [
                'code' => 500,
                'message' => 'Erro ao tentar excluir um contato.',
                'error' => $th->getMessage()
            ];
            return response()->json($data, 500);
        }
    }
}