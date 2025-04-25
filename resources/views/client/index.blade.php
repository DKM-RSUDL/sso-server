@extends('layouts.main')

@section('content')
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p class="card-title m-0">Clients/Apps List</p>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createClientModal">
                        <i class="bi bi-plus-lg"></i> Create
                    </button>
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
                        <table class="table table-bordered table-striped table-hover" id="client-datatable">
                            <thead>
                                <tr align="middle">
                                    <th>ClientID</th>
                                    <th>Name</th>
                                    <th>Redirect Uri</th>
                                    <th>Secret Key</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($clients as $client)
                                    <tr>
                                        <td>{{ $client->id }}</td>
                                        <td>{{ $client->name }}</td>
                                        <td>{{ $client->redirect }}</td>
                                        <td>{{ $client->secret }}</td>
                                        <td align="middle">
                                            <a href="#" class="btn btn-warning btn-sm btn-edit-client"
                                                data-bs-target="#editClientModal" data-id="{{ $client->id }}"
                                                data-name="{{ $client->name }}" data-redirect="{{ $client->redirect }}"><i
                                                    class="bi bi-pencil-square"></i></a>
                                            <a href="#" class="btn btn-danger btn-sm btn-delete-client"
                                                data-bs-target="#deleteClientModal" data-id="{{ $client->id }}"><i
                                                    class="bi bi-trash"></i></a>
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

    <!-- Create Modal -->
    <div class="modal fade" id="createClientModal" tabindex="-1" aria-labelledby="createClientModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createClientModalLabel">Create Client</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('client.store') }}" method="post">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Client Name</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="redirect_uri">Redirect Uri</label>
                            <input type="url" class="form-control" name="redirect_uri" id="redirect_uri" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="editClientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editClientModalLabel">Edit Client</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('client.update') }}" method="post">
                    @csrf
                    @method('put')

                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="name">Client Name</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="redirect_uri">Redirect Uri</label>
                            <input type="url" class="form-control" name="redirect_uri" id="redirect_uri" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteClientModal" tabindex="-1" aria-labelledby="deleteClientModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteClientModalLabel">Delete Client</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('client.delete') }}" method="post">
                    @csrf
                    @method('delete')

                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <p class="fw-bold">Are you sure you want to delete this client? Once deleted the data cannot be
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
        new DataTable('#client-datatable');

        $('.btn-edit-client').click(function() {
            let $this = $(this);
            let target = $this.attr('data-bs-target');
            let id = $this.attr('data-id');
            let name = $this.attr('data-name');
            let redirect = $this.attr('data-redirect');

            $(target).find('#id').val(id);
            $(target).find('#name').val(name);
            $(target).find('#redirect_uri').val(redirect);

            $(target).modal('show');
        });

        $('.btn-delete-client').click(function() {
            let $this = $(this);
            let target = $this.attr('data-bs-target');
            let id = $this.attr('data-id');

            $(target).find('#id').val(id);
            $(target).modal('show');
        });
    </script>
@endpush
