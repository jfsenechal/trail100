<?php

namespace App\Invoice\QrCode;

use App\Models\Registration;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;

class QrCodeGenerator
{
    public static function make($name = '')
    {
        return new static($name);
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
    public function generate(Registration $registration): string
    {
        $qr_content = [];
        $qr_content[] = "BCD";
        $qr_content[] = "002";
        $qr_content[] = "1";
        $qr_content[] = "SCT";
        $qr_content[] = "";//BIC
        $qr_content[] = config('APP_NAME');
        $qr_content[] = config('TRAIL_BANK_ACCOUNT');
        $qr_content[] = "EUR".$registration->totalAmount();
        $qr_content[] = "CHAR";//reason
        $qr_content[] = "";
        $qr_content[] = "100km ".$registration->id;//BelgianStructuredGenerator::generate();
        $qr_content[] = "Sample EPC QR code";

        $qr_string = implode(PHP_EOL, $qr_content);

        $qrCode = new Builder(
            writer: new PngWriter(),
            writerOptions: [],
            validateResult: true,
            data: $qr_string,
            encoding: new Encoding('UTF-8'),
            size: 300,
        );
        $result = $qrCode->build();

        $fileName = $registration->getUuid().'.png';
        $directory = $this->project_dir.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'qrcode'.DIRECTORY_SEPARATOR;
        $publicPath = DIRECTORY_SEPARATOR.'qrcode'.DIRECTORY_SEPARATOR.$fileName;

        try {
            $result->saveToFile($directory.$fileName);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

        $mime = \mime_content_type($directory.$fileName);
        if ($mime != 'image/png') {
            throw new \Exception('Not image/png mime:'.$result->getMimeType());
        }

        return $publicPath;
    }
}
