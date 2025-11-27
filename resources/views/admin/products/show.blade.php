<x-sneat-admin-layout>
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="card-title mb-0">Product Details</h4>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="text-muted small">Unique ID</label>
                    <p class="mb-0"><code class="fs-6">{{ $product->unique_id }}</code></p>
                </div>
                <div class="col-md-6">
                    <label class="text-muted small">Status</label>
                    <p class="mb-0">
                        @if($product->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <label class="text-muted small">Title</label>
                    <p class="mb-0"><strong>{{ $product->title }}</strong></p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="text-muted small">Created Date</label>
                    <p class="mb-0">{{ $product->created_at->format('M d, Y H:i:s') }}</p>
                </div>
                <div class="col-md-6">
                    <label class="text-muted small">Updated Date</label>
                    <p class="mb-0">{{ $product->updated_at->format('M d, Y H:i:s') }}</p>
                </div>
            </div>

            <div class="d-flex gap-2">
                @can('update', $product)
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
                        <i class="fa-solid fa-edit me-2"></i>Edit
                    </a>
                @endcan
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
    </div>
</x-sneat-admin-layout>

