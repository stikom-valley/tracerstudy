<li @yield('users')>
    <a class="nav-link" href="{{ route('user.index') }}">
        <i class="fas fa-user"></i> <span>Pengguna</span>
    </a>
</li>
<li @yield('experiences')>
<a class="nav-link" href="{{route('experience.index')}}">
        <i class="fas fa-briefcase"></i> <span>Riwayat Pekerjaan</span>
    </a>
</li>
<li @yield('skills')>
<a class="nav-link" href="{{route('competence.index')}}">
        <i class="fas fa-compass"></i> <span>Kompetensi</span>
    </a>
</li>
<li @yield('questions')>
    <a class="nav-link" href="{{ route('question.index') }}">
        <i class="fas fa-comments"></i> <span>Kuisioner</span>
    </a>
</li>
<li @yield('faculties')>
    <a class="nav-link" href="{{ route('faculty.index') }}">
        <i class="fas fa-school"></i> <span>Fakultas</span>
    </a>
</li>
