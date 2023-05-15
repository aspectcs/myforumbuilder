<?php

namespace Aspectcs\MyForumBuilder\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'sub_category_id',
        'question',
        'status',
        'description',
        'token',
        'client_id',
        'api_status',
        'api_remarks',
        'slug',
        'visitor_count',
        'created_at',
        'updated_at',
    ];


    protected $casts = [
        'tags' => 'array',
        'status' => 'boolean',
    ];

    /*protected function question(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => html_entity_decode($value),
            set: fn ($value) => htmlentities($value),
        );
    }

    protected function description(): Attribute
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

    public function resolveRouteBinding($value, $field = null)
    {
        if ($field == 'slug') {
            $res = $this->where('slug', $value);
        } else {
            $res = $this->where('id', decrypt($value));
        }
        return $res->firstOrFail();
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function sub_category()
    {
        return $this->hasOne(SubCategory::class, 'id', 'sub_category_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id', 'id');
    }

    public function client()
    {
        return $this->hasOne(ClientUser::class, 'id', 'client_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'question_id', 'id')->where('answer_id', null);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopePopular($query)
    {
        return $query->where('popular', true);
    }

    public function scopeHasOpenAI($query)
    {
        return $query->where('api_status', 'S');
    }

    public function tags()
    {
        return $this->hasManyThrough(Tag::class, TagsMapping::class, 'question_id', 'id', 'id', 'tag_id');
    }

    function increaseVisitor()
    {
        $this->visitor_count += 1;
        $this->save();
    }

    function previous()
    {
        return Question::where('id', '<', $this->id)->orderBy('id', 'desc')->first();
    }

    function next()
    {
        return Question::where('id', '>', $this->id)->orderBy('id', 'asc')->first();
    }
}
