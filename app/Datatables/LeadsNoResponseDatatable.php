<?php

namespace App\Datatables;

use App\Enums\StatusEnum;
use Illuminate\Http\Request;

class LeadsNoResponseDatatable extends LeadDatatable
{
    protected static string $tableName = 'leads_no_response';
}
