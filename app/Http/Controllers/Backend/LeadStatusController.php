<?php

namespace App\Http\Controllers\Backend;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\RefundFormRequest;
use App\Http\Requests\NoResponseFormRequest;
use App\Models\Lead;
use App\Models\MessageTemplate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LeadStatusController extends Controller
{
    public function create(Lead $lead, Request $request)
    {
        if (!present($request->lead_status))
            return response()->json(['status' => 'danger', 'message' => 'Lead status is required']);

        if ($lead->status?->label === $request->lead_status)
            return response()->json([], 422);

        return $this->viewResponse($lead, StatusEnum::from($request->lead_status));
    }

    public function store(Lead $lead, RefundFormRequest $request)
    {
        $attributes = $request->validated();

        $lead->refund()->updateOrCreate(['lead_id' => $lead->id], $attributes);
        $leadUpdateColumns = ['status' => $attributes['lead_status']];
        if ($attributes['lead_status'] === StatusEnum::noResponse()) {
            $leadUpdateColumns['follow_up_at'] = Carbon::now()->addHours(12);
        }
        $lead->update($leadUpdateColumns);

        return $this->storeResponse($lead);
    }

    public function noResponse(Lead $lead, NoResponseFormRequest $request)
    {
        $attributes = $request->validated();

        $lead->refund()->updateOrCreate(['lead_id' => $lead->id], $attributes);
        $leadUpdateColumns = ['status' => $attributes['lead_status']];
        if (StatusEnum::from($attributes['lead_status']) === StatusEnum::noResponse()) {
            $leadUpdateColumns['follow_up_at'] = Carbon::now()->addHours(12);
        }
        $lead->update($leadUpdateColumns);

        return $this->storeResponse($lead);
    }

    public function noResponseTwice(Lead $lead, NoResponseFormRequest $request)
    {
        $attributes = $request->validated();

        $lead->refund()->updateOrCreate(['lead_id' => $lead->id], $attributes);
        $leadUpdateColumns = ['status' => $attributes['lead_status']];
        if (StatusEnum::from($attributes['lead_status']) === StatusEnum::noResponseTwice()) {
            $leadUpdateColumns['follow_up_at'] = Carbon::now()->addHours(12);
        }
        $lead->update($leadUpdateColumns);

        return $this->storeResponse($lead);
    }

    private function viewResponse(Lead $lead, StatusEnum $leadStatus)
    {
        return match ($leadStatus) {
            StatusEnum::noResponse() => view('backend.lead-status.no-response-form', [
                'lead' => $lead,
                'leadStatus' => $leadStatus,
                'message' => preg_replace('/\\\n/', '&#13;&#10;', preg_replace(
                    '/{{Customer Name}}/', $lead->name, MessageTemplate::select('*')->first()->message
                ))
            ]),
            StatusEnum::noResponseTwice() => view('backend.lead-status.no-response-twice-form', [
                'lead' => $lead,
                'leadStatus' => $leadStatus,
                'message' => preg_replace('/\\\n/', '&#13;&#10;', preg_replace(
                    '/{{Customer Name}}/', $lead->name, MessageTemplate::select('*')->first()->message
                ))
            ]),
            default => view('backend.lead-status.default-form', [
                'lead' => $lead,
                'leadStatus' => $leadStatus,
            ])
        };
    }

    private function storeResponse(Lead $lead)
    {
        $message = present($lead->phone_number) ? "Message  sent to client and lead status updated successfully"
            : (present($lead->email) ? "Email sent to client and lead status updated successfully"
            : 'Status updated successfully');

        return response()->json(['status' => 'success', 'message' => $message]);
    }
}
