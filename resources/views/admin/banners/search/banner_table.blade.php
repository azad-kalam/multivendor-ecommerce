<div class="row">
    <div class="col-md-12">
        {{-- edit banner modal start here --}}
        @foreach ($allBanners as $banner)
            <div class="modal fade" id="editBannerModal{{ $banner->id }}" data-bs-backdrop="static"
                data-bs-keyboard="false" tabindex="-1" aria-labelledby="editBannerModal{{ $banner->id }}"
                aria-hidden="true">

                <div
                    class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-shadow custom_modal_dialog mx-auto">

                    <div class="modal-content modal-shadow">

                        <div class="modal-header bg-secondary">
                            <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal">
                            </button>
                        </div>

                        <div class="text-center mt-1">
                            <h1 class="modal-heading mb-3">
                                Edit banner
                            </h1>
                            <p class="text-muted">
                                Banner ID: {{ $banner->id }}
                            </p>
                        </div>

                        <div class="modal-body custom_modal_body">

                            <form action="{{ route('admin.banners.CRUD.update', $banner->id) }}" method="POST"
                                enctype="multipart/form-data">

                                @csrf
                                @method('PUT')

                                @include('partials.global_file.edit_multiple_file', [
                                    'productFind' => $banner,
                                ])

                                <div class="mb-4">
                                    <label class="form-label">
                                        Title:<span class="text-danger">*</span>
                                    </label>

                                    <input type="text" name="title" class="form-control"
                                        value="{{ old('title', $banner->title) }}" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">
                                        Select Type:<span class="text-danger">*</span>
                                    </label>

                                    <select name="type" class="form-control" required>

                                        <option hidden>Select any item</option>

                                        <option value="hero" @selected(old('type', $banner->type) == 'hero')>
                                            Hero [Top large banner]
                                        </option>

                                        <option value="slider" @selected(old('type', $banner->type) == 'slider')>
                                            Slider [Homepage Slider]
                                        </option>

                                        <option value="offer" @selected(old('type', $banner->type) == 'offer')>
                                            Offer [Discount/Offer Banner]
                                        </option>

                                        <option value="popup" @selected(old('type', $banner->type) == 'popup')>
                                            Popup [Popup Banner]
                                        </option>

                                        <option value="featured" @selected(old('type', $banner->type) == 'featured')>
                                            Featured [Featured Promotion Banner]
                                        </option>

                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Occasion:</label>

                                    <input type="text" name="occasion" class="form-control"
                                        value="{{ old('occasion', $banner->occasion) }}">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Start Date:</label>

                                    <input type="datetime-local" name="start_date" class="form-control"
                                        value="{{ old('start_date', optional($banner->start_date)->format('Y-m-d\TH:i')) }}">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">End Date:</label>

                                    <input type="datetime-local" name="end_date" class="form-control"
                                        value="{{ old('end_date', optional($banner->end_date)->format('Y-m-d\TH:i')) }}">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Select Offer:</label>

                                    <select name="offer_type" class="form-control">

                                        <option value="">Select any item</option>

                                        <option value="percentage" @selected(old('offer_type', $banner->offer_type) == 'percentage')>
                                            Percentage (%)
                                        </option>

                                        <option value="fixed" @selected(old('offer_type', $banner->offer_type) == 'fixed')>
                                            Fixed Amount
                                        </option>

                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Offer Value:</label>

                                    <input type="number" step="0.01" name="offer_value" class="form-control"
                                        value="{{ old('offer_value', $banner->offer_value) }}">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Slug:</label>

                                    <input type="text" name="slug" class="form-control"
                                        value="{{ old('slug', $banner->slug) }}">
                                </div>

                                <div style="margin-bottom:60px;">
                                    <label class="form-label">Status:</label>

                                    <select name="status" class="form-control">

                                        <option value="1" @selected(old('status', $banner->status) == 1)>
                                            Active
                                        </option>

                                        <option value="0" @selected(old('status', $banner->status) == 0)>
                                            Inactive
                                        </option>

                                    </select>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-outline-success">
                                        Update
                                    </button>

                                    <button type="reset" class="btn btn-outline-danger">
                                        Reset
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{-- edit brand modal end here --}}

        {{-- upper table start here --}}
        <div class="d-flex justify-content-end mb-2">
            <a class="btn btn-sm btn-outline-warning" data-bs-toggle="collapse" href="#bannertCollapse">
                More Details ...
            </a>
        </div>
        <div class="row collapse" id="bannertCollapse">
            <div class="col-md-12">
                <div class="table-responsive" style="overflow: auto; scrollbar-width: 2px;">
                    <table
                        class="table table-bordered table-hover table-striped data-table text-sm text-nowrap align-middle">
                        <thead class="border border-1 border-dark text-center">
                            <tr>
                                <th>ID</th>
                                <th>Offer <span class="badge bg-secondary">Type</span></th>
                                <th>Offer <span class="badge bg-secondary">Value</span></th>
                                <th>Banner <span class="badge bg-secondary">Occasion</span></th>
                                <th>Start <span class="badge bg-secondary">Date</span></th>
                                <th>End <span class="badge bg-secondary">Date</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($allBanners as $banner)
                                <tr class="text-center">
                                    <td>{{ $banner->id }}</td>
                                    <td>
                                        @if (!empty($banner->offer_type))
                                            {{ ucfirst($banner->offer_type) }}
                                        @else
                                            <small class="text-danger">Data empty</small>
                                        @endif
                                    </td>

                                    <td>
                                        @if (!empty($banner->offer_value))
                                            {{ $banner->offer_value }}
                                        @else
                                            <small class="text-danger">Data empty</small>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($banner->occasion)
                                            {{ $banner->occasion }}
                                        @else
                                            <small class="text-danger">Data empty</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if (!empty($banner->start_date))
                                            {{ $banner->start_date }}
                                        @else
                                            <small class="text-danger">Data empty</small>
                                        @endif
                                    </td>

                                    <td>
                                        @if (!empty($banner->end_date))
                                            {{ $banner->end_date }}
                                        @else
                                            <small class="text-danger">Data empty</small>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-danger">
                                        Data not available
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mx-1">
                    {{ $allBanners->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
        {{-- upper table end here --}}

        {{-- lower table start here --}}
        <div class="table-responsive" style="scrollbar-width: thin">

            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr class="text-center">
                        <th scope="col">ID</th>
                        <th scope="col">Banner <span class="badge bg-secondary">Image</span></th>
                        <th scope="col">Banner <span class="badge bg-secondary">Title</span></th>
                        <th scope="col">Banner <span class="badge bg-secondary">Type</span></th>
                        <th scope="col">Slug</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($allBanners as $banner)
                        <tr class="text-center">
                            <td>{{ $banner->id }}</td>

                            <td>
                                @php
                                    $totalFile = $banner->images->count();
                                    $firstImage = $banner->images[0] ?? null;
                                @endphp

                                @if ($firstImage)
                                    <div class="mx-auto d-flex align-items-center justify-content-center btn btn-outline-success p-1 border border-1 border-info rounded"
                                        style="width: 80px; height: 80px;">
                                        <img src="{{ asset($firstImage->public_path) }}"
                                            alt="{{ $firstImage->alt_text }}" class="h-100 w-100 rounded" />
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
                            <td>
                                @if ($banner->title)
                                    {{ $banner->title }}
                                @else
                                    <small class="text-danger">Data empty</small>
                                @endif
                            </td>

                            <td>
                                @if ($banner->type)
                                    {{ ucfirst($banner->type) }}
                                @else
                                    <small class="text-danger">Data empty</small>
                                @endif
                            </td>

                            <td>
                                @if ($banner->slug)
                                    {{ $banner->slug }}
                                @else
                                    <small class="text-danger">Data empty</small>
                                @endif
                            </td>

                            <td class="td-6 text-center">
                                <form action="{{ route('admin.banner.status', $banner->id) }}" method="POST">
                                    @csrf
                                    <button class="btn px-2 py-1 btn-{{ $banner->status ? 'success' : 'danger' }}">
                                        {{ $banner->status ? 'Active' : 'Deactive' }}
                                    </button>
                                </form>
                            </td>

                            <td class="text-center">
                                <button class="btn btn-outline-primary px-2 py-1" data-bs-toggle="modal"
                                    data-bs-target="#editBannerModal{{ $banner->id }}">
                                    <i class="fa-regular fa-pen-to-square"></i> Edit
                                </button>

                                <button type="button" class="btn btn-outline-danger px-2 py-1 ms-2 deleteBtn"
                                    data-url="{{ route('admin.banners.CRUD.destroy', $banner->id) }}"
                                    onclick="openGlobalDeleteModal(this)" title="Delete banner">
                                    <i class="fa-regular fa-trash-can"></i> Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center text-danger">
                                Banner not available
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-end mx-1">
                {{ $allBanners->onEachSide(1)->links() }}
            </div>

        </div>
        {{-- lower table end here --}}
    </div>
</div>
