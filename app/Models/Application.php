<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Application extends Model implements HasMedia
{
    use InteractsWithMedia;
    
    protected $fillable = [
        'company_id',
        'hr_contact_id',
        'position',
        'applied_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'applied_date' => 'date',
    ];
    
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function hrContact()
    {
        return $this->belongsTo(HrContact::class);
    }
    
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('documents');
    }
}
