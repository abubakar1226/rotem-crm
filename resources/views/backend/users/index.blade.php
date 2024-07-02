@extends('backend.layouts.app')

@section('title', '| Users')

@section('breadcrumb')
    <div class="page-header">
        <h1 class="page-title">Users List</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Users</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <h3 class="card-title font-weight-bold">Users</h3>
            @can('add_user')
                <button type="button" class="btn dark-icon btn-primary" data-act="ajax-modal" data-method="get"
                    data-action-url="{{ route('users.create') }}" data-title="Add New User">
                    <i class="ri-add-fill"></i> Add User
                </button>
            @endcan
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="users_datatable" class="table table-bordered text-nowrap key-buttons border-bottom w-100">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">#</th>
                            <th class="border-bottom-0">Name</th>
                            <th class="border-bottom-0">Email</th>
                            <th class="border-bottom-0">Phone</th>
                            <th class="border-bottom-0">Status</th>
                            <th class="border-bottom-0">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#users_datatable').DataTable({
                ajax: '{{ route('users-datatable') }}',
                processing: true,
                serverSide: true,
                scrollX: false,
                autoWidth: true,
                columnDefs: [{
                        width: 1,
                        targets: 5
                    },
                    {
                        width: '5%',
                        targets: 0
                    }
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
@endpush