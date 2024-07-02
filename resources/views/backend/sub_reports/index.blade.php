@extends('backend.layouts.app')

@section('title', '| Appointments Sub Reports')

@section('breadcrumb')
<div class="page-header">
    <h1 class="page-title">Manage</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Appointment Sub Reports</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header justify-content-between">
        <h3 class="card-title font-weight-bold">Appointment Sub Reports</h3>
        <div>@include('backend.tables.button')</div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="datatable" class="table table-bordered text-nowrap key-buttons border-bottom w-100"></table>
        </div>
    </div>
</div>
@endsection

<div class="modal fade" id="appointments-modal" tabindex="-1" role="dialog" aria-labelledby="modal"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="appointments-modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="appointments-modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="lead-modal-ok-button" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
</div>
@csrf
@push('scripts')
<script>
    @php $identifier = '---add-appointment-report-id-here---' @endphp
    const identifier = '{{ $identifier }}';
    const subReportsIndexUrl = '{{ route('sub_reports.index') }}';
    const subReportUpdateUrl = '{{ route('sub_reports.update', $identifier) }}';


    $(function () {
        $(document).ready(function () {
            (new SubReportsDatatableController(
                subReportsIndexUrl, @json($configs), subReportUpdateUrl, identifier
            )).bindEvents();
        });
    });
</script>
@endpush
