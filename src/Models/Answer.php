<?php

namespace Aspectcs\MyForumBuilder\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'answer',
        'answer_html',
        'client_id',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];


   /* protected function answer(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => html_entity_decode($value),
            set: fn ($value) => htmlentities($value),
        );
    }


    protected function answer_html(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => html_entity_decode($value),
            set: fn ($value) => htmlentities($value),
        );
    }*/

    protected function encryptId(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => encrypt($attributes['id']),
        );
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }


    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('id', decrypt($value))->firstOrFail();
    }

    public function question()
    {
        return $this->hasOne(Question::class, 'id', 'question_id');
    }

    public function client()
    {
        return $this->hasOne(ClientUser::class, 'id', 'client_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'answer_id', 'id');
    }
}
