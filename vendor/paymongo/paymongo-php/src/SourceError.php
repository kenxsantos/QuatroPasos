<?php

namespace Paymongo;

class SourceError extends \Exception // Extend the Exception class
{
    public $pointer;
    public $attribute;

    public function __construct($source)
    {
        $this->pointer = $source['pointer'] ?? null; // Use null coalescing to avoid undefined index
        $this->attribute = $source['attribute'] ?? null; // Use null coalescing to avoid undefined index

        // Call the parent constructor to set the message or code if necessary
        parent::__construct("Error occurred: " . $this->attribute . " at " . $this->pointer);
    }
}