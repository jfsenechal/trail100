<?php

namespace App\Invoice\Traits;

use App\Invoice\Buyer;
use App\Invoice\Invoice;
use App\Invoice\Seller;
use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf as PdfFacade;
use Barryvdh\DomPDF\PDF;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Illuminate\Support\Facades\Response as FacadeResponse;

trait PdfHelper
{
    public Pdf $pdf;

    public string $output;

    public string $filename;

    public string $template;

    public static function generatePdfAndSaveIt(Registration $record): void
    {
        Invoice::make('Invoice-'.$record->id)
            ->name(Str::slug($record->email.''.$record->id))
            ->seller(new Seller())
            ->buyer(
                new Buyer([
                    'name' => fake()->firstName(),
                    'address' => fake()->streetAddress(),
                    'phone' => fake()->phoneNumber(),
                ]),
            )
            ->registration($record)
            ->totalAmount($record->totalAmount())
            ->status('not paid')
            ->date($record->created_at)
            ->logo(self::logoToBase64())
            ->save('invoices');
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
     * @return $this
     * @throws Exception
     */
    public function render(): static
    {
        $this->beforeRender();

        $template = sprintf('invoices::pdf.%s', $this->template);
        $view = View::make($template, ['invoice' => $this]);
        //$html = mb_convert_encoding($view->render(), 'HTML-ENTITIES', 'UTF-8');
        $html = $view->render();

        try {
            $this->options['isPhpEnabled'] = true;
            $this->options['isRemoteEnabled'] = true;
            $this->pdf = PdfFacade::setOptions($this->options, true)
                ->setPaper($this->paperOptions['size'], $this->paperOptions['orientation'])
                ->loadHtml($html, 'UTF-8');
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }

        $this->output = $this->pdf->output();

        return $this;
    }

    public function toHtml()
    {
        $template = sprintf('invoices::pdf.%s', $this->template);

        return View::make($template, ['invoice' => $this]);
    }

    public static function downloadPdf(): BinaryFileResponse
    {
        $filePath = storage_path(self::downloadUrl());

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return FacadeResponse::download($filePath, 'downloaded-file.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function download(): Response
    {
        $filename = $this->filename;
        $fallback = $this->fallbackName($filename);
        $this->pdf = $this->loadView();
        $this->output = $this->pdf->output();

        return \Illuminate\Support\Facades\Response::make($this->pdf->stream($filename), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => HeaderUtils::makeDisposition('attachment', $filename, $fallback),
            'Content-Length' => strlen($this->output),
        ]);
    }

    /**
     * Make a safe fallback filename
     */
    protected function fallbackName(string $filename): string
    {
        return str_replace('%', '', Str::ascii($filename));
    }

    public function loadView(): PDF
    {
        $this->beforeRender();
        $template = sprintf('invoices::pdf.%s', $this->template);

        return PdfFacade::setOptions($this->options, true)
            ->setPaper($this->paperOptions['size'], $this->paperOptions['orientation'])
            ->loadView($template, ['invoice' => $this]);
    }

    /**
     * @throws Exception
     */
    public function downloadBroke(): Response
    {
        $this->render();

        return new Response($this->output, Response::HTTP_OK, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$this->filename.'"',
            'Content-Length' => strlen($this->output),
        ]);
    }

    public static function logoToBase64(): ?string
    {
        $path = public_path('images/logoMarcheur.jpg');
        if (file_exists($path)) {
            $imageData = base64_encode(file_get_contents($path));
            $mimeType = mime_content_type($path);
            $base64Image = "data:$mimeType;base64,$imageData";

            return $base64Image;
        } else {
            return null;
        }
    }
}
