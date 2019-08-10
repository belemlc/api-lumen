<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Imports\ContactsImport;
use App\Models\Contact;
use App\Models\ContactList;

class ContactController extends Controller
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

    public function index(Request $request, $listid)
    {
        try {
            $contacts = ContactList::where(['id' => $listid])->with('contacts')->first();
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

    public function create(Request $request, $listid)
    {
        try {
            $request->merge(['contact_list_id' => $listid]);
            Contact::create($request->all());
            $data = [
                'code' => 200,
                'message' => 'Contato criado com sucesso.',
                'result' => []
            ];
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            $data = [
                'code' => 500,
                'message' => 'Erro ao tentar criar um contato.',
                'error' => $th->getMessage()
            ];
            return response()->json($data, 500);
        }
    }
    
    public function import(Request $request, $userid, $listid)
    {
        if (!$request->hasFile('file')) {
            return response()->json([
                'code' => 404,
                'error' => 'É obrigatório o arquivo para importação.'
            ], 404);
        }
        $data = ContactsImport::import($request->file, $userid, $listid);
        return response()->json($data, $data['code']);
    }

    public function view(Request $request, $list, $contact)
    {
        try {
            $contact = Contact::find($contact);
            $data = [
                'code' => 200,
                'message' => '',
                'result' => $contact
            ];
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            $data = [
                'code' => 403,
                'error' => 'Erro ao tentar pegar o contato.',
                'errorMessage' => $th->getMessage()
            ];
            return response()->json($data, 403);
        }
    }

    public function edit($id, Request $request)
    {
        //
    }

    public function update(Request $request, $listid, $id)
    {
        try {
            $request->except('id');
            Contact::find($id)->update($request->all());
            $contacts = ContactList::find($listid)->with('contacts')->first();
            $data = [
                'code' => 200,
                'message' => 'Contato atualizado com sucesso.',
                'results' => $contacts
            ];
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            $data = [
                'code' => 500,
                'message' => 'Erro ao tentar atualizar o contato.',
                'error' => $th->getMessage()
            ];
            return response()->json($data, 500);
        }
    }

    public function destroy(Request $request, $listid, $id)
    {
        try {
            Contact::find($id)->delete();
            $contacts = ContactList::find($listid)->with('contacts')->first();
            $data = [
                'code' => 200,
                'message' => 'Contato removido com sucesso.',
                'results' => $contacts
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