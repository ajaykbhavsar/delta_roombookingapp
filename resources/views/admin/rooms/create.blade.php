<x-sneat-admin-layout>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Create Room</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.rooms.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="location_id" class="form-label">Location <span class="text-danger">*</span></label>
                    <select name="location_id" id="location_id"
                            class="form-select @error('location_id') is-invalid @enderror" required>
                        <option value="" disabled {{ old('location_id') ? '' : 'selected' }}>Select location</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                {{ $location->name }} ({{ $location->location_id }})
                            </option>
                        @endforeach
                    </select>
                    @error('location_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="room_type_id" class="form-label">Room Type <span class="text-danger">*</span></label>
                    <select name="room_type_id" id="room_type_id"
                            class="form-select @error('room_type_id') is-invalid @enderror" required>
                        <option value="" disabled {{ old('room_type_id') ? '' : 'selected' }}>Select room type</option>
                        @foreach($roomTypes as $roomType)
                            <option value="{{ $roomType->id }}" {{ old('room_type_id') == $roomType->id ? 'selected' : '' }}>
                                {{ $roomType->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('room_type_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="room_no" class="form-label">Room Number <span class="text-danger">*</span></label>
                    <input type="text" name="room_no" id="room_no" value="{{ old('room_no') }}" required
                        class="form-control @error('room_no') is-invalid @enderror"
                        placeholder="Enter room number">
                    @error('room_no')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Must be unique for the same Location and Room Type.</small>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description (optional)</label>
                    <textarea name="description" id="description" rows="4"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="Enter short description">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="room_status" class="form-label">Housekeeping Status <span class="text-danger">*</span></label>
                    <select name="room_status" id="room_status" class="form-select @error('room_status') is-invalid @enderror" required>
                        <option value="" disabled {{ old('room_status') ? '' : 'selected' }}>Select status</option>
                        @foreach($roomStatusOptions as $value => $label)
                            <option value="{{ $value }}" {{ old('room_status') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('room_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="occupancy_status" class="form-label">Occupancy Status <span class="text-danger">*</span></label>
                    <select name="occupancy_status" id="occupancy_status"
                            class="form-select @error('occupancy_status') is-invalid @enderror" required>
                        @foreach($occupancyStatusOptions as $value => $label)
                            <option value="{{ $value }}" {{ old('occupancy_status', 'empty') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('occupancy_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="base_rate" class="form-label">Base Rate (Rs) <span class="text-danger">*</span></label>
                    <input type="number" name="base_rate" id="base_rate" min="0" step="0.01"
                           value="{{ old('base_rate') }}"
                           class="form-control @error('base_rate') is-invalid @enderror"
                           placeholder="Enter per-night base rate">
                    @error('base_rate')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" value="1" id="is_active"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="form-check-input">
                        <label class="form-check-label" for="is_active">
                            Active
                        </label>
                    </div>
                    <small class="text-muted d-block mt-1">Rooms are active by default.</small>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save me-2"></i>Create Room
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-sneat-admin-layout>


