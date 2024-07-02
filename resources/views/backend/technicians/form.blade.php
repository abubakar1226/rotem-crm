@php
    $technician = $technician ?? null;
    $url = $technician?->id ? route('technicians.update', $technician->id) : route('technicians.store');
    $technicianPermissions = $technician?->id ? $technician->permissions?->pluck('id')->toArray() : [];
    $platforms = \App\Enums\PlatformEnum::toArray();
@endphp

<form action="{{ $url }}" method="post">
    @csrf
    @if ($technician?->id)
        @method('PUT')
    @endif

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="name">Full Name</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name"
                           value="{{ $technician?->name ?? old('name') }}" required>
                </div>
                @error('name') <small class="text-danger">{{ $message }}</small>  @enderror
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="email" name="email"
                           placeholder="Enter Email" value="{{ $technician?->email ?? old('email') }}">
                </div>
                @error('email') <small class="text-danger">{{ $message }}</small>  @enderror
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
            <label class="form-label" for="phone_number">Phone Number</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="phone_number" name="phone_number"
                           placeholder="Enter Phone Number"
                        value="{{ $technician?->phone_number ?? old('phone_number') }}" required>
                </div>
                @error('phone_number') <smal class="text-danger">{{ $message }}</smal>  @enderror
            </div>
        </div>
    </div>

    <div class="col-lg-12 p-0 mt-4">
        <div class="form-group">
            <button type="submit" class="btn btn-md btn-primary" data-button="submit">Save</button>
        </div>
    </div>
</form>

<script>
function formatPhoneNumber(input) {
    let value = input.value.replace(/\D/g, '');
    if (value.length > 10) value = value.slice(0, 10);
    input.value = value.length ? `+1 ${value.slice(0, 3)}-${value.slice(3, 6)}-${value.slice(6, 10)}` : '';
}
</script>
