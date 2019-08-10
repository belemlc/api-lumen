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

            foreach ($contacts as $contact) {
                if (!empty($contact[0]) && !empty($contact[1])) {
                    $data = [
                        'name' => $contact[0],
                        'cellphone' => $contact[1],
                        'email' => $contact[2],
                        'gender' => $contact[3],
                        'birthday' => $contact[4],
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
            return true;
        } catch (\Exception $e) {
            return false;
            // $e->getMessage()
        }


    }
}
