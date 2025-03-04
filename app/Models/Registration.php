<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;

class Registration extends Model
{
    use HasFactory;
    use HasUuids;

    //use HasUuids;

    protected $fillable = [
        'email',
        'registration_date',
    ];

    public function walkers(): HasMany
    {
        return $this->hasMany(Walker::class);
    }

    public function firstWalker(): HasOne
    {
        return $this->hasOne(Walker::class)->oldest();
    }

    public function isPaid(): bool
    {
        return $this->payment_date !== null;
    }

    public function statusText(): string
    {
        return $this->isPaid() ? __('messages.invoice.paid') : __('messages.invoice.unpaid');
    }

    public function setCompleted(): void
    {
        $this->completed = true;
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }

    public function totalAmount(): float
    {
        $amount = 0;
        foreach ($this->walkers()->get() as $walker) {
            $amount += $walker->amount();
        }

        return $amount;
    }

    public function totalAmountInWords(): string
    {
        return Number::currency($this->totalAmount(), in: 'EUR', locale: 'fr_BE');
    }

    public function registrationDateFormated(): string
    {
        return Carbon::parse($this->registration_date)->translatedFormat('d F Y');
    }

    public function communication(): string
    {
        return '100Km fact '.rand(1, 1000);//todo change it
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
