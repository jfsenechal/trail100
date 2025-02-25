<?php

namespace App\Invoice\Traits;

use Endroid\QrCode\Writer\Result\ResultInterface;
use Illuminate\Support\Facades\Storage;

trait SavesFiles
{
    public string $disk = 'invoices';

    public function qrCodeFileName(): string
    {
        return 'qrcode-'.$this->id.'.png';
    }

    public function qrCodePathDiskTo(): string
    {
        return Storage::disk($this->disk)->path('');
    }

    public function qrCodePath(): ?string
    {
        $path = $this->qrCodePathDiskTo().$this->qrCodeFileName();

        if (!file_exists($path)) {
            return null;
        }

        return $path;
    }

    public function saveQrCode(ResultInterface $result): string
    {
        $filePath = $this->qrCodePathDiskTo().$this->qrCodeFileName();
        $result->saveToFile($filePath);

        return $filePath;
    }

    public function invoiceFileName(): string
    {
        return 'invoice-'.$this->id.'.pdf';
    }

    public function invoicePathDisk(): string
    {
        return Storage::disk($this->disk)->path('');
    }

    public function invoicePath(): ?string
    {
        $path = $this->invoicePathDisk().$this->invoiceFileName();

        if (!file_exists($path)) {
            return null;
        }

        return $path;
    }

    /**
     * @param string $disk
     * @return $this
     * @throws \Exception
     */
    public function saveInvoice(): static
    {
        Storage::disk($this->disk)->put($this->invoiceFileName(), $this->output);

        return $this;
    }

}
