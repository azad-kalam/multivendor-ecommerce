<!-- ADMIN TABLE -->
<table class="table table-striped table-hover table-bordered text-sm-nowrap data-table">
    <thead id="table-head" class="border border-1 border-dark">
        <tr>
            <th class="td-6 px-1 text-center">ID</th>
            <th class="td-15 px-1">Name</th>
            <th class="td-19 px-1">Email</th>
            <th class="td-12 px-1">Phone</th>
            <th class="td-6 px-1 text-center">Role</th>
            <th class="td-15 px-1 text-center">Created</th>
            <th class="td-15 px-1 text-center">Updated</th>
            <th class="td-12 px-1 text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @if ($admin_details->count() > 0)
            @foreach ($admin_details as $admin)
                <tr>
                    <td class="td-6 text-center">
                        {!! $admin->id ?? '<span class="text-danger">ID not found</span>' !!}
                    </td>
                    <td class="td-15">
                        {!! $admin->name ?? '<span class="text-danger">Name not found</span>' !!}
                    </td>
                    <td class="td-19">
                        {!! $admin->email ?? '<span class="text-danger">Email not found</span>' !!}
                    </td>
                    <td class="td-12">
                        {!! $admin->phone ?? '<span class="text-danger">Phone not found</span>' !!}
                    </td>
                    <td class="td-6 text-center">
                        {!! $admin->role ?? '<span class="text-danger">Role not found</span>' !!}
                    </td>
                    <td class="td-15 text-center">
                        @if ($admin->created_at)
                            {{ $admin->created_at->format('d/m/Y') }}
                            <small class="text-muted">
                                {{ $admin->created_at->setTimeZone('Asia/Dhaka')->format('h:i A') }}
                            </small>
                        @else
                            <span class="text-danger">Created date not found</span>
                        @endif
                    </td>
                    <td class="td-15 text-center">
                        @if ($admin->created_at == $admin->updated_at)
                            <small class="text-danger">Data not updated yet.</small>
                        @else
                            {{ $admin->updated_at->format('d/m/Y') }}
                            <small class="text-muted">
                                {{ $admin->updated_at->setTimeZone('Asia/Dhaka')->format('h:i A') }}
                            </small>
                        @endif
                    </td>
                    <td class="td-12 text-center text-md-start text-lg-center">
                        <button class="btn btn-outline-success px-1 py-0" data-bs-toggle="modal"
                            data-bs-target="#admin_show_modal_{{ $admin->id }}">
                            <i class="fa fa-eye"></i>
                        </button>

                        <button class="btn btn-warning btn-outline-info px-1 py-0 my-2 mx-md-1" data-bs-toggle="modal"
                            data-bs-target="#admin_details_edit_modal_{{ $admin->id }}">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>

                        <button type="button" class="btn btn-outline-danger px-1 py-0 deleteBtn"
                            data-url="{{ route('admin.details.destroy', $admin->id) }}" data-bs-toggle="modal"
                            data-bs-target="#globalDeleteModal">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="8" class="text-center text-danger">No admin data found.</td>
            </tr>
        @endif
    </tbody>
</table>

<div class="d-flex justify-content-end mt-4">
    {{ $admin_details->links() }}
</div>
