@php
    $formId = 'create-record-form';
@endphp

<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Update Lead Status ({{ $leadStatus }})</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                &times;
            </button>
        </div>
        <div class="modal-body">
            <form id="{{ $formId }}" method="POST" action="{{ route('leads.lead-status.store', $lead->id) }}">
                @csrf
                <input type="hidden" name="lead_status" value="{{ $leadStatus }}" />

                <div class="screen" data-screen="main">
                    <div class="form-group" id="reason-div">
                        <label for="employee_id" class="col-form-label">Employee Name</label>
                        <input type="text" class="form-control" id="employee_id" name="employee_id" />
                    </div>

                    <div class="form-group" id="reason-div">
                        <label for="description" class="col-form-label">Please Fill in the Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                </div>

                <div class="screen" data-screen="message" style="display: none;">
                    <div class="form-group" id="message-div">
                        <label for="message" class="col-form-label">Send Message</label>
                        <textarea class="form-control" id="message" name="message"></textarea>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info text-right" id="screen-toggle-button" data-screen="main">
                Next
            </button>
            <button type="submit" class="btn btn-primary" form="{{ $formId }}">Update</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div>


