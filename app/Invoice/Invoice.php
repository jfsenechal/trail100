<?php

namespace App\Invoice;

use App\Invoice\Traits\CurrencyFormatter;
use App\Invoice\Traits\InvoiceHelpers;
use App\Invoice\Traits\SavesFiles;
use App\Invoice\Traits\SerialNumberFormatter;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

/**
 * Class Invoices.
 */
class Invoice
{
    use CurrencyFormatter;
    use InvoiceHelpers;
    use SavesFiles;
    use SerialNumberFormatter;

    public const TABLE_COLUMNS = 4;

    /**
     * @var string
     */
    public $name;

    public $buyer;

    /**
     * @var Collection
     */
    public $items;

    /**
     * @var string
     */
    public $template;

    /**
     * @var string
     */
    public $filename;

    /**
     * @var float
     */
    public $total_amount;

    /**
     * @var PDF
     */
    public $pdf;

    /**
     * @var string
     */
    public $output;

    /**
     * @var array
     */
    protected array $paperOptions;

    /**
     * @var array
     */
    protected $options;

    /**
     * Invoice constructor.
     *
     * @param string $name
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct($name = '')
    {
        // Invoice
        $this->name     = $name ?: __('invoices::invoice.invoice');
        $this->items    = Collection::make([]);
        $this->template = 'default';

        // Serial Number
        $this->series               = config('invoices.serial_number.series');
        $this->sequence_padding     = config('invoices.serial_number.sequence_padding');
        $this->delimiter            = config('invoices.serial_number.delimiter');
        $this->serial_number_format = config('invoices.serial_number.format');
        $this->sequence(config('invoices.serial_number.sequence'));

        // Filename
        $this->filename($this->getDefaultFilename($this->name));

        // Currency
        $this->currency_code                = config('invoices.currency.code');
        $this->currency_fraction            = config('invoices.currency.fraction');
        $this->currency_symbol              = config('invoices.currency.symbol');
        $this->currency_decimals            = config('invoices.currency.decimals');
        $this->currency_decimal_point       = config('invoices.currency.decimal_point');
        $this->currency_thousands_separator = config('invoices.currency.thousands_separator');
        $this->currency_format              = config('invoices.currency.format');

        // Paper
        $this->paperOptions = config('invoices.paper');

        // DomPDF options
        $this->options = array_merge(app('dompdf.options'), config('invoices.dompdf_options') ?? ['enable_php' => true]);

        $this->disk          = config('invoices.disk');
    }

    /**
     * @param string $name
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return Invoice
     */
    public static function make($name = '')
    {
        return new static($name);
    }

    /**
     * @throws Exception
     *
     * @return $this
     */
    public function render()
    {
        if ($this->pdf) {
            return $this;
        }

        $this->beforeRender();

        $template = sprintf('invoices::templates.%s', $this->template);
        $view     = View::make($template, ['invoice' => $this]);
        $html     = mb_convert_encoding($view, 'HTML-ENTITIES', 'UTF-8');

        $this->pdf = PDF::setOptions($this->options)
            ->setPaper($this->paperOptions['size'], $this->paperOptions['orientation'])
            ->loadHtml($html);
        $this->output = $this->pdf->output();

        return $this;
    }

    public function toHtml()
    {
        $template = sprintf('invoices::templates.%s', $this->template);

        return View::make($template, ['invoice' => $this]);
    }

    /**
     * @throws Exception
     *
     * @return Response
     */
    public function stream()
    {
        $this->render();

        return new Response($this->output, Response::HTTP_OK, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $this->filename . '"',
        ]);
    }

    /**
     * @throws Exception
     *
     * @return Response
     */
    public function download()
    {
        $this->render();

        return new Response($this->output, Response::HTTP_OK, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $this->filename . '"',
            'Content-Length'      => strlen($this->output),
        ]);
    }
}
