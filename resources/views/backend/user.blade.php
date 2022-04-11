@extends('admin.admin_master')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <div class="d-md-flex flex-row justify-content-between">
                <h3 class="box-title">User List</h3>
                <button type="button" class="btn btn-rounded btn-success" data-toggle="modal" onclick="add()"
                    data-target="#modal-default">
                    <i data-feather="plus"></i> Add
                </button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <form action="javascript:void(0)" class="form-inline ml-md-3 mb-md-3" id="FilterForm">
                <div class="form-group mr-md-3">
                    <label for="filter_role">User Role</label>
                    <select class="form-control" id="filter_role" name="filter_role" style="max-width: 200px">
                        <option value="">All User Role</option>
                        @foreach ($user_role as $role)
                            <option value="{{ $role }}">
                                {{ ucfirst(implode(' ', explode('_', $role))) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mr-md-3">
                    <label for="filter_active">User Active</label>
                    <select class="form-control" id="filter_active" name="filter_active" style="max-width: 200px">
                        <option value="">All User Active</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-rounded btn-md btn-info" title="Refresh Filter Table">
                    <i data-feather="refresh-cw" style="width: 15px; height: 15px; margin-right: 4px"></i> Refresh
                </button>
            </form>
            <div class="table-responsive">
                <table id="tbl_main" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>User Role</th>
                            <th>Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
    <!-- modal Area -->
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded15 bg-success">
                <div class="modal-header">
                    <h4 class="modal-title text-light" id="modal-default-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0)" id="UserForm" name="UserForm" class="form-horizontal" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name"
                                required="" />

                        </div>
                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email Address"
                                required="" />
                            <div class="help-block"></div>
                        </div>
                        <div class="form-group ">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="password" name="password"
                                placeholder="Enter Password" required="">
                        </div>
                        <div class="form-group">
                            <label for="role">User Role</label>
                            <select class="form-control" style="width: 100%;" required="" id="role" name="role">
                                @foreach ($user_role as $role)
                                    <option value="{{ $role }}">
                                        {{ ucfirst(implode(' ', explode('_', $role))) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="active">Active</label>
                            <select class="form-control" style="width: 100%;" required="" id="active" name="active">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-danger" data-dismiss="modal">
                        <li class="fa fa-times "></li> Close
                    </button>
                    <button type="submmit" class="btn btn-rounded btn-primary float-right" id="btn-save" form="UserForm">
                        <li class="fa fa-save mr-1"></li> Save changes
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content rounded15">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-delete-title">Delete Form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Delete Record</p>
                    <form action="javascript:void(0)" id="deleteForm" name="deleteForm" class="form-horizontal"
                        method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="delete_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-danger" data-dismiss="modal">
                        <li class="fa fa-times "></li> Close
                    </button>
                    <button type="submmit" class="btn btn-rounded btn-primary float-right" id="btn-save-delete"
                        form="deleteForm">
                        <li class="fa fa-trash mr-1"></li> Delete
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection

@section('javascript')
    <script src="{{ asset('backend/assets/vendor_components/datatable/datatables.min.js') }}"></script>
    {{-- <script src="{{ asset('backend/js/pages/validation.js') }}"></script> --}}
    {{-- <script src="{{ asset('backend/assets/vendor_components/select2/dist/js/select2.full.js') }}"></script> --}}

    <script>
        let errorAfterInput = [];
        $(document).ready(function() {

            // datatable ====================================================================================
            const table_html = $('#tbl_main');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const new_table = table_html.DataTable({
                searchDelay: 500,
                processing: true,
                serverSide: true,
                type: 'GET',
                ajax: {
                    url: "{{ route('admin.user') }}",
                    data: function(d) {
                        d['filter[active]'] = $('#filter_active').val();
                        d['filter[role]'] = $('#filter_role').val();
                    }
                },
                columns: [{
                        data: null,
                        name: 'id',
                        orderable: false,
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'role_str',
                        name: 'role'
                    },
                    {
                        data: 'active_str',
                        name: 'active',
                        render(data, type, full, meta) {
                            const class_el = full.active == 1 ? 'badge badge-success' :
                                'badge badge-danger';
                            return `<span class="${class_el}">${full.active_str}</span>`;
                        },
                    },
                    {
                        data: 'id',
                        name: 'id',
                        render(data, type, full, meta) {
                            return ` <button type="button" class="btn btn-rounded btn-primary btn-md" title="Edit Data"
                                data-id="${full.id}"
                                data-name="${full.name}"
                                data-email="${full.email}"
                                data-role="${full.role}"
                                data-active="${full.active}"
                                onClick="editFunc(this)">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                </button>
                                <button type="button" class="btn btn-rounded btn-danger btn-md" title="Delete Data" onClick="deleteFunc('${data}')">
                                <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                </button>
                                `;
                        },
                        orderable: false
                    },
                ],
                order: [
                    [1, 'asc']
                ]
            });

            new_table.on('draw.dt', function() {
                var PageInfo = table_html.DataTable().page.info();
                new_table.column(0, {
                    page: 'current'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1 + PageInfo.start;
                });
            });

            $('#FilterForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var oTable = table_html.dataTable();
                oTable.fnDraw(false);
            });

            // insertForm ===================================================================================
            $('#UserForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                setBtnLoading('#btn-save', 'Save Changes');
                resetErrorAfterInput();
                const route = ($('#id').val() == '') ? "{{ route('admin.user.store') }}" :
                    "{{ route('admin.user.update') }}";

                $.ajax({
                    type: "POST",
                    url: route,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $.toast({
                            heading: 'Success',
                            text: 'Data saved successfully',
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'success',
                            hideAfter: 3500,
                            stack: 6
                        });
                        $("#modal-default").modal('hide');
                        var oTable = table_html.dataTable();
                        oTable.fnDraw(false);
                    },
                    error: function(data) {
                        const res = data.responseJSON ?? {};
                        errorAfterInput = [];
                        for (const property in res.errors) {
                            errorAfterInput.push(property);
                            setErrorAfterInput(res.errors[property], `#${property}`);
                        }

                        $.toast({
                            heading: 'Failed',
                            text: res.message ?? 'Something went wrong',
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3500,
                            stack: 6
                        });
                    },
                    complete: function() {
                        setBtnLoading('#btn-save',
                            '<li class="fa fa-save mr-1"></li> Save changes',
                            false);
                    }
                });
            });

            $('#deleteForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                setBtnLoading('#btn-save-delete', 'Delete');
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('admin/user') }}/" + formData.get('id'),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(res) {
                        $.toast({
                            heading: 'Success',
                            text: 'Data deleted successfully',
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'success',
                            hideAfter: 3500,
                            stack: 6
                        });
                        var oTable = table_html.dataTable();
                        oTable.fnDraw(false);
                    },
                    error: function(data) {
                        $.toast({
                            heading: 'Failed',
                            text: 'Data failed to delete-delete',
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3500,
                            stack: 6
                        });
                    },
                    complete: function() {
                        setBtnLoading('#btn-save-delete',
                            '<li class="fa fa-trash mr-1"></li> Delete',
                            false);

                        $('#modal-delete').modal('hide');
                    }
                });
            });
        });

        function add() {
            $('#UserForm').trigger("reset");
            $('#modal-default-title').html("Add User");
            $('#modal-default').modal('show');
            $('#id').val('');
            resetErrorAfterInput();
            $('#password').attr('required', true);
        }


        function editFunc(datas) {
            const data = datas.dataset;
            $('#modal-default-title').html("Edit User");
            $('#modal-default').modal('show');
            $('#UserForm').trigger("reset");
            $('#id').val(data.id);
            $('#name').val(data.name);
            $('#email').val(data.email);
            $('#role').val(data.role);
            $('#active').val(data.active);
            $('#password').removeAttr('required');
        }

        function deleteFunc(id) {
            $('#delete_id').val(id);
            $('#modal-delete').modal('show');
        }

        function setErrorAfterInput(error, element) {
            // get element after input
            let after = $(element).next();
            if (after.length == 0) $(element).after('<div></div>');
            if (after.length == 0) after = $(element).next();

            // highlight
            $(element).addClass("is-invalid").removeClass("is-valid");
            let errors = Array.isArray(error) ? '' : `<li class="text-danger">${error}</li>`;
            if (Array.isArray(error)) {
                error.forEach(err => {
                    errors += `<li class="text-danger">${err}</li>`;
                });
            }

            after.html(`<div><ul style="padding-left: 20px;">${errors}</ul></div>`);
        }

        function resetErrorAfterInput() {
            errorAfterInput.forEach(id => {
                // get element after input
                const element = $(`#${id}`);
                let after = $(element).next();
                if (after.length == 0) $(element).after('<div></div>');
                if (after.length == 0) after = $(element).next();
                $(element).addClass("is-valid").removeClass("is-invalid");
                after.html('');
            });
        }
    </script>
@endsection
@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor_components/datatable/datatables.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('backend/assets/vendor_components/select2/dist/css/select2.min.css') }}"> --}}
@endsection
