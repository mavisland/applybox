<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrContact extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'position',
        'email',
        'phone',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
