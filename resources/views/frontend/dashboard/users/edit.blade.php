@extends('frontend.master')

@section('title', 'Pengguna')

@section('users', 'class=active')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('user.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Pengguna</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h4 class="text-info"><i class="fas fa-edit pr-2"></i>Edit Pengguna</h4>
                    </div>
                    <form action="{{ route('user.update', $user->id) }}" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="role_id">Hak Akses <span class="text-danger">*</span></label>
                                        <select name="role_id" class="form-control select2"
                                            data-placeholder="Pilih Hak Akses">
                                            <option></option>
                                            @foreach ($roles as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $user->role_id == $item->id ? 'selected':'' }}>{{ $item->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('role_id')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Nama <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" value="{{ $user->name }}"
                                            placeholder="Masukkan nama...">
                                        @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control" value="{{ $user->email }}"
                                            placeholder="Masukkan email...">
                                        @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="gender" class="d-block">Jenis Kelamin <span
                                                class="text-danger">*</span></label>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="male" name="gender" class="custom-control-input"
                                                value="Male" {{ $user->gender == 'Pria' ? 'checked':'' }}>
                                            <label class="custom-control-label" for="male">Pria</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="female" name="gender" class="custom-control-input"
                                                value="Wanita" {{ $user->gender == 'Wanita' ? 'checked':'' }}>
                                            <label class="custom-control-label" for="female">Wanita</label>
                                        </div>
                                        @error('gender')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="phone_number">Nomor HP <span class="text-danger">*</span></label>
                                        <input type="text" name="phone_number" class="form-control"
                                            value="{{ $user->phone_number }}" placeholder="Masukkan nomor HP...">
                                        @error('phone_number')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="avatar">Avatar <span class="text-danger">*</span></label>
                                        <li class="media">
                                            <img class="mr-2 rounded-circle" src="{{ $user->avatar_link }}"
                                                alt="Generic placeholder image" width="80" height="80"
                                                style="object-fit: cover; object-position: 50% 0%;" id="previewImage">
                                            <div class="media-body">
                                                <input type="file" name="avatar" class="form-control" id="image">
                                                <small class="text-muted form-text">Format yang didukung JPG,PNG,SVG.
                                                    Maksimum
                                                    2MB</small>
                                                @error('avatar')
                                                <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </li>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-info"><i class="fas fa-save pr-2"></i>Perbarui</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-6">
                <div class="card card-warning">
                    <div class="card-header">
                        <h4 class="text-warning"><i class="fas fa-key pr-2"></i>Ganti Kata Sandi</h4>
                    </div>
                    <form action="{{ route('user.password') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <input type="hidden" name="user_id" value="{{ $user->id }}" readonly>
                            <div class="form-group">
                                <label for="old_password">Kata sandi lama <span class="text-danger">*</span></label>
                                <input type="password" name="old_password" class="form-control"
                                    placeholder="Masukkan kata sandi Anda..." autocomplete="current-password">
                                @error('old_password')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="new_password">Kata sandi baru <span class="text-danger">*</span></label>
                                <input type="password" name="new_password" class="form-control"
                                    placeholder="Minimal 8 karakter" autocomplete="new-password">
                                @error('new_password')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="new_password_confirmation">Konfirmasi kata sandi <span
                                        class="text-danger">*</span></label>
                                <input type="password" name="new_password_confirmation" class="form-control"
                                    placeholder="Ketik ulang kata sandi baru..." autocomplete="new-password">
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-warning"><i class="fas fa-key pr-2"></i>Ganti</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('.select2').select2();
        //preview image
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#previewImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#image").change(function () {
            readURL(this);
        });
    });

</script>
@endsection