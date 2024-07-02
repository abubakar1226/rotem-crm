@php
    $buttonId = 'table-manager-edit-button';
    $modalId = 'table-edit-modal';
    $formId = 'update-table-configs';
@endphp

<style>
    #sortable {
        list-style-type: none;
    }
    #sortable li {
        display:inline-table;
        border-color: var(--primary-bg-color) !important;
        padding: 0.3rem;
    }
    #sortable li span {
        position: absolute;
    }
</style>

<a data-url="{{ route('tables.edit', $table->id) }}" class="btn dark-icon btn-info" id="{{ $buttonId }}">
    Table Manager
</a>

<div id="{{ $modalId }}" class="modal fade" tabindex="-1" role="dialog"></div>

@push('scripts')
    <script src="{{ asset('backend/js/jquery-ui.min.js') }}" defer></script>
    <script type="module">
        $(function () {
        (new TableButtonController('{{ $buttonId }}', '{{ $formId }}', '{{ $modalId }}')).bindEvents();
        });
    </script>
@endpush
