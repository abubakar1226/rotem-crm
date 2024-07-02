@php
    $isEdit = isset($lead) ? true : false;
    $url = $isEdit ? route('leads.update', $lead->id) : route('leads.store');
    $leadPermissions = $isEdit ? $lead->permissions?->pluck('id')->toArray() : [];
    $platforms = \App\Enums\PlatformEnum::toArray();
@endphp

<form action="{{ $url }}" method="post">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    {{--  Lead Details  --}}
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="name">Full Name</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name"
                           value="{{ $lead?->name ?? old('name') }}" required>
                </div>
                @error('name') <smal class="text-danger">{{ $message }}</smal>  @enderror
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="email" name="email"
                           placeholder="Enter Email" value="{{ $lead?->email ?? old('email') }}">
                </div>
                @error('email') <smal class="text-danger">{{ $message }}</smal>  @enderror
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="phone_number">Phone Number</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="phone_number" name="phone_number"
                           placeholder="Enter Phone Number"
                        value="{{ $lead?->phone_number ?? old('phone_number') }}" required>
                </div>
                @error('phone_number') <smal class="text-danger">{{ $message }}</smal>  @enderror
            </div>
        </div>
    </div>

    {{--  Lead Address  --}}
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="address">Street Address</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="address" name="address"
                           placeholder="Enter Street Address"
                           value="{{ $lead?->address ?? old('address') }}" required>
                </div>
                @error('address') <smal class="text-danger">{{ $message }}</smal>  @enderror
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="city">City</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="city" name="city" placeholder="Enter City"
                           value="{{ $lead?->city ?? old('city') }}" required>
                </div>
                @error('city') <smal class="text-danger">{{ $message }}</smal>  @enderror
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="state">State/Province</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="state" name="state" placeholder="Enter State/Province"
                           value="{{ $lead?->state ?? old('state') }}" required>
                </div>
                @error('state') <smal class="text-danger">{{ $message }}</smal>  @enderror
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="post_code">Post Code</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="post_code" name="post_code"
                           placeholder="Enter Post/Zip Code"
                           value="{{ $lead?->post_code ?? old('post_code') }}" required>
                </div>
                @error('post_code') <smal class="text-danger">{{ $message }}</smal>  @enderror
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="country">Country</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="country" name="country" placeholder="Enter Country"
                           value="{{ $lead?->country ?? old('country') }}" required>
                </div>
                @error('country') <smal class="text-danger">{{ $message }}</smal>  @enderror
            </div>
        </div>
    </div>

    {{--  Lead Status  --}}
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="platform">Platform (Lead Source)</label>
                <div class="form-control-wrap">
                    <select type="text" class="form-control" id="platform" name="platform" placeholder="Enter Country"
                            required>
                        <option value="">Select Platform</option>
                        @foreach ($platforms as $label => $value)
                            <option value="{{ $value }}"
                                    {{ ($lead?->platforms->value ?? old('status')) === $label  ? 'selected': ''}}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label" for="price">Lead Price</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="price" name="price" placeholder="Enter Lead Price"
                           value="{{ $lead?->price ?? old('price') }}" required>
                </div>
                @error('price') <smal class="text-danger">{{ $message }}</smal>  @enderror
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
