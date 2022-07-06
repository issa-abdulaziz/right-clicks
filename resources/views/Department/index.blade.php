@extends('layout.app')
@section('content')
    <div class="containter mt-5 rounded bg-white p-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Departments</h3>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add_modal">
                Add new department
            </button>
        </div>
        @if (count($departments) > 0)
            <table class="table-striped table-hover table">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departments as $department)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $department->name }}</td>
                            <td class="text-right">
                                <button class="edit_btn btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#edit_modal" data-id="{{ $department->id }}"
                                    data-name="{{ $department->name }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('department.destroy', $department->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are You Sure To Delete!')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No Departments Added Yet</p>
        @endif
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="add_modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="add_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_modalLabel">Add Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('department.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="add_department_name" name="name"
                                placeholder="Name" required>
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
                    <h5 class="modal-title" id="edit_modalLabel">Edit Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    @method('put')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="edit_department_name" name="name"
                                placeholder="Name" required>
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
            $(document).on('click', '.edit_btn', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                $('#edit_department_name').val(name);
                $('#edit_modal form').attr('action', "{{ route('department.update', ['%id%']) }}"
                    .replace('%id%', id));
            });
        })
    </script>
@endpush
