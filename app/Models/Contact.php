<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'gender',
        'birthday',
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

    public function getCreatedAtAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    public function getBirthdayAttribute($value)
    {
        if (!empty($value)) {
            return date('d/m/Y', strtotime($value));
        }
    }

    public function setBirthdayAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['birthday'] = implode('-', array_reverse(explode('/', $value)));
        }
    }

    public function setCellphoneAttribute($value)
    {
        $this->attributes['cellphone'] = preg_replace('/[^0-9]/s', '', $value);
    }

    public function setGenderAttribute($value)
    {
        $this->attributes['gender'] = \strtolower($value);
    }

    public function contactList()
    {
        return $this->hasMany('App\Models\ContactList', 'id', 'contact_list_id');
    }
}