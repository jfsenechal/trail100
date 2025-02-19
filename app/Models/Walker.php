<?php

namespace App\Models;

use App\Constant\TshirtEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
            'tshirt_size' => TshirtEnum::class,
        ];
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }
    public function amount(): float
    {
        if($this->tshirt_size != TshirtEnum::NO->value){
            return 50;
        }
        return 45;
    }
}
