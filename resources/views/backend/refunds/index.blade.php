@extends('backend.layouts.app')

@section('title', '| Refunds')

@csrf

@section('breadcrumb')
    <div class="page-header">
        <h1 class="page-title">Leads</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Refunds</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <h3 class="card-title font-weight-bold">Refunds</h3>
            <div>@include('backend.tables.button')</div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered text-nowrap key-buttons border-bottom w-100">
                </table>
            </div>
        </div>
    </div>
@endsection

<div id="status-modal" class="modal fade" tabindex="-1" role="dialog"></div>

@push('scripts')
    <script type='module'>
        @php $identifier = '---add-id-here---'; @endphp
        const identifier = '{{ $identifier }}';
        const appointmentsUrl = '{{ route('leads.appointments.create', $identifier) }}';

        const leadStatusUrl = '{{ route('leads.lead-status.create', $identifier) }}';

        const appointmentStatusLabel = '{{ \App\Enums\StatusEnum::appointmentSet()->label }}';
        const noResponseStatusLabel = '{{ \App\Enums\StatusEnum::noResponse()->label }}';

        const refundIndexUrl = '{{ route('refunds.index', $identifier) }}';
        const updateRefundStatusUrl = '{{ route('refunds.update', $identifier) }}';
        const refundStatusLabel = '{{ \App\Enums\RefundStatusEnum::Refunded()->label }}';

        $(document).ready(function () {
            (new RefundsDatatableController(
                refundIndexUrl, @json($configs), leadStatusUrl, appointmentsUrl, appointmentStatusLabel,
                noResponseStatusLabel, updateRefundStatusUrl, refundStatusLabel, identifier
            )).bindEvents();
        });
    </script>
@endpush
