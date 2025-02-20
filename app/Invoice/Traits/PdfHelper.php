<?php

namespace App\Invoice\Traits;

use Barryvdh\DomPDF\Facade\Pdf as PdfFacade;
use Barryvdh\DomPDF\PDF;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\HeaderUtils;

trait PdfHelper {

    public Pdf $pdf;

    public string $output;

    public string $filename;

    public string $template;

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
}
