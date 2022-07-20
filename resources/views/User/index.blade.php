@extends('layout.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1>
                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-success d-block ml-auto" data-toggle="modal" data-target="#add_modal">
                        Add new user
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @if (count($users) > 0)
                                <table class="datatable table table-striped table-hover nowrap" width="100%">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th data-hide-filter="true">#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Department</th>
                                            <th data-hide-filter="true" class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    <span
                                                        class="{{ $user->department->name == 'Not Set' ? 'badge badge-danger' : '' }}">
                                                        {{ $user->department->name }}
                                                    </span>
                                                </td>
                                                <td class="text-right">
                                                    <button class="reset_password_btn btn btn-warning btn-sm"
                                                        title="Reset Password" data-toggle="modal"
                                                        data-target="#reset_password_modal" data-id="{{ $user->id }}">
                                                        <i class="fa fa-key" aria-hidden="true"></i>
                                                    </button>
                                                    <button class="edit_btn btn btn-primary btn-sm" data-toggle="modal"
                                                        title="Edit" data-target="#edit_modal"
                                                        data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                                        data-email="{{ $user->email }}"
                                                        data-department_id="{{ $user->department_id ?? '0' }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete"
                                                            onclick="return confirm('Are You Sure To Delete!')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            @else
                                <p>No Users Added Yet</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

    <!-- Modals -->
    <!-- Add Modal -->
    <div class="modal fade" id="add_modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="add_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_modalLabel">Add user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="add_user_name">Name</label>
                            <input type="text" class="form-control" id="add_user_name" name="name" placeholder="Name"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="add_user_email">Email</label>
                            <input type="email" class="form-control" id="add_user_email" name="email"
                                placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <label for="add_user_password">Password</label>
                            <input type="password" class="form-control" id="add_user_password" name="password"
                                placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <label for="add_user_password_confirmation">Password</label>
                            <input type="password" class="form-control" id="add_user_password_confirmation"
                                name="password_confirmation" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <label for="add_user_department_id">Department</label>
                            <select class="form-control" id="add_user_department_id" style="width: 100%" name="department_id" required>
                                <option value="0">Select Department</option>
                                @forelse ($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="edit_modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="edit_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit_modalLabel">Edit user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    @method('put')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_user_name">Name</label>
                            <input type="text" class="form-control" id="edit_user_name" name="name"
                                placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_user_email">Email</label>
                            <input type="email" class="form-control" id="edit_user_email" name="email"
                                placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_user_department_id">Department</label>
                            <select class="form-control" id="edit_user_department_id" name="department_id" required>
                                <option value="0">Select Department</option>
                                @forelse ($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reset Password Modal -->
    <div class="modal fade" id="reset_password_modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="reset_password_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reset_password_modalLabel">Reset Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    @method('put')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="reset_user_password">Password</label>
                            <input type="password" class="form-control" id="reset_user_password" name="password"
                                placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <label for="reset_user_password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" id="reset_user_password_confirmation"
                                name="password_confirmation" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#add_user_department_id').select2({
                placeholder: "Select an option",
                dropdownParent: $('#add_modal')
            });
            $('#edit_user_department_id').select2({
                placeholder: "Select an option",
                dropdownParent: $('#edit_modal')
            });

            $(document).on('click', '.edit_btn', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var email = $(this).data('email');
                var department_id = $(this).data('department_id');
                $('#edit_user_name').val(name);
                $('#edit_user_email').val(email);
                $('#edit_user_department_id').val(department_id);
                $('#edit_modal form').attr('action', "{{ route('user.update', ['%id%']) }}"
                    .replace('%id%', id));
            });
            $(document).on('click', '.reset_password_btn', function() {
                var id = $(this).data('id');
                $('#reset_password_modal form').attr('action',
                    "{{ route('user.reset-password', ['%id%']) }}"
                    .replace('%id%', id));
            });
        })
    </script>
@endpush
