<div class="row">
    <div class="col-md-12">

        <div class="table-responsive" style="scrollbar-width: thin">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-secondary">
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Color Name</th>
                        <th class="text-center">Color Code</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Created At</th>
                        <th class="text-center">Updated At</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($all_colors as $color)
                        <!-- color edit midal start here -->
                        <div class="modal fade" id="editColoreModal{{ $color->id }}" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="editColoreModal{{ $color->id }}"
                            aria-hidden="true">

                            <div class="modal-dialog modal-dialog-centered custom_modal_dialog mx-auto">

                                <div class="modal-content modal-shadow">

                                    <div class="modal-header bg-secondary">
                                        <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal">
                                        </button>
                                    </div>

                                    <div class="text-center mt-1">
                                        <h1 class="modal-heading">
                                            Edit Color
                                        </h1>
                                        <p class="text-muted">
                                            Color ID: {{ $color->id }}
                                        </p>
                                    </div>

                                    <div class="modal-body custom_modal_body">

                                        <form action="{{ route('admin.colors.CRUD.update', $color->id) }}"
                                            method="POST">

                                            @csrf
                                            @method('PUT')

                                            <div class="mb-4 mt-3">
                                                <label class="form-label fw-bold">
                                                    Color Name
                                                </label>

                                                <input type="text" class="form-control" name="name"
                                                    value="{{ old('name', $color->name) }}">

                                                @error('name')
                                                    <small class="text-danger">
                                                        {{ $message }}
                                                    </small>
                                                @enderror
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold">
                                                    Color Code
                                                </label>

                                                <input type="color" class="form-control p-0" name="code"
                                                    value="{{ old('code', $color->code) }}">

                                                @error('code')
                                                    <small class="text-danger">
                                                        {{ $message }}
                                                    </small>
                                                @enderror
                                            </div>

                                            <div class="mb-5">
                                                <label class="form-label fw-bold">
                                                    Color Status
                                                </label>

                                                <select name="status" class="form-select">

                                                    <option value="1"
                                                        {{ old('status', $color->status) == 1 ? 'selected' : '' }}>
                                                        Active
                                                    </option>

                                                    <option value="0"
                                                        {{ old('status', $color->status) == 0 ? 'selected' : '' }}>
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
                                                <button type="submit" class="btn btn-outline-success px-3">
                                                    Update
                                                </button>
                                                <button type="button" class="btn btn-outline-danger px-3">
                                                    Reset
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
                            <td class="text-center">{{ $color->id }}</td>

                            <td class="text-center">
                                {{ $color->name }}
                            </td>

                            <td class="text-center">
                                <span style="background:{{ $color->code }};padding:5px 15px;border-radius:5px;"
                                    class="me-2">
                                </span>
                                [ {{ $color->code }} ]
                            </td>

                            <td class="text-center">
                                <form action="{{ route('admin.color.status', $color->id) }}" method="POST">
                                    @csrf
                                    <button class="btn px-2 py-1 btn-{{ $color->status ? 'success' : 'danger' }}">
                                        {{ $color->status ? 'Active' : 'Deactive' }}
                                    </button>
                                </form>
                            </td>

                            <td class="text-center">
                                {{ optional($color->created_at)->format('d M, Y') }}
                            </td>

                            <td class="text-center">
                                @if ($color->created_at->equalTo($color->updated_at))
                                    <p class="m-auto text-danger">Color not updated yet</p>
                                @else
                                    {{ $color->updated_at->format('d M, Y') }}
                                @endif
                            </td>

                            <td class="text-center">
                                <button type="button" class="btn btn-outline-primary px-2 py-1" data-bs-toggle="modal"
                                    data-bs-target="#editColoreModal{{ $color->id }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Edit
                                </button>

                                <button type="button" class="btn btn-outline-danger px-2 py-1 deleteBtn ms-2"
                                    data-url="{{ route('admin.colors.CRUD.destroy', $color->id) }}"
                                    onclick="openGlobalDeleteModal(this)" title="Delete color">
                                    <i class="fa-regular fa-trash-can"></i> Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-danger">No colors found.</td>
                        </tr>
                        <!-- table data end here -->
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-end mx-1">
                {{ $all_colors->onEachSide(1)->links() }}
            </div>

        </div>
    </div>
</div>
