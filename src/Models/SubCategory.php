<?php

namespace Aspectcs\MyForumBuilder\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'priority',
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

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }


    public function questions()
    {
        return $this->hasMany(Question::class, 'sub_category_id', 'id');
    }

    public function lastQuestion()
    {
        return $this->hasOne(Question::class, 'sub_category_id', 'id')->orderBy('created_at', 'DESC');
    }

    public function countTotal()
    {
        $answers = 0;
        foreach ($this->question as $question) {
            $answers += $question->answers()->count();
        }
        return $this->question()->count() + $answers;
    }

    public function totalContributors()
    {
        $total = $this->questions()->distinct()->count('client_id');
        $total += Answer::whereIn('question_id',$this->questions()->pluck('id')->toArray())->distinct()->count('client_id');
        return $total;
    }

    public function totalPosts()
    {
        $total = $this->questions()->count();
        $total += Answer::whereIn('question_id',$this->questions()->pluck('id')->toArray())->count();
        return $total;
    }
}
