<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cvs extends Model
{
    protected $table = 'cvs';
    protected $primarykey ='id';
    protected $fillable =[
        'last_name',
        'first_name',
        'email',
        'phone_number',
        'degree',
        'file_name',
    ];
    use HasFactory;
    //
}
