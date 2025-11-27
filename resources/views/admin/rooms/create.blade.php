<x-sneat-admin-layout>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Create Room</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.rooms.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="room_no" class="form-label">Room Number <span class="text-danger">*</span></label>
                    <input type="text" name="room_no" id="room_no" value="{{ old('room_no') }}" required
                        class="form-control @error('room_no') is-invalid @enderror"
                        placeholder="Enter room number">
                    @error('room_no')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Room number must be unique.</small>
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">location (optional)</label>
                    <textarea name="location" id="location" rows="3"
                        class="form-control @error('location') is-invalid @enderror"
                        placeholder="Enter  location">{{ old('location') }}</textarea>
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
                    <label for="room_status" class="form-label">Room Status  <span class="text-danger">*</span></label>
                    <select name="room_status" id="room_status" class="form-select @error('room_status') is-invalid @enderror" required>
                        @foreach($roomStatusOptions as $value => $label)
                            <option value="{{ $value }}" >
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('location')
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


