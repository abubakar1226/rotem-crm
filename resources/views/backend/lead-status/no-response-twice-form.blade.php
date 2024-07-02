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
            <form id="{{ $formId }}" method="POST" action="{{ route('leads.no-response', $lead->id) }}">
                @csrf
                <input type="hidden" name="lead_status" value="{{ $leadStatus }}" />

                <div class="form-group" id="message-div">
                    <label for="message" class="col-form-label">Send Message</label>
                    <textarea class="form-control" id="message" name="message" rows="8">{!! $message !!}</textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" form="{{ $formId }}">Send</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div>


