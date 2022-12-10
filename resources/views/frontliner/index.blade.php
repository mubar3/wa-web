@extends('master.master')

@section('page_title', $title)

@section('konten')
<div class="content-i">
    <div class="content-box">
      <div class="row">
        <div class="col-sm-12">
          <div class="element-wrapper">
            <h6 class="element-header">
              {{ $title }}
            </h6>
            <div class="element-box">
                @if (session()->has('pesan'))
                    {!! session('pesan') !!}
                @endif

                <form action="{{ url('/report/exportFrontliner') }}" method="POST">
                @csrf
                <div class="row">
                        @if (session('tl_id') == NULL)
                        <div class="col-sm-2">
                            <select name="tl" class="form-control">
                                <option value="0">Semua TL</option>
                                @foreach ($getTL as $tl)
                                    <option value="{{ $tl->id }}">{{ $tl->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        @can('create', App\Models\ReportFrontliner::class)
                        <div class="col-sm-2">
                            <input type="submit" class="btn btn-outline-success" value="Export">
                        </div>
                        @endcan
                </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped data-list">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Nama Frontliner</th>
                                <th>OTP</th>
                                <th>Kode Outlet</th>
                                <th>Outlet</th>
                                <th>Area</th>
                                <th>Nama MD</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
          </div>
        </div>

      </div>
    </div>
</div>
@endsection

@section('my-script')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
<script>
    var data_list = $('.data-list').DataTable({
        processing: true,
        serverSide: true,
        searching : false,
        lengthChange : false,
        pageLength  : 10,
        bDestroy: true,
        ajax: {
            url  : "/report/ajaxFrontliner",
            type : "POST",
            data : function(d){
                d._token = $("input[name=_token]").val();
            },
        },
        columns: [
            { data: 'username'},
            { data: 'nama_fl'},
            { data: 'tipe_otp'},
            { data: 'outlet_kode'},
            { data: 'outlet_nama'},
            { data: 'area'},
            { data: 'nama_md'},
            { data: 'tanggal'},
            { data: 'jam'},
        ]
    });
</script>
@endsection
