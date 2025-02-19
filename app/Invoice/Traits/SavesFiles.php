<?php

namespace App\Invoice\Traits;

use Illuminate\Support\Facades\Storage;

/**
 * Trait SavesFiles
 */
trait SavesFiles
{
    /**
     * @var string
     */
    public $disk;

    /**
     * @param string $disk
     * @return $this
     * @throws \Exception
     */
    public function save(string $disk = 'local'): static
    {
        if ($disk !== '') {
            $this->disk = $disk;
        }

        $this->render();

        Storage::disk($this->disk)->put($this->filename, $this->output);

        return $this;
    }

    /**
     * @return mixed
     */
    public function url(): mixed
    {
        return Storage::disk($this->disk)->url($this->filename);
    }
}
