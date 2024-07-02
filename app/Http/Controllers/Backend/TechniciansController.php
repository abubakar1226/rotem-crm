<?php

namespace App\Http\Controllers\Backend;

use App\DatatablePresenters\TechnicianDatatablePresenter;
use App\Datatables\TechnicianDatatable;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\TechnicianFormrequest;
use App\Models\Technician;
use Illuminate\Http\Request;
use App\Helpers\PhoneNumberHelper;

class TechniciansController extends Controller
{
    public function index(Request $request)
    {
        $status = present($request->status) ? StatusEnum::from($request->status) : null;

        if ($request->isXmlHttpRequest()) {
            return response()->json((new TechnicianDatatable($request))->data(new TechnicianDatatablePresenter()));
        }

        return view('backend.technicians.index', [
            'status' => $status,
        ]);
    }

    public function create()
    {
        return view('backend.technicians.create');
    }

    public function store(TechnicianFormrequest $request)
    {
        $data = $request->validated();
        $data['phone_number'] = PhoneNumberHelper::formatPhoneNumber($data['phone_number']);
        Technician::create($data);

        return redirect()->to(route('technicians.index'));
    }

    public function edit(Technician $technician)
    {
        return view('backend.technicians.edit', [
            'technician' => $technician,
        ]);
    }

    public function update(Technician $technician, TechnicianFormrequest $request)
    {
        $data = $request->validated();
        $data['phone_number'] = PhoneNumberHelper::formatPhoneNumber($data['phone_number']);
        $technician->update($data);

        return redirect()->to(route('technicians.index'));
    }

    public function destroy(Technician $technician)
    {
        $technician->delete();

        return redirect()->to(route('technicians.index'));
    }
}
