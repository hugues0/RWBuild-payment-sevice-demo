<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Role extends Model
{
    use HasFactory;

    public const IS_USER=1;
    public const IS_ADMIN=2;
    public const IS_SUPER_ADMIN=3;
    /**
     * relationships
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
