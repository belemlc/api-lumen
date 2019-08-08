<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'gender',
        'birtday',
        'cep',
        'street',
        'region',
        'city',
        'state',
        'country',
        'cellphone',
        'contact_list_id',
        'user_id'
    ];

    public function contactList()
    {
        return $this->hasMany('App\Models\ContactList', 'id', 'contact_list_id');
    }
}