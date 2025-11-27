<x-sneat-admin-layout>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Edit Product</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.update', $product) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3"  style="display: none;">
                    <label for="unique_id" class="form-label">Unique ID</label>
                    <input type="text" id="unique_id" value="{{ $product->unique_id }}"
                           class="form-control" readonly>
                    <small class="text-muted">Unique ID cannot be changed</small>
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $product->title) }}" required
                        class="form-control @error('title') is-invalid @enderror"
                        placeholder="Enter product title">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Title must be unique</small>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" value="1" id="is_active"
                               {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                               class="form-check-input">
                        <label class="form-check-label" for="is_active">
                            Active
                        </label>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save me-2"></i>Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-sneat-admin-layout>

