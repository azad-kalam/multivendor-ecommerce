@foreach ($user_details as $user)
    <div class="modal fade grow-modal" id="user_show_modal_{{ $user->id }}" tabindex="-1"
        aria-labelledby="userShowModalLabel{{ $user->id }}" aria-hidden="true" class="mt-0">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-shadow custom_modal_dialog mx-auto">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-secondary">
                    <button type="button" class="btn-close bg-danger btn-hover" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <!-- Modal Title -->
                <div class="text-center mt-2">
                    <h1 class="modal-heading h5">Show Single User Info</h1>
                </div>

                <!-- Modal Body -->
                <div class="modal-body role_modal_body custom_modal_body m-3">
                    <div class="container p-2 mt-2">
                        <div class="row">
                            <!-- Labels -->
                            <div class="col-sm-3">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><strong>Name:</strong></li>
                                    <li class="mb-2"><strong>Email:</strong></li>
                                    <li class="mb-2"><strong>Phone:</strong></li>
                                    <li class="mb-2"><strong>Role:</strong></li>
                                    <li class="mb-2"><strong>Created:</strong></li>
                                    <li><strong>Updated:</strong></li>
                                </ul>
                            </div>

                            <!-- Separator Icons -->
                            <div class="col-sm-1">
                                <ul class="list-unstyled mb-0 text-center">
                                    @for ($i = 0; $i < 6; $i++)
                                        <li class="mb-2"><i class="fa-solid fa-minus"></i></li>
                                    @endfor
                                </ul>
                            </div>

                            <!-- Values -->
                            <div class="col-sm-8">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">{{ $user->name ?? 'N/A' }}</li>
                                    <li class="mb-2">{{ $user->email ?? 'N/A' }}</li>
                                    <li class="mb-2">{{ $user->phone ?? 'N/A' }}</li>
                                    <li class="mb-2">{{ $user->role ?? 'N/A' }}</li>

                                    <li class="mb-2">
                                        @if ($user->created_at)
                                            {{ $user->created_at->format('d/m/Y') }}
                                            <span
                                                class="text-info">{{ $user->created_at->setTimeZone('Asia/Dhaka')->format('h:i A') }}</span>
                                        @else
                                            <span class="text-danger">Data not found</span>
                                        @endif
                                    </li>

                                    <li>
                                        @if ($user->created_at == $user->updated_at)
                                            <span class="text-danger">Data not updated yet.</span>
                                        @else
                                            {{ $user->updated_at->format('d/m/Y') }}
                                            <span
                                                class="text-info">{{ $user->updated_at->setTimeZone('Asia/Dhaka')->format('h:i A') }}</span>
                                        @endif
                                    </li>
                                </ul>
                            </div>
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
