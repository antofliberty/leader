<?php

namespace Leader\Interfaces;

interface ModelInterface
{
    public static function getKeys(): array;
    public function toAssocArray(): array;
}