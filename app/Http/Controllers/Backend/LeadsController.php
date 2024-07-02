<?php

namespace App\Http\Controllers\Backend;

use App\DatatablePresenters\LeadDatatablePresenter;
use App\DatatablePresenters\LeadsNoResopnseDatatablePresenter;
use App\Datatables\LeadDatatable;
use App\Datatables\LeadsNoResponseDatatable;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\LeadFormRequest;
use App\Models\Lead;
use App\Models\Table;
use Illuminate\Http\Request;

class LeadsController extends Controller
{
    public function index(Request $request)
    {
        $status = present($request->status) ? StatusEnum::from($request->status) : null;

        if ($request->isXmlHttpRequest()) {
            return response()->json((new LeadDatatable($request, $status))->data(new LeadDatatablePresenter()));
        }

        return view('backend.leads.index', [
            'status' => $status,
            'configs' => LeadDatatable::configs(),
            'table' => Table::firstWhere('table_name', LeadDatatable::tableName()),
        ]);
    }

    public function noResponseIndex(Request $request)
    {
        $status = StatusEnum::noResponse();

        if ($request->isXmlHttpRequest()) {
            return response()->json(
                (new LeadsNoResponseDatatable($request, $status))->data(new LeadsNoResopnseDatatablePresenter())
            );
        }

        return view('backend.leads.no-response-index', [
            'status' => $status,
            'configs' => LeadsNoResponseDatatable::configs(),
            'table' => Table::firstWhere('table_name', LeadsNoResponseDatatable::tableName()),
        ]);
    }

    public function noResponseTwiceIndex(Request $request)
    {
        $status = StatusEnum::noResponseTwice();

        if ($request->isXmlHttpRequest()) {
            return response()->json(
                (new LeadsNoResponseDatatable($request, $status))->data(new LeadsNoResopnseDatatablePresenter())
            );
        }

        return view('backend.leads.no-response-twice-index', [
            'status' => $status,
            'configs' => LeadsNoResponseDatatable::configs(),
            'table' => Table::firstWhere('table_name', LeadsNoResponseDatatable::tableName()),
        ]);
    }

    public function create()
    {
        return view('backend.leads.create');
    }

    public function store(LeadFormRequest $request)
    {
        Lead::create($request->validated());

        return redirect()->to(route('leads.index'));
    }

    public function edit(Lead $lead)
    {
        return view('backend.leads.edit', [
            'lead' => $lead,
        ]);
    }

    public function update(Lead $lead, LeadFormRequest $request)
    {
        $lead->update($request->validated());

        return redirect()->to(route('leads.index'));
    }

    public function destroy(Lead $lead, Request $request)
    {
        $lead->delete();

        return redirect()->to(route('leads.index'));
    }
}
