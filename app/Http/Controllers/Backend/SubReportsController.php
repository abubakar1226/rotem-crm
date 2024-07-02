<?php

namespace App\Http\Controllers\Backend;

use App\DatatablePresenters\SubReportDatatablePresenter;
use App\Datatables\SubReportsDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubReportFormRequest;
use App\Models\Appointment;
use App\Models\SubReport;
use App\Models\Table;
use Illuminate\Http\Request;

class SubReportsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            return response()->json(
                (new SubReportsDatatable($request, 'App\Models\SubReport'))
                    ->data(new SubReportDatatablePresenter())
            );
        }

        return view('backend.sub_reports.index', [
            'configs' => SubReportsDatatable::configs(),
            'table' => Table::firstWhere('table_name', SubReportsDatatable::tableName()),
        ]);
    }

    public function store(Appointment $appointment, SubReportFormRequest $request)
    {
        $this->saveSubReport($appointment, $request);

        return response()->json(['status' => 'success', 'message' => 'Appointment set successfully']);
    }

    public function saveSubReport(Appointment $appointment, SubReportFormRequest $request)
    {
        $attributes = $request->validated();
        $attributes['technician_share_percentage'] = $attributes['company_share_percentage'] = 50.00;

        return $appointment->sub_report()->create($attributes);
    }

    public function update(SubReport $subReport, SubReportFormRequest $request)
    {
        $attributes = $request->validated();
        $subReport->update($attributes);

        return response()->json(['status' => 'success', 'message' => 'Sub report updated successfully']);
    }
}
