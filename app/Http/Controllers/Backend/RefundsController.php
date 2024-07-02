<?php

namespace App\Http\Controllers\Backend;

use App\DatatablePresenters\RefundDatatablePresenter;
use App\Datatables\SubReportsDatatable;
use App\Datatables\RefundDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\RefundFormRequest;
use App\Models\Refund;
use App\Models\Table;
use Illuminate\Http\Request;

class RefundsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isXmlHttpRequest())
            return response()->json((new RefundDatatable($request))->data(new RefundDatatablePresenter()));

        return view('backend.refunds.index', [
            'configs' => RefundDatatable::configs(),
            'table' => Table::firstWhere('table_name', RefundDatatable::tableName()),
        ]);
    }

    public function update(Refund $refund, RefundFormRequest $request)
    {
        $attributes = $request->validated();
        $refund->update($attributes);

        return response()->json(['status' => 'success', 'message' => 'Refund status updated successfully']);
    }
}
