<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Number;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'registration_date',
    ];

    public function walkers(): HasMany
    {
        return $this->hasMany(Walker::class);
    }

    public function priceFormated(): string|bool
    {
        return Number::currency($this->price, in: 'EUR', locale: 'fr_BE');
    }

    public function isPaid(): bool
    {
        return (bool)$this->paid;
    }

    public function setFinished(): void
    {
        $this->finished = true;
    }

    public function isFinished(): bool
    {
       return $this->finished;
    }

    public function totalAmount(): float
    {
        $amount = 0;
        foreach ($this->walkers()->get() as $walker) {
            $amount += $walker->amount();
        }
        return $amount;
    }

    public function runnersPaid(): array
    {
        return $this->all()
            ->filter->isPaid()
            //   ->filter->shipped()
            ->map->items
            ->collapse()
            ->groupBy->product_id
            ->map
            ->sum('price')
            ->filter(function ($total) {
                return $total > 1000;
            })
            ->sortDesc()
            ->take(10);
    }
}
