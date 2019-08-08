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
            $contacts = ContactList::find($listid)->with('contacts')->first();
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

    public function create(Request $request, $userid, $listid)
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

    public function view($id, Request $request)
    {
        //
    }

    public function edit($id, Request $request)
    {
        //
    }

    public function update($id, Request $request)
    {
        //
    }

    public function delete($id, Request $request)
    {
        //
    }
}