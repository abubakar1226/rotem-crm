<?php

namespace App\DatatablePresenters;

use App\Datatables\DatatableInterface;

interface DatatablePresenterInterface
{
    public function decorate(DatatableInterface $datatable, array $records): array;
}
