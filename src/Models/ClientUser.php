<?php

namespace Aspectcs\MyForumBuilder\Models;

use Aspectcs\MyForumBuilder\Enums\ClientUserType;
use Database\Factories\ClientUserFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class ClientUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'email',
        'city',
        'state',
        'country',
        'status',
        'type',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'password',
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
        if ($field == 'username') {
            $res = $this->where('username', $value);
        } else {
            $res = $this->where('id', decrypt($value));
        }
        return $res->firstOrFail();
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'client_id', 'id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'client_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeFake($query)
    {
        return $query->where('type', ClientUserType::FAKE);
    }

    public function scopeReal($query)
    {
        return $query->where('type', ClientUserType::REAL);
    }
    protected static function newFactory()
    {
        return ClientUserFactory::new();
    }
}
