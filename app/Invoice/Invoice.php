<?php

namespace App\Invoice;

use App\Invoice\Traits\CurrencyFormatter;
use App\Invoice\Traits\DateFormatter;
use App\Invoice\Traits\InvoiceHelpers;
use App\Invoice\Traits\SavesFiles;
use App\Invoice\Traits\SerialNumberFormatter;
use App\Models\Registration;
use App\Models\Walker;
use Barryvdh\DomPDF\Facade\Pdf as PdfFacade;
use Barryvdh\DomPDF\Pdf;
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
    use DateFormatter;
    use SavesFiles;
    use SerialNumberFormatter;

    public int $table_columns = 4;

    public string $name;

    public string $logo;

    public Seller $seller;

    public Buyer $buyer;

    public Registration $registration;

    /**
     * @var Collection<int,Walker>
     */
    public Collection $items;

    public string $template;

    public string $filename;

    public float $total_amount;

    public string $status;

    public Pdf $pdf;

    public string $output;

    public array $paperOptions;

    public array $options;

    public ?string $notes = null;

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
        $this->name = $name ?: __('invoices::invoice.invoice');
        $this->items = Collection::make([]);
        $this->template = 'default';

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
        $this->options = array_merge(
            app('dompdf.options'),
            config('invoices.dompdf_options') ?? ['enable_php' => true],
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

    /**
     * @return $this
     * @throws Exception
     */
    public function render(): static
    {
        $this->beforeRender();

        $template = sprintf('invoices::templates.%s', $this->template);
        $view = View::make('filament.pdf.invoice', ['invoice' => $this]);
        $html = mb_convert_encoding($view, 'HTML-ENTITIES', 'UTF-8');
        try {
            $this->pdf = PdfFacade::setOptions($this->options)
                ->setPaper($this->paperOptions['size'], $this->paperOptions['orientation'])
                ->loadHtml($view->render());
        }
        catch (Exception $exception) {
            dd($exception->getMessage());
        }

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
     */
    public function stream(): Response
    {
        $this->render();

        return new Response($this->output, Response::HTTP_OK, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$this->filename.'"',
        ]);
    }

    /**
     * @throws Exception
     */
    public function download(): Response
    {
        $this->render();

        return new Response($this->output, Response::HTTP_OK, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$this->filename.'"',
            'Content-Length' => strlen($this->output),
        ]);
    }
}
