<div class="d-flex justify-content-end mb-2">
    <a class="btn btn-sm btn-outline-warning" data-bs-toggle="collapse" href="#productCollapse">
        More Details ...
    </a>
</div>
<div class="row collapse" id="productCollapse">
    <div class="col-md-6">
        <div class="card overflow-auto" style="scrollbar-width: thin">
            <table class="table table-bordered table-hover table-striped data-table text-sm text-nowrap align-middle">
                <thead class="border border-1 border-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Role</th>
                        <th>Description <span class="badge bg-secondary">Short</span></th>
                        <th>Description <span class="badge bg-secondary">Full</span></th>
                        <th>Warranty</th>
                        <th>Featured</th>
                        <th>Visibility</th>
                        <th>File <span class="badge bg-secondary">Name</span></th>
                        <th>Image <span class="badge bg-secondary">Path</span></th>
                        <th>Alter <span class="badge bg-secondary">Text</span></th>
                        <th>Video <span class="badge bg-secondary">Link</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allProducts as $product)
                        <tr class="text-center">
                            <td>
                                {{ $product->id }}
                            </td>
                            <td>
                                {{ $product->user_id }}
                            </td>

                            <td>
                                @if ($product->user?->role)
                                    {{ $product->user->role }}
                                @else
                                    <span class="text-danger">Data empty</span>
                                @endif
                            </td>

                            <td>
                                @if ($product->short_description != null)
                                    <span>{{ $product->short_description }}</span>
                                @else
                                    <span class="text-danger">Data empty</span>
                                @endif
                            </td>

                            <td>
                                @if ($product->full_description != null)
                                    <span>{{ $product->full_description }}</span>
                                @else
                                    <span class="text-danger">Data empty</span>
                                @endif
                            </td>

                            <td>
                                @if ($product->warranty != null)
                                    <span>{{ $product->warranty }}</span>
                                @else
                                    <span class="text-danger">Data empty</span>
                                @endif
                            </td>

                            <td>
                                @if ($product->featured === 1 || $product->featured === '1')
                                    <span class="text-success">Yes</span>
                                @elseif ($product->featured === 0 || $product->featured === '0')
                                    <span class="text-warning fw-bold">No</span>
                                @else
                                    <span class="text-danger">Data empty</span>
                                @endif
                            </td>

                            <td>
                                @if ($product->visibility === 'visible')
                                    <span class="text-success">Visible</span>
                                @elseif ($product->visibility === 'hidden')
                                    <span class="text-warning">Hidden</span>
                                @else
                                    <span class="text-danger">Data empty</span>
                                @endif
                            </td>

                            <td>
                                @if ($product->images && $product->images->count())
                                    <span>
                                        {{ $product->images->pluck('file_name')->implode(', ') }}
                                    </span>
                                @else
                                    <span class="text-danger">Data empty</span>
                                @endif
                            </td>

                            <td>
                                @if ($product->images->first()?->public_path)
                                    <span>{{ $product->images->first()->public_path }}
                                        <small class="text-primary ms-2"> [ First ]</small>
                                    </span>
                                @else
                                    <span class="text-danger">Data empty</span>
                                @endif
                            </td>

                            <td>
                                @if ($product->images->first()?->alt_text)
                                    <span>{{ $product->images->first()->alt_text }}</span>
                                @else
                                    <span class="text-danger">Data empty</span>
                                @endif
                            </td>

                            <td>
                                @if ($product->images->first()?->video_url)
                                    <span>{{ $product->images->first()->video_url }}</span>
                                @else
                                    <span class="text-danger">Not available</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card overflow-auto" style="scrollbar-width: thin">
            <table
                class="table table-bordered table-hover table-striped data-table product_table text-sm text-nowrap align-middle">
                <thead class="border border-1 border-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Role</th>
                        <th>Discount <kbd class="small py-0">Value</kbd></th>
                        <th>Discount <kbd class="small py-0">Type</kbd></th>
                        <th>Discount <kbd class="small py-0">Start</kbd></th>
                        <th>Discount <kbd class="small py-0">End</kbd></th>
                        <th>Weight <kbd class="small py-0">KG</kbd></th>
                        <th>Stock <kbd class="small py-0">Quantity</kbd></th>
                        <th>Stock <kbd class="small py-0">Status</kbd></th>
                        <th>Stock <kbd class="small py-0">Manage</kbd></th>
                        <th>Meta <kbd class="small py-0">Title</kbd></th>
                        <th>Meta <kbd class="small py-0">Description</kbd></th>
                        <th>Meta <kbd class="small py-0">Keywords</kbd></th>
                        <th>Created</th>
                        <th>Updated</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($allProducts as $product)
                        @php
                            $variant = $product->variants->first();
                        @endphp

                        <tr class="text-center">

                            <td>{{ $product->id }}</td>

                            <td>{{ $product->user_id }}</td>

                            <td>
                                @if ($product->user && $product->user->role)
                                    {{ $product->user->role }}
                                @else
                                    <span class="text-danger">Not available</span>
                                @endif
                            </td>

                            <td>
                                @if (!is_null($variant?->discount_value))
                                    {{ $variant->discount_value }}
                                    {{ $variant->discount_type === 'percent' ? '%' : '' }}
                                @else
                                    <span class="text-danger">Not available</span>
                                @endif
                            </td>

                            <td>
                                @if ($variant?->discount_type)
                                    {{ ucfirst($variant->discount_type) }}
                                @else
                                    <span class="text-danger">Not available</span>
                                @endif
                            </td>

                            <td>
                                @if ($variant?->discount_start)
                                    {{ \Carbon\Carbon::parse($variant->discount_start)->format('d-m-Y h:i A') }}
                                @else
                                    <span class="text-danger">Not available</span>
                                @endif
                            </td>

                            <td>
                                @if ($variant?->discount_end)
                                    {{ \Carbon\Carbon::parse($variant->discount_end)->format('d-m-Y h:i A') }}
                                @else
                                    <span class="text-danger">Not available</span>
                                @endif
                            </td>

                            <td>
                                @if (!is_null($product->product_weight))
                                    {{ $product->product_weight }}
                                @else
                                    <span class="text-danger">Not available</span>
                                @endif
                            </td>

                            <td>
                                @if (!empty($variant->stock_quantity))
                                    {{ $variant->stock_quantity }}
                                @else
                                    <span class="text-danger">Not available</span>
                                @endif
                            </td>

                            <td>
                                @if ($variant?->stock_status === 'in_stock')
                                    <span class="text-success">In Stock</span>
                                @elseif ($variant?->stock_status === 'out_of_stock')
                                    <span class="text-danger">Out Of Stock</span>
                                @else
                                    <span class="text-danger">Not available</span>
                                @endif
                            </td>

                            <td>
                                @if (!is_null($variant?->manage_stock))
                                    <span
                                        class="{{ $variant->manage_stock ? 'text-success' : 'text-warning fw-bold' }}">
                                        {{ $variant->manage_stock ? 'Yes' : 'No' }}
                                    </span>
                                @else
                                    <span class="text-danger">Not available</span>
                                @endif
                            </td>

                            <td>
                                @if (!empty($product->meta_title))
                                    {{ $product->meta_title }}
                                @else
                                    <span class="text-danger">Not available</span>
                                @endif
                            </td>

                            <td>
                                @if (!empty($product->meta_description))
                                    {{ $product->meta_description }}
                                @else
                                    <span class="text-danger">Not available</span>
                                @endif
                            </td>

                            <td>
                                @if (!empty($product->meta_keywords))
                                    {{ $product->meta_keywords }}
                                @else
                                    <span class="text-danger">Not available</span>
                                @endif
                            </td>

                            <td>
                                @if ($product->created_at)
                                    {{ $product->created_at->format('d/m/Y') }}
                                    <small class="text-muted ms-2">
                                        {{ $product->created_at->format('h:i A') }}
                                    </small>
                                @else
                                    <span class="text-danger">Not available</span>
                                @endif
                            </td>

                            <td>
                                @if ($product->updated_at && $product->created_at && $product->updated_at->equalTo($product->created_at))
                                    <small class="text-danger">
                                        Data not updated yet.
                                    </small>
                                @elseif ($product->updated_at)
                                    {{ $product->updated_at->format('d/m/Y') }}
                                    <small class="text-muted ms-2">
                                        {{ $product->updated_at->format('h:i A') }}
                                    </small>
                                @else
                                    <span class="text-danger">Not available</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card overflow-auto" style="scrollbar-width: thin">
            <table class="table table-bordered table-hover table-striped data-table text-sm text-nowrap align-middle">
                <thead class="border border-1 border-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>SKU</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allProducts as $product)
                        <tr class="text-center">
                            <td>
                                {{ $product->id }}
                            </td>

                            <td>
                                {{ $product->user_id }}
                            </td>

                            <td>
                                @if ($product->brand?->name)
                                    {{ $product->brand->name }}
                                @else
                                    <span class="text-danger">Not available</span>
                                @endif
                            </td>

                            <td>
                                @if ($product->productModel?->name)
                                    {{ $product->productModel->name }}
                                @else
                                    <span class="text-danger">Not available</span>
                                @endif
                            </td>

                            <td>
                                @foreach ($product->variants->pluck('color.name')->unique() as $color)
                                    <span class="badge bg-primary">
                                        {{ $color }}
                                    </span>
                                @endforeach
                            </td>

                            <td>
                                @foreach ($product->variants->pluck('size.name')->unique() as $size)
                                    <span class="badge bg-success">
                                        {{ $size }}
                                    </span>
                                @endforeach
                            </td>

                            <td class="text-start align-middle">
                                <ul class="mb-0">
                                    @forelse ($product->variants as $variant)
                                        <li>{{ $variant->sku }}</li>
                                    @empty
                                        <li>No variants found</li>
                                    @endforelse
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive" style="scrollbar-width: thin">
            <table class="table table-bordered table-hover table-data text-sm-nowrap align-middle">
                <thead id="table-head" class="border border-1 border-dark">
                    <tr>
                        <th class="td-5">ID</th>
                        <th class="td-14">Product <kbd class="pt-0">Name</kbd></th>
                        <th class="td-15">Category <kbd class="pt-0">Name</kbd></th>
                        <th class="td-13">Product <kbd class="pt-0">Image</kbd></th>
                        <th class="td-11">Price <kbd class="pt-0"><small>Regular</small></kbd></th>
                        <th class="td-11">Price <kbd class="pt-0"><small>Selling</small></kbd></th>
                        <th class="td-13 text-center">Slug</th>
                        <th class="td-6 text-center">Status</th>
                        <th class="td-12 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($allProducts->isNotEmpty())
                        @foreach ($allProducts as $product)
                            <tr>
                                <td class="td-5">{{ $product->id }}</td>

                                <!-- Product Name -->
                                <td class="td-14">
                                    @if ($product->name != null)
                                        <span>{{ $product->name }}</span>
                                    @else
                                        <span class="text-danger">Product Name Empty</span>
                                    @endif
                                </td>

                                <!-- Product Category -->
                                <td class="td-15">
                                    @if ($product->subcategory && $product->subcategory->category)
                                        <span>{{ $product->subcategory->category->name }}</span>
                                    @else
                                        <span class="text-danger">No Category Found</span>
                                    @endif

                                    <ul class="list-group">
                                        <li class="list-group-item p-1">
                                            <details>
                                                <summary class="text-sm text-secondary text-center">Sub-category:
                                                </summary>
                                                <ul class="list-group">
                                                    <li class="text-sm list-group-item p-1 text-center"
                                                        style="color: maroon;">
                                                        {{ $product->subcategory?->subcategory_name ?? 'No Subcategory Found' }}
                                                    </li>
                                                </ul>
                                            </details>
                                        </li>
                                    </ul>
                                </td>

                                <!-- Product Image -->
                                <td class="td-13">
                                    @php
                                        $totalFile = $product->images->count();
                                        $firstImage = $product->images[0] ?? null;
                                    @endphp
                                    @if ($firstImage)
                                        <div class="mx-auto d-flex align-items-center justify-content-center btn btn-outline-success p-1 border border-1 border-info rounded"
                                            style="width: 80px; height: 80px;">
                                            <img src="{{ asset($firstImage->public_path) }}"
                                                class="h-100 w-100 rounded" />
                                        </div>
                                    @else
                                        <div class="mx-auto d-flex align-items-center justify-content-center btn btn-outline-warning p-1 border border-1 border-danger rounded"
                                            style="width: 80px; height: 80px;">
                                            <span class="small text-center text-danger">Image not found</span>
                                        </div>
                                    @endif
                                    @if ($totalFile > 0)
                                        <div class="d-flex justify-content-between px-md-3 mt-1 text-success">
                                            <small>More :</small>
                                            <small>{{ $totalFile - 1 }}</small>
                                        </div>
                                    @endif
                                </td>
                                <!-- regular price -->
                                <td class="td-11">
                                    {{ $product->variants->first()?->regular_price ?? 'not available' }}
                                </td>

                                <!-- Selling Price -->
                                <td class="td-11">
                                    {{ $product->variants->first()?->selling_price ?? 'not available' }}
                                </td>

                                <!-- Product Slug -->
                                <td class="td-13">
                                    <p style="font-size: 15px">{{ $product->slug }} </p>
                                </td>

                                <!-- Product Status -->
                                <td class="td-6 text-center">
                                    <form action="{{ route('admin.product.status', $product->id) }}" method="POST">
                                        @csrf
                                        <button
                                            class="btn px-2 py-1 btn-{{ $product->status ? 'success' : 'danger' }}">
                                            {{ $product->status ? 'Active' : 'Deactive' }}
                                        </button>
                                    </form>
                                </td>

                                <!-- Product Action -->
                                <td class="td-12 text-center text-md-start text-lg-center">
                                    <a href="{{ route('admin.products.CRUD.show', $product->id) }}">
                                        <button class="btn btn-outline-success px-1 py-0">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </a>

                                    <a href="{{ route('admin.products.CRUD.edit', $product->id) }}">
                                        <button class="btn btn-warning btn-outline-info px-1 py-0 my-2 mx-md-1">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                    </a>

                                    <button type="button" class="btn btn-outline-danger px-1 py-0 deleteBtn"
                                        data-url="{{ route('admin.products.CRUD.destroy', $product->id) }}"
                                        onclick="openGlobalDeleteModal(this)" title="Delete product">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9" class="text-center text-danger">No Data Found</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div class="d-flex justify-content-end mx-1">
                {{ $allProducts->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>
