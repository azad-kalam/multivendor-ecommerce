<!-- USER TABLE -->
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
        @if ($user_details->count() > 0)
            @foreach ($user_details as $user)
                <tr>
                    <td class="td-6 text-center">
                        {!! $user->id ?? '<span class="text-danger">ID not found</span>' !!}
                    </td>
                    <td class="td-15">
                        {!! $user->name ?? '<span class="text-danger">Name not found</span>' !!}
                    </td>
                    <td class="td-19">
                        {!! $user->email ?? '<span class="text-danger">Email not found</span>' !!}
                    </td>
                    <td class="td-12">
                        {!! $user->phone ?? '<span class="text-danger">Phone not found</span>' !!}
                    </td>
                    <td class="td-6 text-center">
                        {!! $user->role ?? '<span class="text-danger">Role not found</span>' !!}
                    </td>
                    <td class="td-15 text-center">
                        @if ($user->created_at)
                            {{ $user->created_at->format('d/m/Y') }}
                            <small style="color:#ff00ff">
                                {{ $user->created_at->setTimeZone('Asia/Dhaka')->format('h:i A') }}
                            </small>
                        @else
                            <span class="text-danger">Created date not found</span>
                        @endif
                    </td>
                    <td class="td-15 text-center">
                        @if ($user->created_at == $user->updated_at)
                            <span class="text-danger">Data not updated yet.</span>
                        @else
                            {{ $user->updated_at->format('d/m/Y') }}
                            <small style="color:#ff00ff">
                                {{ $user->updated_at->setTimeZone('Asia/Dhaka')->format('h:i A') }}
                            </small>
                        @endif
                    </td>

                    <td class="td-12 text-center text-md-start text-lg-center">
                        <button class="btn btn-outline-success px-1 py-0" data-bs-toggle="modal"
                            data-bs-target="#user_show_modal_{{ $user->id }}">
                            <i class="fa fa-eye"></i>
                        </button>

                        <button class="btn btn-warning btn-outline-info px-1 py-0 my-2 mx-md-1" data-bs-toggle="modal"
                            data-bs-target="#user_details_edit_modal_{{ $user->id }}">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>

                        <button class="btn btn-outline-danger px-1 py-0"
                            onclick="openGlobalDeleteModal('{{ route('admin.all_user.destroy', $user->id) }}')">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="8" class="text-center text-danger">No user data found.</td>
            </tr>
        @endif
    </tbody>
</table>

<div class="d-flex justify-content-end mt-4">
    {{ $user_details->links() }}
</div>
