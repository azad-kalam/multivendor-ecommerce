<div class="table-responsive" style="scrollbar-width: thin">
    <table class="table table-bordered table-hover text-sm-nowrap align-middle" id="subCategoryTable">
        <thead id="table-head" class="border border-1 border-dark">
            <tr>
                <th class="td-6 px-1">ID</th>
                <th class="td-15 px-1">Sub-category<kbd class="pt-0">Name</kbd></th>
                <th class="td-19 px-1">Sub-category <kbd class="pt-0">Title</kbd></th>
                <th class="td-28 px-1">Sub-category<kbd class="pt-0">Description</kbd></th>
                <th class="td-15 px-1">Slug</th>
                <th class="td-5 px-1 text-center">Status</th>
                <th class="td-12 px-1 text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($allSubcategories->isNotEmpty())
                @foreach ($allSubcategories as $subcategory)
                    <tr>
                        <td class="td-6">{{ $subcategory->id }}</td>
                        <td class="td-15">{{ $subcategory->subcategory_name }}
                            <ul class="list-group">
                                <li class="list-group-item p-1">
                                    <details>
                                        <summary class="text-sm text-secondary text-center">
                                            Category:
                                        </summary>
                                        <ul class="list-group">
                                            <li class="text-sm text-secondary list-group-item p-1 text-center">
                                                {{ $subcategory?->category->name ?? 'No Subcategory Found' }}
                                            </li>
                                        </ul>
                                    </details>
                                </li>
                            </ul>
                        </td>

                        @if ($subcategory->subcategory_title == null)
                            <td class="text-danger td-18">Title Empty</td>
                        @else
                            <td class="td-19">{{ $subcategory->subcategory_title }}</td>
                        @endif
                        @if ($subcategory->subcategory_description == null)
                            <td class="text-danger td-26">Description Empty</td>
                        @else
                            <td class="td-28">{{ $subcategory->subcategory_description }}</td>
                        @endif
                        <td class="td-15">{{ $subcategory->subcategory_slug }}</td>
                        <td class="text-center td-5">
                            @if ($subcategory->subcategory_status == 'active')
                                <span>
                                    <i class="fa-regular fa-circle-check text-success my-2" style="font-size: 25px"></i>
                                </span>
                            @else
                                <span>
                                    <i class="fa-regular fa-circle-xmark text-danger my-2" style="font-size: 25px"></i>
                                </span>
                            @endif
                        </td>
                        <td class="text-center text-md-start text-lg-center td-12">
                            <a href="#" class="subCatShowIcon" data-id="{{ $subcategory->id }}"
                                data-bs-toggle="modal" data-bs-target="#admin_show_SubCategory_modal">
                                <button class="btn btn-outline-success px-1 py-0">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </a>

                            <a href="#" class="subCatEditIcon" data-id="{{ $subcategory->id }}"
                                data-bs-toggle="modal" data-bs-target="#admin_edit_SubCategory_modal">
                                <button class="btn btn-warning btn-outline-info px-1 py-0 my-2 mx-md-1">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                            </a>

                            <a href="#" id="subCatDeleteIcon" class="subCatDeleteIcon"
                                data-id="{{ $subcategory->id }}">
                                <button class="btn btn-outline-danger px-1 py-0">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="text-center text-danger">No Data Found</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
<div id="subcategory-pagination" class="d-flex justify-content-end mt-4">
    {{ $allSubcategories->onEachSide(1)->links() }}
</div>
