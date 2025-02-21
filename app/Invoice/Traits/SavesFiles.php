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

    public function invoiceFileName(): string
    {
        return 'invoice-'.$this->id.'.pdf';
    }

    public function invoicePathDisk(): string
    {
        return Storage::disk($this->disk)->path('');
    }

    public function qrCodePathDiskTo(): string
    {
        return Storage::disk($this->disk)->path('');
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

    public function saveQrCode(ResultInterface $result): string
    {
        $filePath = $this->qrCodePathDiskTo().DIRECTORY_SEPARATOR.$this->qrCodeFileName();

        $result->saveToFile($filePath);

        return $filePath;
    }
}
