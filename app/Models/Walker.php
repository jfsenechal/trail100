<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Walker extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);//belong id set here
    }
}
