<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daily extends Model
{
    use HasFactory;

    protected $table = 'accomplishment';

    protected $fillable = [
        'tasktitle',
        'taskdesc',
        'tasktag',
        'user_id',
        'remember_token',
    ];
}
