<div class="row">
    <div class="col-md-12">

        {{-- product model edit modal end here --}}
        @foreach ($product_models as $model)
            <div class="modal fade mt-0" id="edit_product_model_Modal{{ $model->id }}" data-bs-backdrop="static"
                data-bs-keyboard="false" tabindex="-1">

                <div
                    class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-shadow custom_modal_dialog mx-auto">

                    <div class="modal-content">

                        <div class="modal-header bg-secondary">
                            <button type="button" class="btn-close bg-danger btn-hover" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="text-center mt-1">
                            <h1 class="modal-heading">
                                Edit Product Model
                            </h1>

                            <p class="text-muted">
                                Model ID: {{ $model->id }}
                            </p>
                        </div>

                        <div class="modal-body custom_modal_body">

                            <form action="{{ route('admin.product_models.CRUD.update', $model->id) }}" method="POST">

                                @csrf
                                @method('PUT')

                                <div class="mb-4 mt-4">
                                    <label class="form-label fw-bold">
                                        Brand Name:
                                    </label>

                                    <input type="text" class="form-control custom-border"
                                        value="{{ $model->brand->name }}" readonly>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">
                                        Model Name:
                                    </label>

                                    <input type="text" class="form-control custom-border" name="name"
                                        value="{{ old('name', $model->name) }}" required>

                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-5">
                                    <label class="form-label fw-bold">
                                        Status:
                                    </label>

                                    <select name="status" class="form-select custom-border" required>

                                        <option value="1"
                                            {{ old('status', $model->status) == 1 ? 'selected' : '' }}>
                                            Active
                                        </option>

                                        <option value="0"
                                            {{ old('status', $model->status) == 0 ? 'selected' : '' }}>
                                            Inactive
                                        </option>

                                    </select>

                                    @error('status')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mt-4 d-flex justify-content-between">
                                    <button type="submit" class="btn btn-outline-success px-2">
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
        {{-- product model edit modal end here --}}

        <div class="table-responsive" style="scrollbar-width: thin">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-secondary">
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Brand Name</th>
                        <th class="text-center">Model Name</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Created At</th>
                        <th class="text-center">Updated At</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($product_models as $model)
                        <tr>

                            <td class="text-center">
                                {{ $model->id }}
                            </td>

                            <td class="text-center">
                                {{ $model->brand->name }}
                            </td>

                            <td class="text-center">
                                {{ $model->name }}
                            </td>

                            <td class="text-center">

                                <form action="{{ route('admin.model.status', $model->id) }}" method="POST">

                                    @csrf

                                    <button type="submit"
                                        class="btn btn-{{ $model->status ? 'success' : 'danger' }} px-2 py-1">

                                        {{ $model->status ? 'Active' : 'Inactive' }}

                                    </button>

                                </form>

                            </td>

                            <td class="text-center">
                                {{ optional($model->created_at)->format('d M, Y') }}
                            </td>

                            <td class="text-center">

                                @if ($model->created_at->equalTo($model->updated_at))
                                    <span class="text-danger">
                                        Model not updated yet
                                    </span>
                                @else
                                    {{ $model->updated_at->format('d M, Y') }}
                                @endif

                            </td>

                            <td class="text-center">

                                <button type="button" class="btn btn-outline-primary px-2 py-1" data-bs-toggle="modal"
                                    data-bs-target="#edit_product_model_Modal{{ $model->id }}">

                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Edit

                                </button>

                                <button type="button" class="btn btn-outline-danger px-2 py-1 deleteBtn ms-2"
                                    data-url="{{ route('admin.product_models.CRUD.destroy', $model->id) }}"
                                    onclick="openGlobalDeleteModal(this)">

                                    <i class="fa-regular fa-trash-can"></i>
                                    Delete

                                </button>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center text-danger">
                                No models found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

            <div class="d-flex justify-content-end mx-1">
                {{ $product_models->onEachSide(1)->links() }}
            </div>

        </div>
    </div>
</div>
