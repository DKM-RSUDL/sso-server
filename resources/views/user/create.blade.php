@extends('layouts.main')

@section('content')
    <div class="row mt-5">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <p class="card-title m-0">Create User</p>
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

                    <div class="row">
                        <div class="col-12">
                            <form action="{{ route('user.store') }}" method="post">
                                @csrf

                                <div class="form-group">
                                    <label for="kd_karyawan">Employee</label>
                                    <select name="kd_karyawan" id="kd_karyawan" class="form-select select2" required>
                                        <option value="">--Employee--</option>

                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->KD_KARYAWAN }}">
                                                {{ "$employee->KD_KARYAWAN | $employee->GELAR_DEPAN $employee->NAMA $employee->GELAR_BELAKANG" }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mt-3">
                                    <label for="sso_role_id">SSO Role</label>
                                    <select name="sso_role_id" id="sso_role_id" class="form-select">
                                        <option value="">--Role--</option>

                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mt-3">
                                    <label for="password">Password</label>
                                    <input type="text" class="form-control" name="password" id="password" value="12345"
                                        required>
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    <a href="{{ route('user.index') }}" class="btn btn-secondary btn-sm">Batal</a>
                                    <button type="submit" class="btn btn-sm btn-primary ms-3">Create</button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
