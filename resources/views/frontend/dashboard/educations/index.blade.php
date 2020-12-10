@extends('frontend.master')

@section('title', 'Kelulusan')

@section('educations', 'class=active')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Kelulusan</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <h4 class="text-dark"><i class="fas fa-list pr-2"></i> Daftar Alumni</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>Tahun Lulus</th>
                                        <th>Jumlah Alumni</th>
                                        <th width="5%">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($educations as $item)
                                    <tr>
                                        <td>{{ $item->graduation_year }}</td>
                                        <td>{{ $item->total_user }}</td>
                                        <td class="text-center">
                                            <a href="#"
                                                class="btn btn-sm btn-secondary">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
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
    </div>
</section>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
    $("#table-1").dataTable();
    });

</script>
@endsection