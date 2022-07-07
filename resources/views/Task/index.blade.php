@extends('layout.app')
@push('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
    <div class="containter mt-5 rounded bg-white p-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Tasks</h3>
            @if ($is_admin)
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add_modal">
                    Add new task
                </button>
            @endif
        </div>
        @if (count($tasks) > 0)
            <table class="table-striped table-hover table">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Status Update At</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $task->name }}</td>
                            <td style="max-width: 220px;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;"
                                title="{{ $task->description }}">
                                {{ $task->description }}</td>
                            <td>
                                <button class="updateStatus_btn {{ $status_badge[$task->status]['class'] }} border-0"
                                    title="Click to update status" data-id="{{ $task->id }}"
                                    data-status="{{ $task->status }}" data-toggle="modal"
                                    data-target="#updateStatus_modal">{{ $status_badge[$task->status]['text'] }}</button>
                            </td>
                            <td>{{ $task->status_updated_at }}</td>
                            <td class="text-right">
                                <div class="dropdown d-inline">
                                    <button class="btn btn-info btn-sm dropdown-toggle" type="button" title="Teammates"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-users"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @forelse ($task->users as $user)
                                            <a class="dropdown-item" href="#">{{ $user->name }}</a>
                                        @empty
                                            <a class="dropdown-item" href="#">No users</a>
                                        @endforelse
                                    </div>
                                </div>
                                @if ($is_admin)
                                    <button class="edit_btn btn btn-primary btn-sm" title="Edit" data-toggle="modal"
                                        data-target="#edit_modal" data-id="{{ $task->id }}"
                                        data-name="{{ $task->name }}" data-description="{{ $task->description }}"
                                        data-status="{{ $task->status }}" data-users="{{ $task->users }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('task.destroy', $task->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete"
                                            onclick="return confirm('Are You Sure To Delete!')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No Tasks Added Yet</p>
        @endif
    </div>

    {{-- Update Status Modal --}}
    <div class="modal fade" id="updateStatus_modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="updateStatus_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateStatus_modalLabel">Update Task Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="updateStatus_task_status">Status</label>
                            <select class="form-control" id="updateStatus_task_status" name="status" required>
                                <option value="pended">Pended</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="canceled">Canceled</option>
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

    @if ($is_admin)
        <!-- Add Modal -->
        <div class="modal fade" id="add_modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="add_modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="add_modalLabel">Add task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('task.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="add_task_name">Name</label>
                                <input type="text" class="form-control" id="add_task_name" name="name"
                                    placeholder="Name" required>
                            </div>
                            <div class="form-group">
                                <label for="add_task_description">Description</label>
                                <textarea name="description" class="form-control" id="add_task_description" rows="2"
                                    placeholder="Description" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="add_task_status">Status</label>
                                <select class="form-control" id="add_task_status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="pended">Pended</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                    <option value="canceled">Canceled</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="add_task_users">users</label>
                                <select class="form-control" id="add_task_users" style="width: 100%" name="users[]"
                                    multiple required>
                                    @forelse ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @empty
                                        <option value="-1">No Users Added</option>
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
                        <h5 class="modal-title" id="edit_modalLabel">Edit task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST">
                        @method('put')
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="edit_task_name">Name</label>
                                <input type="text" class="form-control" id="edit_task_name" name="name"
                                    placeholder="Name" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_task_description">Description</label>
                                <textarea name="description" class="form-control" id="edit_task_description" rows="2"
                                    placeholder="Description" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="edit_task_status">Status</label>
                                <select class="form-control" id="edit_task_status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="pended">Pended</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                    <option value="canceled">Canceled</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="edit_task_users">users</label>
                                <select class="form-control" id="edit_task_users" style="width: 100%" name="users[]"
                                    multiple required>
                                    @forelse ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @empty
                                        <option value="-1">No Users Added</option>
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
    @endif
@endsection
@push('script')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('.table').DataTable({
                "columnDefs": [{
                        "orderable": false,
                        "targets": [-1]
                    },
                    {
                        "searchable": false,
                        "targets": [-1]
                    }
                ],
                "lengthMenu": [
                    [10, 25, -1],
                    [10, 25, "All"]
                ],
                "scrollY": "400px",
                "scrollCollapse": true,
                stateSave: true,
            });
        });
    </script>
@endpush

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#add_task_users').select2({
                placeholder: "Select an option",
                dropdownParent: $('#add_modal')
            });
            $('#edit_task_users').select2({
                placeholder: "Select an option",
                dropdownParent: $('#edit_modal')
            });
            $(document).on('click', '.edit_btn', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var description = $(this).data('description');
                var status = $(this).data('status');
                var users = $(this).data('users');
                $('#edit_task_name').val(name);
                $('#edit_task_description').val(description);
                $('#edit_task_status').val(status);
                $.each(users, function(index, user) {
                    $('#edit_task_users option[value=' + user.id + ']').attr('selected', true);
                });
                $('#edit_task_users').trigger('change');
                $('#edit_modal form').attr('action', "{{ route('task.update', ['%id%']) }}"
                    .replace('%id%', id));
            });

            $(document).on('click', '.updateStatus_btn', function() {
                var id = $(this).data('id');
                var status = $(this).data('status');
                $('#updateStatus_task_status').val(status);
                $('#updateStatus_modal form').attr('action',
                    "{{ route('task.update-status', ['%id%']) }}"
                    .replace('%id%', id));
            });
        })
    </script>
@endpush
