<div class="d-flex justify-content-end mb-2">
    <a class="btn btn-sm btn-outline-warning" data-bs-toggle="collapse" href="#productCollapse">
        More Details ...
    </a>
</div>
<div class="row collapse" id="productCollapse">
    <div class="col-md-6">
        <div class="card overflow-auto" style="scrollbar-width: thin">
            <table class="table table-bordered table-hover table-striped data-table text-sm text-nowrap align-middle">
                <thead id="table-head" class="border border-1 border-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Role</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Warranty</th>
                        <th>Featured</th>
                        <th>SKU</th>
                        <th>Visibility</th>
                        <th>Description <kbd class="small py-0">Short</kbd></th>
                        <th>Description <kbd class="small py-0">Full</kbd></th>
                        <th>File <kbd class="small py-0">Name</kbd></th>
                        <th>Image <kbd class="small py-0">Path</kbd></th>
                        <th>Alter <kbd class="small py-0">Text</kbd></th>
                        <th>Video <kbd class="small py-0">Link</kbd></th>
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
                                {{ $product->user->role }}
                            </td>

                            {{-- brand --}}
                            <td>
                                @if ($product->brand != null)
                                    <span>{{ $product->brand }}</span>
                                @else
                                    <span class="text-danger">Brand Name Empty</span>
                                @endif
                            </td>
                            {{-- model --}}
                            <td>
                                @if ($product->model != null)
                                    <span>{{ $product->model }}</span>
                                @else
                                    <span class="text-danger">Model Name Empty</span>
                                @endif
                            </td>
                            {{-- color --}}
                            <td>
                                @if ($product->color != null)
                                    <span>{{ $product->color }}</span>
                                @else
                                    <span class="text-danger">Color Name Empty</span>
                                @endif
                            </td>
                            {{-- size --}}
                            <td>
                                @if ($product->size != null)
                                    <span>{{ $product->size }}</span>
                                @else
                                    <span class="text-danger">Size Name Empty</span>
                                @endif
                            </td>
                            {{-- warranty --}}
                            <td>
                                @if ($product->warranty != null)
                                    <span>{{ $product->warranty }}</span>
                                @else
                                    <span class="text-danger">Warranty Empty</span>
                                @endif
                            </td>
                            {{-- feature --}}
                            <td>
                                @if ($product->featured === 1 || $product->featured === '1')
                                    <span class="text-success">Yes</span>
                                @elseif ($product->featured === 0 || $product->featured === '0')
                                    <span class="text-warning">No</span>
                                @else
                                    <span class="text-danger">Featured Empty</span>
                                @endif
                            </td>
                            {{-- SKU --}}
                            <td>
                                @if ($product->sku != null)
                                    <span>{{ $product->sku }}</span>
                                @else
                                    <span class="text-danger">Sku Empty</span>
                                @endif
                            </td>
                            {{-- visibility --}}
                            <td>
                                @if ($product->visibility === 'visible')
                                    <span class="text-success">Visible</span>
                                @elseif ($product->visibility === 'hidden')
                                    <span class="text-warning">Hidden</span>
                                @else
                                    <span class="text-danger">Visibility Empty</span>
                                @endif
                            </td>
                            {{-- short description --}}
                            <td>
                                @if ($product->short_description != null)
                                    <span>{{ $product->short_description }}</span>
                                @else
                                    <span class="text-danger">Short Description Empty</span>
                                @endif
                            </td>
                            {{-- full description --}}
                            <td>
                                @if ($product->full_description != null)
                                    <span>{{ $product->full_description }}</span>
                                @else
                                    <span class="text-danger">Full Description Empty</span>
                                @endif
                            </td>
                            {{-- file name --}}
                            <td>
                                @if ($product->images && $product->images->count())
                                    <span>
                                        {{ $product->images->pluck('file_name')->implode(', ') }}
                                    </span>
                                @else
                                    <span class="text-danger">File name Empty</span>
                                @endif
                            </td>

                            {{-- first image --}}
                            <td>
                                @if ($product->images->first()?->public_path)
                                    <span>{{ $product->images->first()->public_path }}
                                        <small class="text-primary ms-2"> [ First ]</small>
                                    </span>
                                @else
                                    <span class="text-danger">Image Path Empty</span>
                                @endif
                            </td>

                            {{-- first alt text --}}
                            <td>
                                @if ($product->images->first()?->alt_text)
                                    <span>{{ $product->images->first()->alt_text }}</span>
                                @else
                                    <span class="text-danger">Alt Text Empty</span>
                                @endif
                            </td>

                            {{-- first video url --}}
                            <td>
                                @if ($product->images->first()?->video_url)
                                    <span>{{ $product->images->first()->video_url }}</span>
                                @else
                                    <span class="text-danger">Video Link Empty</span>
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
                <thead id="table-head" class="border border-1 border-dark text-center">
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
                        <tr class="text-center">
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->user_id }}</td>
                            <td>{{ $product->user->role }}</td>

                            @if ($product->price)
                                <td>{{ $product->price->discount_value }}</td>
                            @else
                                <td class="text-danger">Discount Value Empty</td>
                            @endif

                            @if ($product->price)
                                <td>{{ $product->price->discount_type }}</td>
                            @else
                                <td class="text-danger">Discount Type Empty</td>
                            @endif

                            @if ($product->price)
                                <td>
                                    {{ \Carbon\Carbon::parse($product->price->discount_start)->format('d-m-Y h:i A') }}
                                </td>
                            @else
                                <td class="text-danger">Discount Not Start</td>
                            @endif

                            @if ($product->price)
                                <td>
                                    {{ \Carbon\Carbon::parse($product->price->discount_end)->format('d-m-Y h:i A') }}
                                </td>
                            @else
                                <td class="text-danger">Discount Expired</td>
                            @endif

                            @if ($product->product_weight != null)
                                <td>{{ $product->product_weight }}</td>
                            @else
                                <td class="text-danger">Weight Empty</td>
                            @endif

                            @if ($product->stock_quantity != null)
                                <td>{{ $product->stock_quantity }}</td>
                            @else
                                <td class="text-danger">Stock Quantity Empty</td>
                            @endif

                            @if ($product->stock_status != null)
                                <td>{{ $product->stock_status }}</td>
                            @else
                                <td class="text-danger">Stock Status Empty</td>
                            @endif


                            @if ($product->manage_stock != null)
                                <td>{{ $product->manage_stock }}</td>
                            @else
                                <td class="text-danger">Manage Stock Empty</td>
                            @endif

                            @if ($product->meta_title != null)
                                <td>{{ $product->meta_title }}</td>
                            @else
                                <td class="text-danger">Meta Title Empty</td>
                            @endif

                            @if ($product->meta_description != null)
                                <td>{{ $product->meta_description }}</td>
                            @else
                                <td class="text-danger">Meta Description Empty</td>
                            @endif

                            @if ($product->meta_keywords != null)
                                <td>{{ $product->meta_keywords }}</td>
                            @else
                                <td class="text-danger">Meta Keywords Empty</td>
                            @endif

                            @if ($product->created_at != null)
                                <td>
                                    {{ $product->created_at->format('d/m/Y') }}
                                    <small class="text-muted ms-2">{{ $product->created_at->format('h:i A') }}</small>
                                </td>
                            @else
                                <td class="text-danger text-center">Data not found</td>
                            @endif

                            @if ($product->updated_at == $product->created_at)
                                <td class="text-danger text-center">
                                    <small>Data not updated yet.</small>
                                </td>
                            @else
                                <td>
                                    {{ $product->updated_at->format('d/m/Y') }}
                                    <small class="text-muted ms-2">{{ $product->updated_at->format('h:i A') }}</small>
                                </td>
                            @endif
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
                                    @if ($product->price)
                                        <i class="fa-solid fa-bangladeshi-taka-sign text-danger"></i>
                                        {{ $product->price->regular_price }}
                                    @else
                                        <span class="text-danger">Regular Price Empty</span>
                                    @endif
                                </td>

                                <!-- Selling Price -->
                                <td class="td-11">
                                    @if ($product->price)
                                        <i class="fa-solid fa-bangladeshi-taka-sign text-danger"></i>
                                        {{ $product->price->selling_price }}
                                    @else
                                        <span class="text-danger">Selling Price Empty</span>
                                    @endif
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

                                    <button type="button" class="btn btn-outline-danger px-1 py-0"
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
