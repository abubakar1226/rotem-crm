<?php

namespace App\DatatableSchemas;

interface DatatableSchema
{
    public static function table(): array;
    public static function columns(): array;
}
