<?php

namespace Aspectcs\MyForumBuilder\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'fields',
        'values',
        'status',
        'priority',
    ];


    protected $casts = [
        'fields' => 'array',
        'values' => 'array',
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

        $res = $this->where('id', decrypt($value));

        return $res->firstOrFail();
    }

    public function scopeGetData($query, $id)
    {
        return $query->where('id', $id)->firstOrFail()->values;
    }

    public function scopeCheckAndCreate($query, $checker, $array)
    {
        if ($query->where($checker)->exists()) {
            $query->where($checker)->update([
                'title' => $array['title'],
                'fields' => $array['fields'],
                'priority' => $array['priority'],
            ]);
        } else {
            $query->create(array_merge($checker, $array));
        }
    }
}
