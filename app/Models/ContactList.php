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
}