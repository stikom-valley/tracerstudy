@foreach (['success','danger','info','warning'] as $message)
@if (Session::has('alert-'.$message))
<div class="alert alert-{{ $message }} alert-has-icon alert-dismissible show fade">
    <button class="close" data-dismiss="alert"><span>&times;</span></button>
    @if ($message == 'success')
    <div class="alert-icon"><i class="icon fas fa-check"></i></div>
    @elseif($message == 'danger')
    <div class="alert-icon"><i class="icon fas fa-ban"></i></div>
    @elseif($message == 'warning')
    <div class="alert-icon"><i class="icon fas fa-exclamation-triangle"></i></div>
    @elseif($message == 'info')
    <div class="alert-icon"><i class="icon fas fa-info"></i></div>
    @endif
    <div class="alert-body">
        {{ Session::get('alert-' . $message) }}
    </div>
</div>
@endif
@endforeach