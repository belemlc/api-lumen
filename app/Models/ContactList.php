<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactList extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'title', 'description', 'logo', 'user_id'
    ];

    public function contacts()
    {
        return $this->hasMany('App\Models\Contact', 'contact_list_id' ,'id');
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }
}