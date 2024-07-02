<?php

namespace App\Http\Controllers\Backend;

use App\DatatablePresenters\AppointmentDatatablePresenter;
use App\Datatables\AppointmentDatatable;
use App\Datatables\SubReportsDatatable;
use App\Datatables\LeadsNoResponseDatatable;
use App\DatatableSchemas\AppointmentsSchema;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentFormRequest;
use App\Http\Requests\SubReportFormRequest;
use App\Models\Appointment;
use App\Models\Lead;
use App\Models\Table;
use App\Models\Technician;
use Illuminate\Http\Request;

class AppointmentsController extends Controller
{
    public function index(?Technician $technician, Request $request)
    {
        $status = StatusEnum::appointmentSet();

        if ($request->isXmlHttpRequest()) {
            return response()->json(
                (new AppointmentDatatable($request, $status, $technician))->data(new AppointmentDatatablePresenter())
            );
        }

        return view('backend.appointments.index', [
            'status' => $status,
            'technician' => $technician,
            'configs' => AppointmentDatatable::configs(),
            'table' => Table::firstWhere('table_name', AppointmentDatatable::tableName()),
        ]);
    }

    public function create(Lead $lead)
    {
        return view('backend.appointments.form', [
            'lead' => $lead,
            'technicians' => Technician::all()
        ]);
    }

    public function store(Lead $lead, AppointmentFormRequest $request)
    {
        $attributes = $request->validated();

        $appointment = $lead->appointments()->create($attributes);
        $lead->update(['status' => StatusEnum::appointmentSet()]);

        $controller = app('App\Http\Controllers\Backend\SubReportsController');
        $controller->saveSubReport($appointment, app('App\Http\Requests\SubReportFormRequest'));

        return response()->json(['status' => 'success', 'message' => 'Appointment set successfully']);
    }

    public function updateTechnician(Appointment $appointment, AppointmentFormRequest $request)
    {
        $status = $appointment->update($request->validated()) ? 'success' : 'danger';
        $message = $status === 'success' ? 'Technician update successfully' : 'Unable to update technician';

        return response()->json(['id' => $request->technician_id, 'status' => $status, 'message' => $message]);
    }
}
