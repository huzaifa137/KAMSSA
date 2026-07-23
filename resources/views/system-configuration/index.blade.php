@extends('layouts-side-bar.master')

@section('content')

    <style>
        .swal2-container {
            z-index: 20000 !important;
        }

        .modal {
            z-index: 10500;
        }

        .modal-backdrop {
            z-index: 10400;
        }

        .sc-logo-preview {
            max-height: 70px;
            max-width: 180px;
            object-fit: contain;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 4px;
        }

        .level-chip {
            display: inline-flex;
            align-items: center;
            background: #f1f1fa;
            border-radius: 20px;
            padding: 4px 10px;
            margin: 3px;
            font-size: 13px;
        }

        .level-chip .short-code {
            font-weight: bold;
            color: #026837;
            margin-right: 6px;
        }

        .level-chip a {
            margin-left: 6px;
            color: #999;
        }

        .level-chip a:hover {
            color: #d33;
        }
    </style>

    <div class="side-app">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- ============================================================= --}}
        {{-- SYSTEM IDENTITY / BRANDING --}}
        {{-- ============================================================= --}}
        <div class="card mb-4">
            <div class="card-header text-white d-flex justify-content-between align-items-center"
                style="background-color:#026837;">
                <h4 class="card-title mb-0">
                    <i class="fas fa-cogs mr-2"></i>
                    System Configuration &mdash; Identity &amp; Branding
                </h4>
            </div>

            <div class="card-body bg-light">

                <p class="text-muted">
                    This is what a new client changes when this system is handed over to them
                    &mdash; the name, acronym, logo and contact details update automatically on
                    every page, dropdown, certificate and email in the system.
                </p>

                <form action="{{ route('system-configuration.settings.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>System / Examination Body Name <span class="text-danger">*</span></label>
                            <input type="text" name="system_name" class="form-control"
                                value="{{ old('system_name', $settings->system_name) }}"
                                placeholder="e.g. Kampala Integrated Secondary Schools Examination Bureau" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Acronym / Short Name <span class="text-danger">*</span></label>
                            <input type="text" name="short_name" class="form-control"
                                value="{{ old('short_name', $settings->short_name) }}" placeholder="e.g. KAMSSA"
                                required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Name (Arabic)</label>
                            <input type="text" name="system_name_ar" class="form-control"
                                value="{{ old('system_name_ar', $settings->system_name_ar) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Tagline</label>
                            <input type="text" name="tagline" class="form-control"
                                value="{{ old('tagline', $settings->tagline) }}"
                                placeholder="A short line shown under the name on the public site">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control"
                                value="{{ old('phone', $settings->phone) }}">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $settings->email) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control"
                                value="{{ old('address', $settings->address) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Website</label>
                            <input type="text" name="website" class="form-control"
                                value="{{ old('website', $settings->website) }}" placeholder="https://">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Logo</label><br>
                            <img src="{{ $settings->logo_url }}" class="sc-logo-preview mb-2" alt="Current logo"><br>
                            <input type="file" name="logo" class="form-control" accept="image/*">
                            <small class="text-muted">Used in the header, certificates and public site. PNG with
                                transparent background recommended.</small>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Favicon</label><br>
                            <img src="{{ $settings->favicon_url }}" class="sc-logo-preview mb-2" alt="Current favicon"><br>
                            <input type="file" name="favicon" class="form-control" accept="image/*">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Footer Text</label>
                            <textarea name="footer_text" class="form-control" rows="3">{{ old('footer_text', $settings->footer_text) }}</textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn text-white" style="background-color:#287C44;">
                        <i class="fas fa-save"></i> Save System Settings
                    </button>
                </form>
            </div>
        </div>

        {{-- ============================================================= --}}
        {{-- EXAMINATION CATEGORIES & LEVELS --}}
        {{-- ============================================================= --}}
        <div class="card mb-4">
            <div class="card-header text-white d-flex justify-content-between align-items-center"
                style="background-color:#026837;">
                <h4 class="card-title mb-0">
                    <i class="fas fa-layer-group mr-2"></i>
                    Examination Categories &amp; Levels
                </h4>
                <button class="btn btn-sm text-white" style="background-color:#287C44;" data-toggle="modal"
                    data-target="#addCategoryModal">
                    <i class="fas fa-plus"></i> Add Category
                </button>
            </div>

            <div class="card-body bg-light">

                <p class="text-muted">
                    An <strong>Examination Category</strong> is the top-level grouping (e.g. "Secondary Mock
                    Examination", "Primary Mock Examination", "Secondary Mock Examination"). Every
                    <strong>Examination Level</strong> added under a category (e.g. PLE, UCE,
                    UACE) automatically appears in every dropdown across the system &mdash; student registration,
                    grading, results, certificates, and reports.
                </p>

                @forelse ($categories as $category)
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center bg-white">
                            <div>
                                <strong>{{ $category->name }}</strong>
                                <span class="badge badge-secondary ml-2">{{ $category->code }}</span>
                                @if (!$category->is_active)
                                    <span class="badge badge-danger ml-1">Inactive</span>
                                @endif
                            </div>
                            <div>
                                <button class="btn btn-sm btn-outline-secondary edit-category-btn"
                                    data-id="{{ $category->id }}" data-name="{{ $category->name }}"
                                    data-code="{{ $category->code }}" data-name_ar="{{ $category->name_ar }}"
                                    data-description="{{ $category->description }}"
                                    data-sort_order="{{ $category->sort_order }}"
                                    data-is_active="{{ $category->is_active ? 1 : 0 }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button class="btn btn-sm btn-outline-primary add-level-btn"
                                    data-category-id="{{ $category->id }}" data-category-name="{{ $category->name }}">
                                    <i class="fas fa-plus"></i> Level
                                </button>

                                <form action="{{ route('system-configuration.categories.destroy', $category) }}"
                                    method="POST" style="display:inline-block;" class="delete-category-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger delete-category-btn">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="card-body">
                            @forelse ($category->levels as $level)
                                <span class="level-chip">
                                    <span class="short-code">{{ $level->short_code }}</span>
                                    {{ $level->name }}
                                    @if (!$level->is_active)
                                        <em class="text-danger">(inactive)</em>
                                    @endif

                                    <a href="#" class="edit-level-btn" data-id="{{ $level->id }}"
                                        data-name="{{ $level->name }}" data-name_ar="{{ $level->name_ar }}"
                                        data-short_code="{{ $level->short_code }}"
                                        data-description="{{ $level->description }}"
                                        data-sort_order="{{ $level->sort_order }}"
                                        data-is_active="{{ $level->is_active ? 1 : 0 }}"
                                        data-category-id="{{ $category->id }}" data-category-name="{{ $category->name }}"
                                        title="Edit level">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('system-configuration.levels.destroy', $level) }}"
                                        method="POST" style="display:inline-block;" class="delete-level-form">
                                        @csrf
                                        @method('DELETE')
                                        <a href="#" class="delete-level-btn" title="Delete level">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </form>
                                </span>
                            @empty
                                <span class="text-muted">No levels added to this category yet.</span>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        No examination categories configured yet. Click "Add Category" to get started
                        (e.g. Primary Mock Examination, Secondary Mock Examination).
                    </div>
                @endforelse

            </div>
        </div>

        <div class="text-center mb-4">
            <a href="{{ route('academic.years') }}" class="btn btn-outline-secondary">
                <i class="fas fa-calendar-alt"></i> Manage Academic / Examination Years
            </a>
        </div>
    </div>

    {{-- ============================================================= --}}
    {{-- ADD / EDIT CATEGORY MODAL --}}
    {{-- ============================================================= --}}
    <div class="modal fade" id="addCategoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="categoryForm" method="POST" action="{{ route('system-configuration.categories.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="categoryFormMethod" value="POST">

                    <div class="modal-header text-white" style="background-color:#026837;">
                        <h5 class="modal-title" id="categoryModalTitle">Add Examination Category</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Category Name</label>
                            <input type="text" name="name" id="category_name" class="form-control"
                                placeholder="e.g. Secondary Mock Examination" required>
                        </div>

                        <div class="form-group">
                            <label>Code</label>
                            <input type="text" name="code" id="category_code" class="form-control"
                                placeholder="e.g. SECONDARY_MOCK" required>
                        </div>

                        <div class="form-group">
                            <label>Name (Arabic)</label>
                            <input type="text" name="name_ar" id="category_name_ar" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" id="category_description" class="form-control"></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Sort Order</label>
                                <input type="number" name="sort_order" id="category_sort_order"
                                    class="form-control" value="0">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Status</label>
                                <select name="is_active" id="category_is_active" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn text-white" style="background-color:#287C44;">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ============================================================= --}}
    {{-- ADD / EDIT LEVEL MODAL --}}
    {{-- ============================================================= --}}
    <div class="modal fade" id="levelModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="levelForm" method="POST" action="{{ route('system-configuration.levels.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="levelFormMethod" value="POST">
                    <input type="hidden" name="examination_category_id" id="level_category_id">

                    <div class="modal-header text-white" style="background-color:#026837;">
                        <h5 class="modal-title" id="levelModalTitle">Add Examination Level</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <p class="text-muted" id="levelModalCategoryName"></p>

                        <div class="form-group">
                            <label>Level Name</label>
                            <input type="text" name="name" id="level_name" class="form-control"
                                placeholder="e.g. UACE (A-LEVEL)" required>
                        </div>

                        <div class="form-group">
                            <label>Short Code (used as the dropdown value)</label>
                            <input type="text" name="short_code" id="level_short_code" class="form-control"
                                placeholder="e.g. TH" required>
                        </div>

                        <div class="form-group">
                            <label>Name (Arabic)</label>
                            <input type="text" name="name_ar" id="level_name_ar" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" id="level_description" class="form-control"></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Sort Order</label>
                                <input type="number" name="sort_order" id="level_sort_order" class="form-control"
                                    value="0">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Status</label>
                                <select name="is_active" id="level_is_active" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn text-white" style="background-color:#287C44;">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
 </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {

            // ---------- CATEGORY: EDIT ----------
            $('.edit-category-btn').click(function () {
                $('#categoryModalTitle').text('Edit Examination Category');
                $('#categoryForm').attr('action', '{{ url('system-configuration/categories') }}/' + $(this).data('id'));
                $('#categoryFormMethod').val('PUT');

                $('#category_name').val($(this).data('name'));
                $('#category_code').val($(this).data('code'));
                $('#category_name_ar').val($(this).data('name_ar'));
                $('#category_description').val($(this).data('description'));
                $('#category_sort_order').val($(this).data('sort_order'));
                $('#category_is_active').val($(this).data('is_active') ? '1' : '0');

                $('#addCategoryModal').modal('show');
            });

            // Reset the "Add Category" form when the modal is opened fresh
            $('[data-target="#addCategoryModal"]').click(function () {
                $('#categoryModalTitle').text('Add Examination Category');
                $('#categoryForm').attr('action', '{{ route('system-configuration.categories.store') }}');
                $('#categoryFormMethod').val('POST');
                $('#categoryForm')[0].reset();
            });

            $('.delete-category-btn').click(function (e) {
                e.preventDefault();
                let form = $(this).closest('form');

                Swal.fire({
                    title: 'Delete this category?',
                    text: "All examination levels under it will be deleted too!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // ---------- LEVEL: ADD ----------
            $('.add-level-btn').click(function () {
                $('#levelModalTitle').text('Add Examination Level');
                $('#levelForm').attr('action', '{{ route('system-configuration.levels.store') }}');
                $('#levelFormMethod').val('POST');
                $('#levelForm')[0].reset();

                $('#level_category_id').val($(this).data('category-id'));
                $('#levelModalCategoryName').text('Category: ' + $(this).data('category-name'));

                $('#levelModal').modal('show');
            });

            // ---------- LEVEL: EDIT ----------
            $('.edit-level-btn').click(function (e) {
                e.preventDefault();

                $('#levelModalTitle').text('Edit Examination Level');
                $('#levelForm').attr('action', '{{ url('system-configuration/levels') }}/' + $(this).data('id'));
                $('#levelFormMethod').val('PUT');

                $('#level_category_id').val($(this).data('category-id'));
                $('#levelModalCategoryName').text('Category: ' + $(this).data('category-name'));
                $('#level_name').val($(this).data('name'));
                $('#level_short_code').val($(this).data('short_code'));
                $('#level_name_ar').val($(this).data('name_ar'));
                $('#level_description').val($(this).data('description'));
                $('#level_sort_order').val($(this).data('sort_order'));
                $('#level_is_active').val($(this).data('is_active') ? '1' : '0');

                $('#levelModal').modal('show');
            });

            $('.delete-level-btn').click(function (e) {
                e.preventDefault();
                let form = $(this).closest('form');

                Swal.fire({
                    title: 'Delete this level?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

        });
    </script>
@endsection
