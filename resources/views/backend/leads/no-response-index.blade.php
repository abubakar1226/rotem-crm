@extends('backend.layouts.app')

@section('title', '| Leads (No Response)')

@section('breadcrumb')
    <div class="page-header">
        <h1 class="page-title">Leads (No Response)</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Leads</li>
                <li class="breadcrumb-item active" aria-current="page">Leads (No Response)</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <h3 class="card-title font-weight-bold">Leads (No Response)</h3>
            <div>
                @include('backend.tables.button')
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered text-nowrap key-buttons border-bottom w-100"></table>
            </div>
        </div>
    </div>
@endsection

<div id="lead-status-modal" class="modal fade" tabindex="-1" role="dialog"></div>

@push('scripts')
    <script type='module'>
        @php $identifier = '---add-lead-id-here---'; @endphp
        const identifier = '{{ $identifier }}';
        const appointmentsUrl = '{{ route('leads.appointments.create', $identifier) }}';
        const leadStatusUrl = '{{ route('leads.lead-status.create', $identifier) }}';
        const leadsNoResponseIndexUrl = '{{ route('leads.no-response.index') }}';
        const appointmentStatusLabel = '{{ \App\Enums\StatusEnum::appointmentSet()->label }}';
        const noResponseStatusLabel = '{{ \App\Enums\StatusEnum::noResponse()->label }}';

        $(document).ready(function () {
            (new LeadsDatatableController(
                leadsNoResponseIndexUrl, @json($configs), leadStatusUrl, appointmentsUrl, appointmentStatusLabel,
                identifier, noResponseStatusLabel
            )).bindEvents();
        });
    </script>
@endpush
