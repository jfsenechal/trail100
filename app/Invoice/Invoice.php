<?php

namespace App\Invoice;

use App\Invoice\Traits\CurrencyFormatter;
use App\Invoice\Traits\DateFormatter;
use App\Invoice\Traits\InvoiceHelpers;
use App\Invoice\Traits\PdfHelper;
use App\Invoice\Traits\SavesFiles;
use App\Invoice\Traits\SerialNumberFormatter;
use App\Models\Registration;
use App\Models\Walker;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class Invoice
{
    use CurrencyFormatter;
    use InvoiceHelpers;
    use DateFormatter;
    use SavesFiles;
    use PdfHelper;
    use SerialNumberFormatter;

    public int $table_columns = 4;

    public string $name;

    public ?string $logo;

    public Seller $seller;

    public Buyer $buyer;

    public Registration $registration;

    /**
     * @var Collection<int,Walker>
     */
    public Collection $items;

    public float $total_amount;

    public string $status;

    public array $paperOptions;

    /**
     * @see \Dompdf\Options
     */
    public array $options;

    public ?string $notes = null;

    /**
     * Invoice constructor.
     *
     * @param string $name
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(string $name = '')
    {
        // Invoice
        $this->name = $name ?: __('invoices::invoice.invoice');
        $this->items = Collection::make([]);
        $this->template = 'invoice';

        // Date
        $this->date = Carbon::now();
        $this->date_format = config('invoices.date.format');
        $this->pay_until_days = config('invoices.date.pay_until_days');

        // Serial Number
        $this->series = config('invoices.serial_number.series');
        $this->sequence_padding = config('invoices.serial_number.sequence_padding');
        $this->delimiter = config('invoices.serial_number.delimiter');
        $this->serial_number_format = config('invoices.serial_number.format');
        $this->sequence(config('invoices.serial_number.sequence'));

        // Filename
        $this->filename($this->getDefaultFilename($this->name));

        // Currency
        $this->currency_code = config('invoices.currency.code');
        $this->currency_fraction = config('invoices.currency.fraction');
        $this->currency_symbol = config('invoices.currency.symbol');
        $this->currency_decimals = config('invoices.currency.decimals');
        $this->currency_decimal_point = config('invoices.currency.decimal_point');
        $this->currency_thousands_separator = config('invoices.currency.thousands_separator');
        $this->currency_format = config('invoices.currency.format');

        // Paper
        $this->paperOptions = config('invoices.paper');

        // DomPDF options
        /**
         * @see \Dompdf\Options
         */
        $this->options = array_merge(
            app('dompdf.options'),
            config('invoices.dompdf_options') ?? ['enable_php' => true, 'enable_remote' => true],
        );

        $this->disk = config('invoices.disk');
    }

    /**
     * @param string $name
     *
     * @return Invoice
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     */
    public static function make($name = '')
    {
        return new static($name);
    }


}
