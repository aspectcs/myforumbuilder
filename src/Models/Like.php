<?php

namespace Aspectcs\MyForumBuilder\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'answer_id',
        'client_id',

        'created_at',
        'updated_at',
    ];

}
