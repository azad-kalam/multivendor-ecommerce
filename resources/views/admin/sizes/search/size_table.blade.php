<div class="row">
    <div class="col-md-12">

        <div class="table-responsive" style="scrollbar-width: thin">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-secondary">
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Size Name</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Created At</th>
                        <th class="text-center">Updated At</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($all_sizes as $size)
                        <!-- size edit midal start here -->
                        <div class="modal fade" id="editSizeModal{{ $size->id }}" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1"
                            aria-labelledby="editSizeModalLabel{{ $size->id }}" aria-hidden="true">

                            <div class="modal-dialog modal-dialog-centered custom_modal_dialog mx-auto">

                                <div class="modal-content modal-shadow">

                                    <div class="modal-header bg-secondary">
                                        <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal">
                                        </button>
                                    </div>

                                    <div class="text-center mt-1">
                                        <h1 class="modal-heading">
                                            Edit Size
                                        </h1>
                                        <p class="text-muted">
                                            Size ID: {{ $size->id }}
                                        </p>
                                    </div>

                                    <div class="modal-body custom_modal_body">

                                        <form action="{{ route('admin.sizes.CRUD.update', $size->id) }}" method="POST">

                                            @csrf
                                            @method('PUT')

                                            <div class="mb-4 mt-3">
                                                <label class="form-label fw-bold">
                                                    Size Name
                                                </label>

                                                <input type="text" class="form-control" name="name"
                                                    value="{{ old('name', $size->name) }}">

                                                @error('name')
                                                    <small class="text-danger">
                                                        {{ $message }}
                                                    </small>
                                                @enderror
                                            </div>

                                            <div class="mb-5">
                                                <label class="form-label fw-bold">
                                                    Size Status
                                                </label>

                                                <select name="status" class="form-select" required>

                                                    <option value="1"
                                                        {{ old('status', $size->status) == 1 ? 'selected' : '' }}>
                                                        Active
                                                    </option>

                                                    <option value="0"
                                                        {{ old('status', $size->status) == 0 ? 'selected' : '' }}>
                                                        Inactive
                                                    </option>

                                                </select>

                                                @error('status')
                                                    <small class="text-danger">
                                                        {{ $message }}
                                                    </small>
                                                @enderror
                                            </div>

                                            <div class="modal-footer border-0 d-flex justify-content-between">

                                                <button type="button" class="btn btn-outline-danger px-3"
                                                    data-bs-dismiss="modal">
                                                    Cancel
                                                </button>

                                                <button type="submit" class="btn btn-outline-success px-3">
                                                    Update
                                                </button>

                                            </div>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        </div>
                        <!-- edit modal end here -->

                        <!-- table data start here -->
                        <tr>
                            <td class="text-center">{{ $size->id }}</td>

                            <td class="text-center">
                                {{ $size->name }}
                            </td>

                            <td class="text-center">
                                <form action="{{ route('admin.size.status', $size->id) }}" method="POST">
                                    @csrf
                                    <button class="btn px-2 py-1 btn-{{ $size->status ? 'success' : 'danger' }}">
                                        {{ $size->status ? 'Active' : 'Deactive' }}
                                    </button>
                                </form>
                            </td>

                            <td class="text-center">
                                {{ optional($size->created_at)->format('d M, Y') }}
                            </td>

                            <td class="text-center">
                                @if ($size->created_at->equalTo($size->updated_at))
                                    <p class="m-auto text-danger">Size not updated yet</p>
                                @else
                                    {{ $size->updated_at->format('d M, Y') }}
                                @endif
                            </td>

                            <td class="text-center">
                                <button type="button" class="btn btn-outline-primary px-2 py-1" data-bs-toggle="modal"
                                    data-bs-target="#editSizeModal{{ $size->id }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Edit
                                </button>

                                <button type="button" class="btn btn-outline-danger px-2 py-1 deleteBtn ms-2"
                                    data-url="{{ route('admin.sizes.CRUD.destroy', $size->id) }}"
                                    onclick="openGlobalDeleteModal(this)" title="Delete size">
                                    <i class="fa-regular fa-trash-can"></i> Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-danger">No sizes found.</td>
                        </tr>
                        <!-- table data end here -->
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-end mx-1">
                {{ $all_sizes->onEachSide(1)->links() }}
            </div>

        </div>
    </div>
</div>
