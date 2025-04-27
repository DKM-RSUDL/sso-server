@extends('layouts.main')

@section('content')
    <div class="welcome-section">
        <div class="d-flex align-items-center">
            <img src="{{ asset('assets/icon/handshake.png') }}" alt="Welcome Icon">
            <div>
                <h4>WELCOME TO RSUD Langsa Single Sign On (SSO)</h4>
                <p>RSUD Langsa SSO is an integrated login system to streamline login process.</p>
            </div>
        </div>
        <button class="btn">Get Started <i class="bi bi-mortarboard-fill"></i></button>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-4">
            <div class="sidebar">
                <h5>Welcome</h5>
                <div class="profile-section">
                    @if (empty(auth()->user()->karyawan->FOTO))
                        <img src="{{ asset('assets/img/avatar.png') }}" alt="Profile Picture" class="rounded-circle">
                    @else
                        <img src="https://e-rsudlangsa.id/hrd/user/images/profil/{{ auth()->user()->karyawan->FOTO }}"
                            alt="Profile Picture" class="rounded-circle">
                    @endif
                    <p>{{ auth()->user()->karyawan->GELAR_DEPAN . ' ' . auth()->user()->karyawan->NAMA . ' ' . auth()->user()->karyawan->GELAR_BELAKANG }}
                    </p>
                </div>
                <div class="info-item">
                    <i class="bi bi-person"></i>
                    <span>Identity</span>
                    <span>{{ auth()->user()->kd_karyawan }}</span>
                </div>
                {{-- <div class="info-item">
                    <i class="bi bi-lock"></i>
                    <span>Token created at</span>
                    <span>April 24, 2025 22:34 WIB</span>
                </div> --}}
                <div class="info-item">
                    <i class="bi bi-heart"></i>
                    <span>Login expires at</span>
                    <span>{{ $loginExpiresAt }} WIB</span>
                </div>
            </div>
        </div>

        <!-- App Cards -->
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <div class="app-card">
                        <div class="content">
                            <img src="{{ asset('assets/img/logo-rsudlangsa.png') }}" alt="SIM Presensi Logo">
                            <div>
                                <h6>SIM Presensi</h6>
                                <p>Universitas Sumatera Utara</p>
                                <p>SIM Presensi adalah sistem yang mengatur presensi dan absensi setiap dosen dan
                                    pegawai.</p>
                            </div>
                        </div>
                        <button class="btn">Visit</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="app-card">
                        <div class="content">
                            <img src="{{ asset('assets/img/logo-rsudlangsa.png') }}" alt="SIM SDM Logo">
                            <div>
                                <h6>SIM SDM</h6>
                                <p>Universitas Sumatera Utara</p>
                                <p>SIM SDM adalah sistem untuk mengelola seluruh data sumber daya SDM universitas.
                                </p>
                            </div>
                        </div>
                        <button class="btn">Visit</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="app-card">
                        <div class="content">
                            <img src="{{ asset('assets/img/logo-rsudlangsa.png') }}" alt="Simkerma USU Logo">
                            <div>
                                <h6>Simkerma USU</h6>
                                <p>Universitas Sumatera Utara</p>
                                <p>Simkerma adalah sistem kerja sama di USU.</p>
                            </div>
                        </div>
                        <button class="btn">Visit</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="app-card">
                        <div class="content">
                            <img src="{{ asset('assets/img/logo-rsudlangsa.png') }}" alt="Survei USU Logo">
                            <div>
                                <h6>Survei USU</h6>
                                <p>Universitas Sumatera Utara</p>
                                <p>Survei USU adalah sebuah sistem untuk melaksanakan survei.</p>
                            </div>
                        </div>
                        <button class="btn">Visit</button>
                    </div>
                </div>
            </div>
            <div class="other-links">
                <p>Other Internal Links <i class="bi bi-grid-3x3-gap-fill"></i></p>
            </div>
        </div>
    </div>
@endsection
