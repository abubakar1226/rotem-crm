<?php

namespace App\Datatables;

use Illuminate\Http\Request;

class TechnicianDatatable extends Datatable
{
    protected static string $tableName = 'technicians';

    public function __construct(Request $request)
    {
        parent::__construct($request, 'App\Models\Technician');
    }
}
