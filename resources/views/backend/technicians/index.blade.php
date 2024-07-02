@extends('backend.layouts.app')

@section('title', '| Roles')

@section('breadcrumb')
    <div class="page-header">
        <h1 class="page-title">Technicians</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Technicians</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <h3 class="card-title font-weight-bold">Technicians</h3>
            <a href="{{ route('technicians.create') }}" class="btn dark-icon btn-primary" data-method="get"
               data-title="Add New User">
                <i class="ri-add-fill"></i> Add Technician
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-nowrap key-buttons border-bottom w-100"
                       id="technicians_datatable">
                    <thead>
                        <tr>
                            <th class="border-bottom-0 text-center" style="width: 5%;">ID</th>
                            <th class="border-bottom-0" style="width: 17.5%">Name</th>
                            <th class="border-bottom-0" style="width: 12.5%">Phone Number</th>
                            <th class="border-bottom-0" style="width: 30%">Email</th>
                            <th class="border-bottom-0" style="width: 12.5%">Created At</th>
                            <th class="border-bottom-0" style="width: 12.5%">Updated At</th>
                            <th class="border-bottom-0 text-center" style="width: 10%">Actions</th>
                        </tr>
                    </thead>

                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            const TechniciansTable = $('#technicians_datatable').DataTable({
                ajax: '{{ route('technicians.index', ['status' => $status?->label]) }}',
                processing: true,
                serverSide: true,
                autoWidth: false,
                fixedColumns: {
                    start: 1,
                    rightColumns: 1
                },
                columnDefs: [
                    {
                        targets: [0, -1],
                        className: 'text-center'
                    }
                ],
                columns: [
                    {
                        searchable: false,
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'phone_number',
                        name: 'phone_number'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        searchable: false
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                        searchable: false
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ],
            });
        });
    </script>
@endpush
