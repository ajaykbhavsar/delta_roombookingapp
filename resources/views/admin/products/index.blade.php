<x-sneat-admin-layout>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Product Management</h4>
            @can('create', \App\Models\Product::class)
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus me-2"></i>Create New Product
            </a>
            @endcan
        </div>
        <div class="card-body">
            @if($products->isEmpty())
                <div class="text-center py-5">
                    <i class="fa-solid fa-box fa-3x text-muted mb-3"></i>
                    <h5 class="mb-2">No products</h5>
                    <p class="text-muted mb-4">Get started by creating a new product.</p>
                    @can('create', \App\Models\Product::class)
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus me-2"></i>Create New Product
                    </a>
                    @endcan
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th>Updated Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td><code>{{ $product->unique_id }}</code></td>
                                    <td><strong>{{ $product->title }}</strong></td>
                                    <td>
                                        @if($product->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $product->created_at->format('M d, Y H:i') }}</td>
                                    <td>{{ $product->updated_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            @can('update', $product)
                                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('delete', $product)
                                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-sneat-admin-layout>

