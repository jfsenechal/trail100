<?php

namespace App\Invoice;

use App\Invoice\Traits\InvoiceHelpers;
use App\Invoice\Traits\PdfHelper;
use App\Invoice\Traits\SavesFiles;
use App\Models\Registration;
use App\Models\Walker;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;

class Invoice
{
    use InvoiceHelpers;
    use SavesFiles;
    use PdfHelper;

    public int $table_columns = 4;

    public string $id;

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

    public CarbonInterface|Carbon $date;

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

        $this->disk = 'invoices';
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
