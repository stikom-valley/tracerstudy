@extends('frontend.master')

@section('title','Dashboard')

@section('dashboard', 'class=active')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Selamat Datang, {{ Auth::user()->name }}!</h1>
  </div>

  <div class="section-body">
  </div>
</section>
@endsection