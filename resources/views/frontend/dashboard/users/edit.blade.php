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
                    <form action="{{ route('user.update', $user->id) }}" method="post">
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
                                        <label for="reg_number">ID Pengguna <span class="text-danger">*</span></label>
                                        <input type="reg_number" name="reg_number" class="form-control"
                                            value="{{ $user->reg_number }}" placeholder="Masukkan ID Pengguna...">
                                        @error('reg_number')
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
    });

</script>
@endsection