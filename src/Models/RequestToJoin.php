<?php

namespace Aspectcs\MyForumBuilder\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestToJoin extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'email'
    ];
}
