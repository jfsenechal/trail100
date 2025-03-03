<?php

namespace App\Models;

use App\Constant\TshirtEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

class Walker extends Model
{
    use HasFactory;
    use HasUuids;

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

    public function name(): string
    {
        return $this->first_name.' '.Str::upper($this->last_name);
    }

    public function amount(): float
    {
        if ($this->tshirt_size->value !== TshirtEnum::NO->value) {
            return 50;
        }

        return 45;
    }

    public function isPaid(): bool
    {
        return $this->registration()->payement_date !== null;
    }

    public function amountInWords(): string
    {
        return Number::currency($this->amount(), in: 'EUR', locale: 'be');
    }

}
