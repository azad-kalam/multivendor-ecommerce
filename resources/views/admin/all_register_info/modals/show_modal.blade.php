<!--Show Modal starts here-->
@foreach ($all_register as $register)
    <div class="modal fade" id="register_show_modal_{{ $register->id }}" tabindex="-1"
        aria-labelledby="registerShowModalLabel{{ $register->id }}" aria-hidden="true" class="mt-0">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
            <div class="modal-content p-0">
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
                <div class="modal-body role_modal_body m-3">
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
                                    <li class="mb-2">{{ $register->name ?? 'N/A' }}</li>
                                    <li class="mb-2">{{ $register->email ?? 'N/A' }}</li>
                                    <li class="mb-2">{{ $register->phone ?? 'N/A' }}</li>
                                    <li class="mb-2">{{ $register->role ?? 'N/A' }}</li>

                                    <li class="mb-2">
                                        @if ($register->created_at)
                                            {{ $register->created_at->format('d/m/Y') }}
                                            <span class="text-info">{{ $register->created_at->format('h:i A') }}</span>
                                        @else
                                            <span class="text-danger">Data not found</span>
                                        @endif
                                    </li>

                                    <li>
                                        @if ($register->created_at == $register->updated_at)
                                            <span class="text-danger">Data not updated yet.</span>
                                        @else
                                            {{ $register->updated_at->format('d/m/Y') }}
                                            <span class="text-info">{{ $register->updated_at->format('h:i A') }}</span>
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
<!--Show Modal ends here-->
