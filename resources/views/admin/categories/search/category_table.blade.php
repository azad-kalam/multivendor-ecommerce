<table class="table table-striped table-hover table-bordered text-sm-nowrap data-table" id="categoryTable">
    <thead id="table-head" class="border border-1 border-dark">
        <tr>
            <th class="td-6 px-1">ID</th>
            <th class="td-15 px-1">Category <kbd class="pt-0">Name</kbd></th>
            <th class="td-19 px-1">Category <kbd class="pt-0">Title</kbd></th>
            <th class="td-28 px-1">Category <kbd class="pt-0">Description</kbd></th>
            <th class="td-15 px-1">Slug</th>
            <th class="td-5 px-1 text-center px-1">Status</th>
            <th class="td-12 px-1 text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @if ($allCategories->isNotEmpty())
            @foreach ($allCategories as $category)
                <tr>
                    <td class="td-6">{{ $category->id }}</td>
                    <td class="td-15">{{ $category->name }}</td>
                    <td class="td-19">{{ $category->title }}</td>
                    <td class="td-28">{{ $category->description }}</td>
                    <td class="td-15">{{ $category->slug }}</td>
                    <td class="text-center td-5">
                        @if ($category->status == 'active')
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
                        <a href="javascript:void(0);" class="showIcon" data-id="{{ $category->id }}"
                            data-bs-toggle="modal" data-bs-target="#showModal">
                            <button class="btn btn-outline-success px-1 py-0">
                                <i class="fa fa-eye"></i>
                            </button>
                        </a>

                        <a href="#" class="categoryOldShow editIcon" data-id="{{ $category->id }}"
                            data-bs-toggle="modal" data-bs-target="#categoryEditModal">
                            <button class="btn btn-warning btn-outline-info px-1 py-0 my-2 mx-md-1">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                        </a>


                        <a class="deletIcon" data-id="{{ $category->id }}">
                            <button class="btn btn-outline-danger px-1 py-0">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7" class="text-center text-danger">No Category Found</td>
            </tr>
        @endif
    </tbody>
</table>

<div class="pagination-container d-flex justify-content-end mt-4" id="categoryPagination">
    {{ $allCategories->onEachSide(1)->links() }}
</div>
