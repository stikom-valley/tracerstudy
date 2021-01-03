@extends('frontend.master')

@section('title', 'Profile')

@section('users', 'class=active')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('user.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Profile</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Hi, {{ Auth()->user()->name }}</h2>
            <p class="section-lead">
                Ubah data dirimu disini!
            </p>
            <div class="row">
                <div class="col-12">
                    <div class="row mt-sm-4">
                        <div class="col-12 col-md-12 col-lg-5">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <img alt="image" src="../assets/img/avatar/avatar-1.png" class="rounded-circle"
                                            style="width: 148px">
                                    </div>
                                    <div class="font-weight-normal mb-3"> {{ Auth()->user()->name }}
                                        <div class="text-muted d-inline font-weight-normal">
                                            <div class="slash"></div> Web Developer
                                        </div>
                                    </div>
                                    <button class="btn btn-block btn-outline-info"><i class="fab fa-linkedin-in"></i>
                                        Sinkronisasi dengan LinkedIn</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-7">
                            <div class="card">
                                <form action="{{ route('profile.update') }}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="card-header">
                                        <h4 class="text-primary"><i class="fas fa-user"> &nbsp; &nbsp;</i>Ubah Data Diri
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Nama Lengkap</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ Auth()->user()->name }}" placeholder="Masukkan Nama" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{ Auth()->user()->email }}" placeholder="Masukkan Email" required>
                                        </div>
                                        <div class="form-group">
                                            <label>NIM</label>
                                            <input type="number" class="form-control" name="nim"
                                                value="{{ Auth()->user()->reg_number }}" placeholder="Masukkan NIM"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label>LinkedIn</label>
                                            <input type="text" class="form-control" name="linked_in"
                                                value="{{ Auth()->user()->linked_in }}"
                                                placeholder="Masukkan Link Profile Linkedin" required>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button class="btn btn-primary" type="submit">Ubah Data</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
@endsection
