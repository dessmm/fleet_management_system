@extends('app')

@section('content')

<style>
.fm-wrap { background: #f8f9fb; min-height: 100vh; padding: 2rem 1.5rem 3rem; }

.fm-pg-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.75rem; gap: 1rem; flex-wrap: wrap; }
.fm-pg-left { display: flex; align-items: center; gap: 14px; }
.fm-pg-icon { width: 52px; height: 52px; border-radius: 12px; background: #185FA5; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.fm-pg-icon i { color: #fff; font-size: 1.4rem; }
.fm-pg-title { font-size: 20px; font-weight: 600; color: #111827; line-height: 1.2; }
.fm-pg-sub { font-size: 13px; color: #6b7280; margin-top: 2px; }
.fm-btn-back { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border: 1px solid #d1d5db; border-radius: 8px; background: #fff; font-size: 13px; color: #6b7280; text-decoration: none; transition: background .12s; }
.fm-btn-back:hover { background: #f3f4f6; color: #374151; }

.fm-err-box { background: #fee2e2; border: 1px solid #fca5a5; border-radius: 10px; padding: 14px 18px; margin-bottom: 1.25rem; display: flex; align-items: flex-start; gap: 10px; }
.fm-err-box i { color: #dc2626; font-size: 1rem; margin-top: 1px; flex-shrink: 0; }
.fm-err-title { font-size: 13px; font-weight: 600; color: #991b1b; margin-bottom: 4px; }
.fm-err-list { font-size: 12px; color: #dc2626; padding-left: 14px; margin: 0; }
.fm-err-list li { margin-bottom: 2px; }

.fm-layout { display: grid; grid-template-columns: minmax(0, 2fr) minmax(0, 1fr); gap: 1.25rem; align-items: start; }

.fm-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; }
.fm-card-head { padding: 14px 20px; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; gap: 8px; }
.fm-card-head i { color: #6b7280; font-size: 0.9rem; }
.fm-card-head-title { font-size: 13px; font-weight: 500; color: #374151; }
.fm-card-body { padding: 20px; }

.fm-field { margin-bottom: 18px; }
.fm-field:last-child { margin-bottom: 0; }
.fm-field label { display: flex; align-items: center; gap: 5px; font-size: 12px; font-weight: 600; color: #6b7280; margin-bottom: 6px; text-transform: uppercase; letter-spacing: .03em; }
.fm-field label i { font-size: 11px; }
.fm-req { color: #dc2626; margin-left: 2px; }
.fm-field input, .fm-field select {
    width: 100%; padding: 9px 12px; font-size: 14px;
    border: 1px solid #d1d5db; border-radius: 8px;
    background: #fff; color: #111827; outline: none;
    transition: border-color .15s, box-shadow .15s;
}
.fm-field input:focus, .fm-field select:focus {
    border-color: #185FA5;
    box-shadow: 0 0 0 3px rgba(24,95,165,.1);
}
.fm-field input::placeholder { color: #9ca3af; }
.fm-field input.is-invalid, .fm-field select.is-invalid { border-color: #dc2626; }
.fm-field input.is-invalid:focus, .fm-field select.is-invalid:focus { box-shadow: 0 0 0 3px rgba(220,38,38,.1); }
.fm-plate-input { font-family: monospace; letter-spacing: .06em; text-transform: uppercase; }
.fm-hint { font-size: 11px; color: #9ca3af; margin-top: 4px; }
.fm-field-err { font-size: 11px; color: #dc2626; margin-top: 4px; display: flex; align-items: center; gap: 4px; }
.fm-field-err i { font-size: 11px; }
.fm-two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.fm-sel-wrap { position: relative; }
.fm-sel-wrap select { padding-right: 32px; appearance: none; cursor: pointer; }
.fm-sel-wrap i { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 11px; pointer-events: none; }
.fm-divider { border: none; border-top: 1px solid #f3f4f6; margin: 20px 0; }
.fm-form-actions { display: flex; align-items: center; justify-content: flex-end; gap: 8px; }
.fm-btn-cancel { padding: 9px 20px; border: 1px solid #d1d5db; border-radius: 8px; background: transparent; font-size: 13px; color: #6b7280; text-decoration: none; transition: background .12s; }
.fm-btn-cancel:hover { background: #f3f4f6; color: #374151; }
.fm-btn-submit { padding: 9px 22px; background: #185FA5; color: #fff; border: none; border-radius: 8px; font-size: 13px; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: opacity .15s; }
.fm-btn-submit:hover { opacity: .88; }

.fm-side .fm-card { margin-bottom: 1rem; }
.fm-info-row { display: flex; align-items: flex-start; gap: 10px; padding: 10px 0; border-bottom: 1px solid #f3f4f6; }
.fm-info-row:last-child { border-bottom: none; padding-bottom: 0; }
.fm-info-row:first-child { padding-top: 0; }
.fm-info-icon { width: 28px; height: 28px; border-radius: 6px; background: #f3f4f6; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.fm-info-icon i { font-size: 0.75rem; color: #6b7280; }
.fm-info-label { font-size: 11px; color: #9ca3af; margin-bottom: 2px; }
.fm-info-val { font-size: 13px; font-weight: 500; color: #111827; }
.fm-s-pill { display: inline-flex; align-items: center; gap: 5px; font-size: 12px; font-weight: 500; padding: 2px 8px; border-radius: 999px; }
.fm-s-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
.fm-s-active { background: #d1fae5; color: #065f46; }
.fm-s-active .fm-s-dot { background: #059669; }
.fm-s-inactive { background: #fee2e2; color: #991b1b; }
.fm-s-inactive .fm-s-dot { background: #dc2626; }
.fm-tip-item { display: flex; align-items: flex-start; gap: 6px; font-size: 12px; color: #6b7280; margin-bottom: 7px; line-height: 1.45; }
.fm-tip-item:last-child { margin-bottom: 0; }
.fm-tip-dot { width: 4px; height: 4px; border-radius: 50%; background: #d1d5db; flex-shrink: 0; margin-top: 5px; }

@media (max-width: 768px) {
    .fm-layout   { grid-template-columns: 1fr; }
    .fm-two-col  { grid-template-columns: 1fr; }
}
</style>

<div class="fm-wrap">

    <div class="fm-pg-head">
        <div class="fm-pg-left">
            <div class="fm-pg-icon">
                <i class="bi bi-truck"></i>
            </div>
            <div>
                <div class="fm-pg-title">{{ isset($vehicle) ? 'Edit Vehicle' : 'Add New Vehicle' }}</div>
                <div class="fm-pg-sub">{{ isset($vehicle) ? 'Update vehicle information' : 'Register a new vehicle to your fleet' }}</div>
            </div>
        </div>
        <a href="{{ route('vehicles.index') }}" class="fm-btn-back">
            <i class="bi bi-arrow-left"></i> Back to fleet
        </a>
    </div>

    @if ($errors->any())
    <div class="fm-err-box" style="max-width: calc(66.66% - 0.625rem);">
        <i class="bi bi-exclamation-circle-fill"></i>
        <div>
            <div class="fm-err-title">Please fix the following errors</div>
            <ul class="fm-err-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <div class="fm-layout">

        <div>
            <div class="fm-card">
                <div class="fm-card-head">
                    <i class="bi bi-file-earmark-text"></i>
                    <span class="fm-card-head-title">Vehicle details</span>
                </div>
                <div class="fm-card-body">
                    <form action="{{ isset($vehicle) ? route('vehicles.update', $vehicle->id) : route('vehicles.store') }}" method="POST">
                        @csrf
                        @if(isset($vehicle)) @method('PUT') @endif

                        <div class="fm-two-col">
                            <div class="fm-field">
                                <label for="plate_number">
                                    <i class="bi bi-card-text"></i> License plate <span class="fm-req">*</span>
                                </label>
                                <input type="text" id="plate_number" name="plate_number"
                                    class="fm-plate-input {{ $errors->has('plate_number') ? 'is-invalid' : '' }}"
                                    placeholder="ABC-1234"
                                    value="{{ old('plate_number', $vehicle->plate_number ?? '') }}" required>
                                @error('plate_number')
                                    <div class="fm-field-err"><i class="bi bi-info-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                            <div class="fm-field">
                                <label for="type">
                                    <i class="bi bi-list-check"></i> Vehicle type <span class="fm-req">*</span>
                                </label>
                                <input type="text" id="type" name="type"
                                    class="{{ $errors->has('type') ? 'is-invalid' : '' }}"
                                    placeholder="e.g. Van, Truck, Sedan"
                                    value="{{ old('type', $vehicle->type ?? '') }}" required>
                                @error('type')
                                    <div class="fm-field-err"><i class="bi bi-info-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="fm-two-col">
                            <div class="fm-field">
                                <label for="make">
                                    <i class="bi bi-tag"></i> Make <span class="fm-req">*</span>
                                </label>
                                <input type="text" id="make" name="make"
                                    class="{{ $errors->has('make') ? 'is-invalid' : '' }}"
                                    placeholder="e.g. Toyota, Ford"
                                    value="{{ old('make', $vehicle->make ?? '') }}" required>
                                @error('make')
                                    <div class="fm-field-err"><i class="bi bi-info-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                            <div class="fm-field">
                                <label for="model">
                                    <i class="bi bi-tag"></i> Model <span class="fm-req">*</span>
                                </label>
                                <input type="text" id="model" name="model"
                                    class="{{ $errors->has('model') ? 'is-invalid' : '' }}"
                                    placeholder="e.g. HiAce, F-150"
                                    value="{{ old('model', $vehicle->model ?? '') }}" required>
                                @error('model')
                                    <div class="fm-field-err"><i class="bi bi-info-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="fm-two-col">
                            <div class="fm-field">
                                <label for="capacity">
                                    <i class="bi bi-box-seam"></i> Capacity (kg)
                                </label>
                                <input type="number" id="capacity" name="capacity"
                                    class="{{ $errors->has('capacity') ? 'is-invalid' : '' }}"
                                    placeholder="1500"
                                    value="{{ old('capacity', $vehicle->capacity ?? '') }}">
                                <div class="fm-hint">Leave blank if not applicable</div>
                                @error('capacity')
                                    <div class="fm-field-err"><i class="bi bi-info-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                            <div class="fm-field">
                                <label for="status">
                                    <i class="bi bi-toggle-on"></i> Status <span class="fm-req">*</span>
                                </label>
                                <div class="fm-sel-wrap">
                                    <select id="status" name="status"
                                        class="{{ $errors->has('status') ? 'is-invalid' : '' }}" required>
                                        <option value="">Select status</option>
                                        <option value="active"   {{ old('status', $vehicle->status ?? '') === 'active'   ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $vehicle->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <i class="bi bi-chevron-down"></i>
                                </div>
                                @error('status')
                                    <div class="fm-field-err"><i class="bi bi-info-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="fm-divider">

                        <div class="fm-form-actions">
                            <a href="{{ route('vehicles.index') }}" class="fm-btn-cancel">Cancel</a>
                            <button type="submit" class="fm-btn-submit">
                                <i class="bi bi-check-circle-fill"></i>
                                {{ isset($vehicle) ? 'Update Vehicle' : 'Create Vehicle' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="fm-side">

            @if(isset($vehicle))
<div class="fm-card">
    <div class="fm-card-head">
        <i class="bi bi-info-circle"></i>
        <span class="fm-card-head-title">Current values</span>
    </div>
    <div class="fm-card-body">
        <div class="fm-info-row">
            <div class="fm-info-icon"><i class="bi bi-tag"></i></div>
            <div>
                <div class="fm-info-label">Make</div>
                <div class="fm-info-val">{{ $vehicle->make }}</div>
            </div>
        </div>
        <div class="fm-info-row">
            <div class="fm-info-icon"><i class="bi bi-tag"></i></div>
            <div>
                <div class="fm-info-label">Model</div>
                <div class="fm-info-val">{{ $vehicle->model }}</div>
            </div>
        </div>
        <div class="fm-info-row">
            <div class="fm-info-icon"><i class="bi bi-card-text"></i></div>
            <div>
                <div class="fm-info-label">License plate</div>
                <div class="fm-info-val" style="font-family:monospace;letter-spacing:.04em;font-size:12px;">{{ $vehicle->plate_number }}</div>
            </div>
        </div>
        <div class="fm-info-row">
            <div class="fm-info-icon"><i class="bi bi-box-seam"></i></div>
            <div>
                <div class="fm-info-label">Capacity</div>
                <div class="fm-info-val">{{ number_format($vehicle->capacity ?? 0) }} kg</div>
            </div>
        </div>
        <div class="fm-info-row">
            <div class="fm-info-icon"><i class="bi bi-toggle-on"></i></div>
            <div>
                <div class="fm-info-label">Status</div>
                @if($vehicle->status === 'active')
                    <span class="fm-s-pill fm-s-active"><span class="fm-s-dot"></span>Active</span>
                @else
                    <span class="fm-s-pill fm-s-inactive"><span class="fm-s-dot"></span>Inactive</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endif

            <div class="fm-card">
                <div class="fm-card-head">
                    <i class="bi bi-shield-check"></i>
                    <span class="fm-card-head-title">Tips</span>
                </div>
                <div class="fm-card-body" style="padding:14px 16px;">
                    <div class="fm-tip-item"><span class="fm-tip-dot"></span>Use a consistent naming format, e.g. brand + model.</div>
                    <div class="fm-tip-item"><span class="fm-tip-dot"></span>License plate must match official registration exactly.</div>
                    <div class="fm-tip-item"><span class="fm-tip-dot"></span>Set status to Inactive for vehicles under maintenance.</div>
                    <div class="fm-tip-item"><span class="fm-tip-dot"></span>Capacity is the maximum cargo weight in kilograms.</div>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection

