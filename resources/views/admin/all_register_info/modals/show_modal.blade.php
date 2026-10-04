<!--Show Modal starts here-->
@foreach ($all_register as $register)
    <div class="modal fade" id="register_show_modal_{{ $register->id }}" tabindex="-1"
        aria-labelledby="registerShowModalLabel{{ $register->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="width: 400px; margin: auto;">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-secondary">
                    <button type="button" class="btn-close bg-danger btn-hover" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <!-- Modal Title -->
                <div class="text-center mt-2">
                    <h1 class="modal-heading h5">Show Single Register Info</h1>
                </div>

                <!-- Modal Body -->
                <div class="modal-body role_modal_body m-3" style="scroll-behavior: smooth; scrollbar-width: thin;">
                    <div class="container p-2 mt-2">
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle mb-0">
                                <tbody>

                                    <tr>
                                        <th style="width:120px;">Photo</th>
                                        <td style="width:20px;">:</td>
                                        <td>
                                            <div class="btn btn-outline-success border border-1 border-info rounded p-1"
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
                                    </tr>

                                    <tr>
                                        <th>Name</th>
                                        <td>:</td>
                                        <td>{{ $register->name ?? 'N/A' }}</td>
                                    </tr>

                                    <tr>
                                        <th>Email</th>
                                        <td>:</td>
                                        <td>{{ $register->email ?? 'N/A' }}</td>
                                    </tr>

                                    <tr>
                                        <th>Phone</th>
                                        <td>:</td>
                                        <td>{{ $register->phone ?? 'N/A' }}</td>
                                    </tr>

                                    <tr>
                                        <th>Role</th>
                                        <td>:</td>
                                        <td>{{ ucfirst($register->role) }}</td>
                                    </tr>

                                    <tr>
                                        <th>Created</th>
                                        <td>:</td>
                                        <td>
                                            @if ($register->created_at)
                                                {{ $register->created_at->format('d/m/Y') }}
                                                <span class="text-info">
                                                    {{ $register->created_at->format('h:i A') }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Updated</th>
                                        <td>:</td>
                                        <td>
                                            @if ($register->created_at == $register->updated_at)
                                                <span class="text-danger">Data not updated yet.</span>
                                            @else
                                                {{ $register->updated_at->format('d/m/Y') }}
                                                <span class="text-info">
                                                    {{ $register->updated_at->format('h:i A') }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer pt-1 border-0">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
<!--Show Modal ends here-->
