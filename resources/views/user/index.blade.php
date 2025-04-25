@extends('layouts.main')

@section('content')
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p class="card-title m-0">Users List</p>
                    <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-lg"></i> Create
                    </a>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="user-datatable">
                            <thead>
                                <tr align="middle">
                                    <th>#</th>
                                    <th>EMPLOYEE CODE</th>
                                    <th>NAME</th>
                                    <th>SSO ROLE</th>
                                    <th>STATUS</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td align="middle">{{ $loop->iteration }}</td>
                                        <td>{{ $user->kd_karyawan }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->role->name ?? '-' }}</td>
                                        <td align="middle">
                                            @if (($user->karyawan->STATUS_PEG ?? 0) == 1)
                                                <span class="badge text-bg-success">Active</span>
                                            @else
                                                <span class="badge text-bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td align="middle">
                                            <a href="{{ route('user.edit', [encrypt($user->id)]) }}"
                                                class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                            <button type="button" class="btn btn-danger btn-sm btn-delete-user"
                                                data-bs-target="#deleteUserModal" data-id="{{ encrypt($user->id) }}"><i
                                                    class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteUserModalLabel">Delete User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('user.delete') }}" method="post">
                    @csrf
                    @method('delete')

                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <p class="fw-bold">Are you sure you want to delete this user? Once deleted the data cannot be
                            restored.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        new DataTable('#user-datatable');

        $(document).on('click', '.btn-delete-user', function() {
            let $this = $(this);
            let target = $this.attr('data-bs-target');
            let id = $this.attr('data-id');

            $(target).find('#id').val(id);
            $(target).modal('show');
        });
    </script>
@endpush
