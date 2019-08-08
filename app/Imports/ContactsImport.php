<?php

namespace App\Imports;

use App\Models\Contact;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ContactsImport
{
    public static function import($file, $userid, $list)
    {
        try {
            $path = $file->getRealPath();
            $extension = $file->getClientOriginalExtension();
            $contacts = null;
            switch ($extension) {
                case 'csv':
                    $reader = new Csv();
                    $csv = $reader->load($path);
                    $contacts = $csv->getActiveSheet()->toArray();
                    break;
                case 'xls':
                    $reader = new Xls();
                    $reader->setReadDataOnly(true);
                    $csv = $reader->load($path);
                    $contacts = $csv->getActiveSheet()->toArray();
                    break;
                case 'xlsx':
                    $reader = new Xlsx();
                    $reader->setReadDataOnly(true);
                    $csv = $reader->load($path);
                    $contacts = $csv->getActiveSheet()->toArray();
                    break;

                default:
                    # code...
                    break;
            }
            $header = $contacts[0];
            unset($contacts[0]);

            foreach($contacts as $contact) {
                
                $birtday = implode('-', array_reverse(explode('/', $contact[4])));
                $gender = \strtolower($contact[3]);

                if (!empty($contact[0]) && !empty($contact[1])) {
                    $data = [
                        'name' => $contact[0],
                        'cellphone' => $contact[1],
                        'email' => $contact[2],
                        'gender' => $gender,
                        'birtday' => $birtday,
                        'region' => $contact[5],
                        'city' => $contact[6],
                        'state' => $contact[7],
                        'country' => $contact[8],
                        'cep' => $contact[9],
                        'contact_list_id' => $list
                    ];
                    Contact::updateOrCreate([
                        'cellphone' => $contact[1],
                        'email' => $contact[2],
                        'contact_list_id' => $list
                    ], $data);
                }
            }
            return [
                'metadata' => [],
                'code' => 200,
                'message' => 'Importação efetuada com sucecsso.'
            ];
        } catch (\Exception $e) {
            return [
                'metadata' => [],
                'code' => 500,
                'error' => $e->getMessage(),
                'message' => 'Erro ao tentar importar o contato.'
            ];
        }


    }
}
