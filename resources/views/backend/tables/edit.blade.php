@php
    $formId = 'update-table-configs';
@endphp

<div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Manage {{ $table->display_name }} Table</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                &times;
            </button>
        </div>
        <div class="modal-body">
            @include('backend.tables.form')
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" form="{{ $formId }}">Update</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div>
