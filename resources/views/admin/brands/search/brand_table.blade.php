<div class="row">
    <div class="col-md-12">
        {{-- edit brand modal start here --}}
        @foreach ($allBrands as $brand)
            <div class="modal fade" id="editBrandModal{{ $brand->id }}" data-bs-backdrop="static"
                data-bs-keyboard="false" tabindex="-1" aria-labelledby="editBrandModalLabel{{ $brand->id }}"
                aria-hidden="true">

                <div
                    class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-shadow custom_modal_dialog mx-auto">

                    <div class="modal-content modal-shadow">

                        <div class="modal-header bg-secondary">
                            <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal">
                            </button>
                        </div>

                        <div class="text-center mt-1">
                            <h1 class="modal-heading">
                                Edit Brand
                            </h1>
                            <p class="text-muted">
                                Brand ID: {{ $brand->id }}
                            </p>
                        </div>

                        <div class="modal-body custom_modal_body">
                            <form action="{{ route('admin.brands.CRUD.update', $brand->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                @method('PUT')

                                <div class="mb-4">
                                    <label class="form-label fw-bold">
                                        Brand Name
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        class="form-control custom-border @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name', $brand->name) }}"
                                        placeholder="Enter brand name..." required>

                                    @error('name')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    @php
                                        $logo = $brand->images->first();
                                    @endphp

                                    <div class="d-flex align-items-center justify-content-center btn btn-outline-success p-1 border border-1 border-info rounded"
                                        style="width: 80px; height: 80px;">

                                        @if ($logo)
                                            <img src="{{ asset($logo->public_path) }}"
                                                class="img-fluid w-100 h-100 img-thumbnail img-fluid object-fit-contain"
                                                alt="{{ $brand->name }}">
                                        @else
                                            <span class="text-muted small text-center">
                                                No Logo Available
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">
                                        Change Logo
                                    </label>

                                    <input type="file"
                                        class="form-control custom-border @error('logo') is-invalid @enderror"
                                        name="logo" accept="image/*">

                                    @error('logo')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>

                                <div class="mb-5">
                                    <label class="form-label fw-bold">
                                        Brand Status
                                        <span class="text-danger">*</span>
                                    </label>

                                    <select name="status"
                                        class="form-select custom-border
                                    @error('status') is-invalid @enderror"
                                        required>

                                        <option value="1"
                                            {{ old('status', $brand->status) == 1 ? 'selected' : '' }}>
                                            Active
                                        </option>

                                        <option value="0"
                                            {{ old('status', $brand->status) == 0 ? 'selected' : '' }}>
                                            Inactive
                                        </option>

                                    </select>

                                    @error('status')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between mb-2">

                                    <button type="button" class="btn btn-outline-danger px-3" data-bs-dismiss="modal">
                                        Cancel
                                    </button>

                                    <button type="submit" class="btn btn-outline-success px-3">
                                        <i class="fa-solid fa-floppy-disk me-1"></i>
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{-- edit brand modal end here --}}

        {{-- table start here --}}
        <div class="table-responsive" style="scrollbar-width: thin">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-secondary">
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Brand <span class="badge bg-secondary">Logo</span></th>
                        <th>Brand <span class="badge bg-secondary">Name</span></th>
                        <th>Created <span class="badge bg-secondary">At</span></th>
                        <th>Updated <span class="badge bg-secondary">At</span></th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($allBrands as $brand)
                        <tr>
                            <td class="text-center">{{ $brand->id }}</td>

                            <td class="text-center">

                                @php
                                    $logo = $brand->images->first();
                                @endphp

                                <div class="mx-auto d-flex align-items-center justify-content-center btn btn-outline-success p-1 border border-1 border-info rounded"
                                    style="width: 80px; height: 80px;">

                                    @if ($logo)
                                        <img src="{{ asset($logo->public_path) }}" class="img-fluid"
                                            alt="{{ $brand->name }} Logo"
                                            style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                    @else
                                        <span class="text-muted small text-center">
                                            No logo
                                        </span>
                                    @endif

                                </div>

                            </td>

                            <td class="text-center">
                                {{ $brand->name }}
                            </td>

                            <td class="text-center">
                                {{ optional($brand->created_at)->format('d M, Y') }}
                            </td>

                            <td class="text-center">
                                @if ($brand->created_at->equalTo($brand->updated_at))
                                    <p class="text-danger">Brand not updated yet</p>
                                @else
                                    {{ $brand->updated_at->format('d M, Y') }}
                                @endif
                            </td>

                            <td class="text-center">
                                <form action="{{ route('admin.brand.status', $brand->id) }}" method="POST">
                                    @csrf
                                    <button class="btn px-2 py-1 btn-{{ $brand->status ? 'success' : 'danger' }}">
                                        {{ $brand->status ? 'Active' : 'Deactive' }}
                                    </button>
                                </form>
                            </td>

                            <td class="text-center">
                                <button class="btn btn-outline-primary px-2 py-1" data-bs-toggle="modal"
                                    data-bs-target="#editBrandModal{{ $brand->id }}">
                                    <i class="fa-regular fa-pen-to-square"></i> Edit
                                </button>

                                <button type="button" class="btn btn-outline-danger px-2 py-1 ms-2 deleteBtn"
                                    data-url="{{ route('admin.brands.CRUD.destroy', $brand->id) }}"
                                    onclick="openGlobalDeleteModal(this)" title="Delete brand">
                                    <i class="fa-regular fa-trash-can"></i> Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-danger">No brands found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-end mx-1">
                {{ $allBrands->onEachSide(1)->links() }}
            </div>

        </div>
        {{-- table end here --}}
    </div>
</div>
