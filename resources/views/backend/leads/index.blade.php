@extends('backend.layouts.app')

@section('title', '| Leads')

@section('breadcrumb')
    <div class="page-header">
        <h1 class="page-title">Leads</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Leads</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <h3 class="card-title font-weight-bold">Leads</h3>
            <div>
                @include('backend.tables.button')
                <a href="{{ route('leads.create') }}" class="btn dark-icon btn-primary" data-method="get"
                   data-title="Add Lead">
                    <i class="ri-add-fill"></i> Add Lead
                </a>
            </div>
        </div>

        <div class="card-body">
            <table id="datatable" class="table table-bordered text-nowrap key-buttons border-bottom w-100"></table>
        </div>
    </div>

    <div id="status-modal" class="modal fade" tabindex="-1" role="dialog"></div>
@endsection

@push('scripts')
    <script type='module'>
        @php $identifier = '---add-lead-id-here---'; @endphp
        const identifier = '{{ $identifier }}';
        const appointmentsUrl = '{{ route('leads.appointments.create', $identifier) }}';
        const leadStatusUrl = '{{ route('leads.lead-status.create', $identifier) }}';
        const leadsIndexUrl = '{{ route('leads.index', ['status' => $status?->label]) }}';
        const appointmentStatusLabel = '{{ \App\Enums\StatusEnum::appointmentSet()->label }}';
        const noResponseStatusLabel = '{{ \App\Enums\StatusEnum::noResponse()->label }}';

        $(document).ready(function () {
            (new LeadsDatatableController(
                leadsIndexUrl, @json($configs), leadStatusUrl, appointmentsUrl, appointmentStatusLabel, identifier,
                noResponseStatusLabel
            )).bindEvents();
        });
    </script>
@endpush
