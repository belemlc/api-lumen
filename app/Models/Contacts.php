<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    protected $fillable = [
        'name',
        'email',
        'gender',
        'birtday',
        'cep',
        'region',
        'city',
        'state',
        'country',
        'cellphone',
        'contact_list_id',
        'user_id'
    ];
}