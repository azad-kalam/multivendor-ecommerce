<div class="d-flex justify-content-end mb-2">
    <a class="btn btn-sm btn-outline-warning" data-bs-toggle="collapse" href="#all_register_list_Collapse">
        More Details ...
    </a>
</div>
<!-- REGISTER TABLE -->
<div class="row collapse" id="all_register_list_Collapse">
    <div class="col-md-12">
        <div class="table-responsive">
            <table
                class="table table-striped table-bordered border border-1 border-dark table-hover data-table text-sm-nowrap align-middle">
                <thead id="table-head" class="border border-1 border-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Address</th>
                        <th>Last Login Time</th>
                        <th>Last IP Address</th>
                        <th>Created</th>
                        <th>Updated</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($all_register as $register)
                        <tr class="text-center">
                            <td>
                                {{ $register->id }}
                            </td>

                            <td>
                                @if ($register->profile && $register->profile->address)
                                    {{ $register->profile->address }}
                                @else
                                    <small class="text-danger">Address not available</small>
                                @endif
                            </td>

                            <td>
                                @if ($register->last_login_time)
                                    {{ $register->last_login_time->format('d/m/Y') }}
                                    <b class="ms-2 text-muted">
                                        {{ $register->last_login_time->setTimeZone('Asia/Dhaka')->format('h:i A') }}
                                    </b>
                                @else
                                    <small class="text-danger">The user is not logged in yet.</small>
                                @endif
                            </td>

                            <td>
                                {{ $register->last_ip_address }}
                            </td>

                            <td>
                                @if ($register->created_at)
                                    {{ $register->created_at->format('d/m/Y') }}
                                    <small class="text-muted ms-2">
                                        {{ $register->created_at->setTimeZone('Asia/Dhaka')->format('h:i A') }}
                                    </small>
                                @else
                                    <small class="text-danger">Created date not found</small>
                                @endif
                            </td>

                            <td>
                                @if ($register->created_at == $register->updated_at)
                                    <small class="text-danger">Data not updated yet.</small>
                                @else
                                    {{ $register->updated_at->format('d/m/Y') }}
                                    <small class="text-muted ms-2">
                                        {{ $register->updated_at->setTimeZone('Asia/Dhaka')->format('h:i A') }}
                                    </small>
                                @endif
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
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover data-table text-sm-nowrap">
                <thead id="table-head" class="border border-1 border-dark">
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($all_register->count() > 0)
                        @foreach ($all_register as $register)
                            <tr class="text-center">

                                <td class="td-5">
                                    {!! $register->id ?? '<small class="text-danger">ID not found</small>' !!}
                                </td>

                                <td class="td-14">
                                    <div class="mx-auto d-flex align-items-center justify-content-center btn btn-outline-success p-1 border border-1 border-info rounded"
                                        style="width: 80px; height: 80px;">
                                        @if (
                                            $register->profile &&
                                                $register->profile->image &&
                                                $register->profile->image->public_path &&
                                                file_exists(public_path($register->profile->image->public_path)))
                                            <img src="{{ asset($register->profile->image->public_path) }}"
                                                class="h-100 w-100 rounded">
                                        @else
                                            <i class="fa-regular fa-circle-user text-danger fa-3x"></i>
                                        @endif
                                    </div>
                                </td>

                                <td class="td-15">
                                    {!! $register->name ?? '<small class="text-danger">Name not available</small>' !!}
                                </td>
                                <td class="td-15">
                                    {!! $register->email ?? '<small class="text-danger">Email not available</small>' !!}
                                </td>
                                <td class="td-15">
                                    {!! $register->phone ?? '<small class="text-danger">Phone not available</small>' !!}
                                </td>
                                <td class="td-12">
                                    {!! $register->role ?? '<small class="text-danger">Role not available</small>' !!}
                                </td>

                                <td class="td-12">
                                    <form action="{{ route('admin.user.status', $register->id) }}" method="POST">
                                        @csrf
                                        <button
                                            class="btn px-2 py-1 btn-{{ $register->status ? 'success' : 'danger' }}">
                                            {{ $register->status ? 'Active' : 'Inactive' }}
                                        </button>
                                    </form>
                                </td>

                                <td class="td-12 text-md-start text-lg-center">
                                    <button class="btn btn-outline-success px-1 py-0" data-bs-toggle="modal"
                                        data-bs-target="#register_show_modal_{{ $register->id }}">
                                        <i class="fa fa-eye"></i>
                                    </button>

                                    <button class="btn btn-warning btn-outline-info px-1 py-0 my-2 mx-md-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#register_edit_modal_{{ $register->id }}">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>

                                    <button type="button" class="btn btn-outline-danger px-1 py-0 deleteBtn"
                                        data-url="{{ route('admin.all_register_info.destroy', $register->id) }}"
                                        data-bs-toggle="modal" data-bs-target="#globalDeleteModal">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="text-center text-danger">Register data not available.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-4">
            {{ $all_register->links() }}
        </div>
    </div>
</div>
