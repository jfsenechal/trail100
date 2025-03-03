<?php

namespace App\Invoice\Traits;

use App\Invoice\Buyer;
use App\Invoice\Invoice;
use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf as PdfFacade;
use Barryvdh\DomPDF\PDF;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as FacadeResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\HeaderUtils;

trait PdfHelper
{
    public Pdf $pdf;

    public string $output;

    public string $filename;

    public string $template;

    /**
     * @throws BindingResolutionException
     * @throws Exception
     */
    public static function generatePdfAndSaveIt(Registration $record): void
    {
        Invoice::make('Invoice-'.$record->id)
            ->registration($record)
            ->buyer(Buyer::newFromRegistration($record))
            ->logo(self::logoToBase64())
            ->render()
            ->saveInvoice();
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function render(): static
    {
        $this->beforeRender();

        $html = $this->generateHtml();

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

    public function generateHtml(): string
    {
        $template = sprintf('invoices::pdf.%s', $this->template);

        $qrCodeFile = $this
            ->qrCodePath();

        $fileScanning = public_path('images/qr-code-scanning2.jpg');
        $qrCodeScanning = self::convertToBase64($fileScanning);

        if ($qrCodeFile) {
            $qrCodeFile = self::convertToBase64($qrCodeFile);
        }

        $view = View::make(
            $template,
            ['invoice' => $this, 'qrCode' => $qrCodeFile, 'qrCodeScanning' => $qrCodeScanning],
        );

        //$html = mb_convert_encoding($view->render(), 'HTML-ENTITIES', 'UTF-8');

        return $view->render();
    }

    public static function downloadPdfFromPath(string $filePath): BinaryFileResponse
    {
        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        //$fallback = $this->fallbackName($filePath);

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

        return FacadeResponse::make($this->pdf->stream($filename), 200, [
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
    public function stream(): Response
    {
        $this->render();

        return new Response($this->output, Response::HTTP_OK, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$this->filename.'"',
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

    public static function convertToBase64(string $filePath): ?string
    {
        $imageData = base64_encode(file_get_contents($filePath));
        $mimeType = mime_content_type($filePath);
        $base64Image = "data:$mimeType;base64,$imageData";

        return $base64Image;
    }
}
