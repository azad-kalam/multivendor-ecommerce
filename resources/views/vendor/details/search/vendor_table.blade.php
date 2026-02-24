<!-- VENDOR TABLE -->
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
        <tr>
            <td class="td-6 text-center">
                {!! $vendor->id ?? '<small class="text-danger">ID not found</small>' !!}
            </td>
            <td class="td-15">
                {!! $vendor->name ?? '<small class="text-danger">Name not found</small>' !!}
            </td>
            <td class="td-19">
                {!! $vendor->email ?? '<small class="text-danger">Email not found</small>' !!}
            </td>
            <td class="td-12">
                {!! $vendor->phone ?? '<small class="text-danger">Phone not found</small>' !!}
            </td>
            <td class="td-6 text-center">
                {!! $vendor->role ?? '<small class="text-danger">Role not found</small>' !!}
            </td>
            <td class="td-15 text-center">
                @if ($vendor->created_at)
                    {{ $vendor->created_at->format('d/m/Y') }}
                    <small class="text-muted">
                        {{ $vendor->created_at->setTimeZone('Asia/Dhaka')->format('h:i A') }}
                    </small>
                @else
                    <span class="text-danger">Created date not found</span>
                @endif
            </td>
            <td class="td-15 text-center">
                @if ($vendor->created_at == $vendor->updated_at)
                    <span class="text-danger">Data not updated yet.</span>
                @else
                    {{ $vendor->updated_at->format('d/m/Y') }}
                    <small class="text-muted">
                        {{ $vendor->updated_at->setTimeZone('Asia/Dhaka')->format('h:i A') }}
                    </small>
                @endif
            </td>

            <td class="td-12 text-center text-md-start text-lg-center">
                <button class="btn btn-outline-success px-1 py-0" data-bs-toggle="modal"
                    data-bs-target="#show_vendor_details_modal_{{ $vendor->id }}">
                    <i class="fa fa-eye"></i>
                </button>

                <button class="btn btn-warning btn-outline-info px-1 py-0 my-2 mx-md-1" data-bs-toggle="modal"
                    data-bs-target="#edit_vendor_details_modal_{{ $vendor->id }}">
                    <i class="fa-regular fa-pen-to-square"></i>
                </button>

                <button type="button" class="btn btn-outline-danger px-1 py-0 deleteBtn"
                    data-url="{{ route('vendor.details.destroy', $vendor->id) }}" data-bs-toggle="modal"
                    data-bs-target="#globalDeleteModal">
                    <i class="fa-regular fa-trash-can"></i>
                </button>
            </td>
        </tr>
    </tbody>
</table>
<!-- END VENDOR TABLE -->
