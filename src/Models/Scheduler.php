<?php

namespace Aspectcs\MyForumBuilder\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scheduler extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'file_path',
        'total_count',
        'error_count',
        'success_count',
        'errors',
        'status',
    ];

    protected $casts = [
        'errors' => 'array',
    ];

    protected function encryptId(): Attribute
    {
        return new Attribute(
            get: fn($value, $attributes) => encrypt($attributes['id']),
        );
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('id', decrypt($value))->firstOrFail();
    }
}
