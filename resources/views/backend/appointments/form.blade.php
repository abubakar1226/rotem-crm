@php
    $formId = 'create-record-form';
@endphp

<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Set Appointment</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                &times;
            </button>
        </div>
        <div class="modal-body">
            <form id="{{ $formId }}" method="POST" action="{{ route('leads.appointments.store', $lead->id) }}">
                @csrf
                <div class="row">
                    <div class="form-group col-6">
                        <label for="date" class="col-form-label">Appointment Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <div class="form-group col-3">
                        <label for="start_time" class="col-form-label">Start Time</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" required>
                    </div>
                    <div class="form-group col-3">
                        <label for="end_time" class="col-form-label">End Time</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="col-form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ $lead->address }}"
                           required>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="city" class="col-form-label">City</label>
                        <input type="text" class="form-control" id="city" name="city" value="{{ $lead->city }}"
                               required>
                    </div>
                    <div class="form-group col-6">
                        <label for="state" class="col-form-label">State</label>
                        <input type="text" class="form-control" id="state" name="state" value="{{ $lead->state }}"
                               required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="post_code" class="col-form-label">Post Code</label>
                        <input type="text" class="form-control" id="post_code" name="post_code"
                               value="{{ $lead->post_code }}" required>
                    </div>
                    <div class="form-group col-6">
                        <label for="technician_id" class="col-form-label">Technician</label>
                        <select class='form-control appointment-technician-select' id='technician_id'
                                name='technician_id' style='width: 100%;'>
                            <option></option>
                            @foreach ($technicians as $technician) {
                            <option value="{{ $technician->id }}">
                                {{ $technician->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="job_description" class="col-form-label">Job Description</label>
                    <textarea class="form-control" id="job_description" name="job_description"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" form="{{ $formId }}">Update</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div>
