<?php

namespace App\Invoice\Traits;

use App\Invoice\Buyer;
use App\Invoice\Seller;
use App\Models\Registration;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Exception;
use Symfony\Component\HttpFoundation\File\File;

trait InvoiceHelpers
{
    public function id(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function name(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function date(CarbonInterface|string $date): static
    {
        if (!$date instanceof CarbonInterface) {
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $date);
        }

        $this->date = $date;

        return $this;
    }

    public function status(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function notes(string $notes): static
    {
        $this->notes = $notes;

        return $this;
    }

    public function logo(?string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    public function totalAmount(float $total_amount): static
    {
        $this->total_amount = $total_amount;

        return $this;
    }

    public function getTotalAmountInWords(): string
    {
        return $this->total_amount.' €';
    }

    public function seller(Seller $seller): static
    {
        $this->seller = $seller;

        return $this;
    }

    public function buyer(Buyer $buyer): static
    {
        $this->buyer = $buyer;

        return $this;
    }

    public function registration(Registration $registration): static
    {
        $this->registration = $registration;

        return $this;
    }

    public function template(string $template = 'default'): static
    {
        $this->template = $template;

        return $this;
    }

    public function filename(string $filename): static
    {
        $this->filename = sprintf('%s.pdf', $filename);

        return $this;
    }

    public function getLogo(): string
    {
        $file = new File($this->logo);

        return 'data:'.$file->getMimeType().';base64,'.base64_encode($file->getContent());
    }

    public function hasTotalAmount(): bool
    {
        return !is_null($this->total_amount);
    }

    /**
     * @throws Exception
     */
    protected function beforeRender(): void
    {
        $this->validate();
        $this->calculate();
    }

    /**
     * @throws Exception
     */
    public function validate(): void
    {
        if (!$this->registration) {
            throw new Exception('Buyer not defined.');
        }

        if (!$this->seller) {
            throw new Exception('Seller not defined.');
        }
    }

    public function calculate(): static
    {
        $total_amount = 0;

        /*
         * Apply calculations for provided overrides with:
         * totalAmount(), totalDiscount(), discountByPercent(), totalTaxes(), taxRate()
         * or use values calculated from items.
         */
        $this->hasTotalAmount() ?: $this->total_amount = $total_amount;

        return $this;
    }

    public function formatCurrency(): string
    {
        return $this->total_amount;
    }
}
