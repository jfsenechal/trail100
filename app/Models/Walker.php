<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Walker extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'street',
        'city',
        'country',
        'date_of_birth',
        'phone',
        'tshirt_size',
        'club_name',
        'display_name',
        'gdpr_accepted',
        'registration_date',
        'uuid',
    ];

    protected function casts(): array
    {
        return [

        ];
    }
}
