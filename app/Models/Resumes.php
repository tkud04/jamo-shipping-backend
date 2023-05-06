<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resumes extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name' , 'email',
        'phone', 'address' , 'city',
        'zip_code', 'pic' , 'status'
    ];
    
}
