<x-sneat-admin-layout>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Edit Room Type</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.room-types.update', $roomType) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Room Type Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $roomType->name) }}" required
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Enter room type name">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description (optional)</label>
                    <textarea name="description" id="description" rows="4"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="Describe this room type">{{ old('description', $roomType->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- <div class="mb-3">
                    <label for="base_rate" class="form-label">Base Rate (INR) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" min="0" name="base_rate" id="base_rate"
                           value="{{ old('base_rate', $roomType->base_rate) }}"
                           class="form-control @error('base_rate') is-invalid @enderror"
                           placeholder="Enter default nightly rate">
                    @error('base_rate')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> -->

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" value="1" id="is_active"
                               {{ old('is_active', $roomType->is_active) ? 'checked' : '' }}
                               class="form-check-input">
                        <label class="form-check-label" for="is_active">
                            Active
                        </label>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.room-types.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save me-2"></i>Update Room Type
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-sneat-admin-layout>


