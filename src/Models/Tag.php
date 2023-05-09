<?php

namespace Aspectcs\MyForumBuilder\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];


    protected $casts = [
        'status' => 'boolean',
    ];

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

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopePopular($query)
    {
        return $query->where('popular', true);
    }

    /*public function questions()
    {
        return Question::active()->whereJsonContains('tags', $this->id);
    }*/

    public function questions()
    {
        return $this->hasManyThrough(Question::class,TagsMapping::class, 'tag_id', 'id', 'id', 'question_id');
    }

    public function totalContributors()
    {
        $total = $this->questions()->distinct()->count('client_id');
        $total += Answer::whereIn('question_id', $this->questions()->get()->pluck('id')->toArray())->distinct()->count('client_id');
        return $total;
    }

    public function totalPosts()
    {
        $total = $this->questions()->count();
        $total += Answer::whereIn('question_id', $this->questions()->get()->pluck('id')->toArray())->count();
        return $total;
    }
}
