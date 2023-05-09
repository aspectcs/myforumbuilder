<?php

namespace Aspectcs\MyForumBuilder\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagsMapping extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'question_id',
        'tag_id',
    ];

    public function tag()
    {
        return $this->hasOne(Tag::class, 'id', 'tag_id');
    }

    public function question()
    {
        return $this->hasOne(Question::class, 'id', 'question_id');
    }

}
