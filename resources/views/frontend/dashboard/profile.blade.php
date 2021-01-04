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
                                    <button class="btn btn-block btn-outline-info" id="linked_in"><i
                                            class="fab fa-linkedin-in"></i>
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
                                            <input type="text" class="form-control" name="linked_in" id="linked_in_id"
                                                value="{{ Auth()->user()->linked_in }}"
                                                placeholder="Masukkan Link Profile Linkedin">
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
        <div class="overlay"></div>
    </section>
@endsection

@section('style')
    <style>
        .overlay {
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 999;
            background: rgb(255, 255, 255) url("/assets/img/gif/loading.gif") center no-repeat;
        }

        /* Turn off scrollbar when body element has the loading class */
        body.loading {
            overflow: hidden;
        }

        /* Make spinner image visible when body element has the loading class */
        body.loading .overlay {
            display: block;
        }

    </style>

@endsection

@section('scripts')
    <script>
        $(document).on('click', '#linked_in', (event) => {
            event.preventDefault();
            let linked_in = $('#linked_in_id').val()

            if (!linked_in) {
                alert('data kosong')
            } else {
                console.log('work');
                $.ajax({
                    url: 'http://localhost:3000/api/linkedin',
                    type: 'POST',
                    data: {
                        linkedin: linked_in
                    },
                    dataType: 'JSON',
                    success: response => {
                        console.log(response.data);
                    },
                    error: error => {
                        console.error(error);
                    }
                })
            }

        })

        // Add remove loading class on body element depending on Ajax request status
        $(document).on({
            ajaxStart: function() {
                $("body").addClass("loading");
            },
            ajaxStop: function() {
                $("body").removeClass("loading");
            }
        });

    </script>
@endsection
