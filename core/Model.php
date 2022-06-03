<?php

namespace Leader\Core;

use Leader\Interfaces\ModelInterface;

abstract class Model implements ModelInterface
{
    public function toAssocArray(): array
    {
        return get_object_vars($this);
    }
}