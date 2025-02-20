<?php

namespace App\Invoice\Traits;

use Carbon\CarbonInterface;

/**
 * Trait DateFormatter
 */
trait DateFormatter
{
    public CarbonInterface $date;

    public string $date_format;

    public int $pay_until_days;

    public function date(CarbonInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function dateFormat(string $format): static
    {
        $this->date_format = $format;

        return $this;
    }

    public function payUntilDays(int $days): static
    {
        $this->pay_until_days = $days;

        return $this;
    }

    public function getDate(): string
    {
        return $this->date->format($this->date_format);
    }

    public function getPayUntilDate(): string
    {
        return $this->date->copy()->addDays($this->pay_until_days)->format($this->date_format);
    }
}
