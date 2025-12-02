<x-sneat-admin-layout>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Edit Location</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.locations.update', $location) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="unique_id" class="form-label">Unique ID</label>
                    <input type="text" id="unique_id" value="{{ $location->unique_id }}"
                           class="form-control" readonly>
                    <small class="text-muted">Unique ID cannot be changed</small>
                </div>

                <div class="mb-3">
                    <label for="location_id" class="form-label">Location ID <span class="text-danger">*</span></label>
                    <input type="text" name="location_id" id="location_id" value="{{ old('location_id', $location->location_id) }}" required
                        class="form-control @error('location_id') is-invalid @enderror"
                        placeholder="Enter external location ID">
                    @error('location_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Must be unique (e.g., LOC-001).</small>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Location Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $location->name) }}" required
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Enter location name">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Name must be unique</small>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" value="1" id="is_active"
                               {{ old('is_active', $location->is_active) ? 'checked' : '' }}
                               class="form-check-input">
                        <label class="form-check-label" for="is_active">
                            Active
                        </label>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.locations.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save me-2"></i>Update Location
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-sneat-admin-layout>


