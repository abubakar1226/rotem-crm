@extends('backend.layouts.app')

@section('title', '| Appointments')

@section('breadcrumb')
    <div class="page-header">
        <h1 class="page-title">
            {{ present($technician->id) ? "{$technician->name}'s Appointments" : 'All Appointments'  }}
        </h1>

        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Appointments</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <h3 class="card-title font-weight-bold">
                {{ present($technician->id) ? "{$technician->name}'s Appointments" : 'All Appointments'  }}
            </h3>
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
        @php $identifier = '---add-appointment-id-here---' @endphp
        const technicianUpdateUrl = '{{ route('appointments.technician-update', $identifier) }}';
        const identifier = '{{ $identifier }}';
        const appointmentIndexUrl = '{{ route('appointments.index', $technician) }}';


        $(function () {
            $(document).ready(function () {
                (new AppointmentsDatatableController(
                    appointmentIndexUrl, @json($configs), technicianUpdateUrl, identifier
                )).bindEvents();
            });
        });
    </script>
@endpush
