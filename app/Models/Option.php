<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'optiontask';

    protected $fillable = [
        'option_name',
        'remember_token'
    ];
}
