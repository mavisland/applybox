<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'industry',
        'address',
        'phone',
        'email',
        'website',
    ];

    public function hrContacts()
    {
        return $this->hasMany(HrContact::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
