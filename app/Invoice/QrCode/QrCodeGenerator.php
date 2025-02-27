<?php

namespace App\Invoice\QrCode;

use App\Invoice\Traits\SavesFiles;
use App\Models\Registration;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Contracts\Container\BindingResolutionException;

class QrCodeGenerator
{
    use SavesFiles;

    public string $id;

    public string $name;

    public string $bank_account;

    public string $communication;

    public float $amount;

    public function __construct(string $name = '')
    {
        $this->name = config('app.name');
        $this->bank_account = config('invoices.seller.bank_account');
    }

    /**
     * @throws BindingResolutionException
     * @throws \Exception
     */
    public static function generateAndSaveIt(Registration $registration): void
    {
        $qrCode = QrCodeGenerator::make('Invoice-'.$registration->id)
            ->id($registration->id)
            ->amount($registration->totalAmount())
            ->communication($registration->communication());
        $qrCode->generate();
    }

    public function amount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function id(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function communication(string $communication): static
    {
        $this->communication = $communication;

        return $this;
    }

    /**
     * Service Tag:    BCD
     * Version:    002
     * Character set:    1
     * Identification:    SCT
     * Name:    Red Cross
     * IBAN:    BE72000000001616
     * Amount:    EUR1
     * Reason (4 chars max):    CHAR
     * Ref of invoice:    Empty line or REFINVOICE
     * Or text:    Urgency fund or Empty line
     * Information:    Sample EPC QR code
     * @throws \Exception
     */
    public function generate(): void
    {
        $qr_content = [];
        $qr_content[] = "BCD";
        $qr_content[] = "002";
        $qr_content[] = "1";
        $qr_content[] = "SCT";
        $qr_content[] = "";//BIC
        $qr_content[] = $this->name;
        $qr_content[] = $this->bank_account;
        $qr_content[] = "EUR".$this->amount;
        $qr_content[] = "CHAR";//reason
        $qr_content[] = "";
        $qr_content[] = $this->communication;//BelgianStructuredGenerator::generate();
        $qr_content[] = "100 km EPC QR code";

        $qr_string = implode(PHP_EOL, $qr_content);

        $qrCode = new Builder(
            writer: new PngWriter(),
            writerOptions: [],
            validateResult: false,//todo set true
            data: $qr_string,
            encoding: new Encoding('UTF-8'),
            size: 300,
        );
        $result = $qrCode->build();

        try {
            $file = $this->saveQrCode($result);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

        $mime = \mime_content_type($file);
        if ($mime != 'image/png') {
            throw new \Exception('Not image/png mime:'.$result->getMimeType());
        }
    }

    /**
     * @param string $name
     *
     * @return $this
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     */
    public static function make($name = '')
    {
        return new static($name);
    }

}
