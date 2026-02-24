@foreach ($vendor_details as $vendor)
    <div class="modal fade" id="vendor_show_modal_{{ $vendor->id }}" tabindex="-1"
        aria-labelledby="vendorShowModalLabel{{ $vendor->id }}" aria-hidden="true" class="mt-0">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-shadow custom_modal_dialog mx-auto">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-secondary">
                    <button type="button" class="btn-close bg-danger btn-hover" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <!-- Modal Title -->
                <div class="text-center mt-2">
                    <h1 class="modal-heading h5">Show Single Vendor Info</h1>
                </div>

                <!-- Modal Body -->
                <div class="modal-body role_modal_body m-3 custom_modal_body">
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
                                    <li class="mb-2">{{ $vendor->name ?? 'N/A' }}</li>
                                    <li class="mb-2">{{ $vendor->email ?? 'N/A' }}</li>
                                    <li class="mb-2">{{ $vendor->phone ?? 'N/A' }}</li>
                                    <li class="mb-2">{{ $vendor->role ?? 'N/A' }}</li>

                                    <li class="mb-2">
                                        @if ($vendor->created_at)
                                            {{ $vendor->created_at->format('d/m/Y') }}
                                            <span
                                                class="text-info">{{ $vendor->created_at->setTimeZone('Asia/Dhaka')->format('h:i A') }}</span>
                                        @else
                                            <span class="text-danger">Data not found</span>
                                        @endif
                                    </li>

                                    <li>
                                        @if ($vendor->created_at == $vendor->updated_at)
                                            <span class="text-danger">Data not updated yet.</span>
                                        @else
                                            {{ $vendor->updated_at->format('d/m/Y') }}
                                            <span
                                                class="text-info">{{ $vendor->updated_at->setTimeZone('Asia/Dhaka')->format('h:i A') }}</span>
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
