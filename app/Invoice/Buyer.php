<?php

namespace App\Invoice;

class Buyer
{
    public $custom_fields;
    public string $name;
    public string $address;
    public string $phone;

    /**
     * Party constructor.
     * @param $properties
     */
    public function __construct($properties)
    {
        $this->custom_fields = [];

        foreach ($properties as $property => $value) {
            $this->{$property} = $value;
        }
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function __get($key)
    {
        return $this->{$key} ?? null;
    }
}
