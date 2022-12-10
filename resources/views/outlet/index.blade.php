@extends('master.master')

@section('outletActive','active')
@section('page_title', $title)

@section('konten')

      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <h6 class="card-header">
              {{ $title }}
              <div class="list-display">
                <a href="#" id="btn-on" class="btn-display" data-status="on"><i class="feather-eye"></i> Semua</a> |
                <a href="#" id="btn-off" class="btn-display" data-status="off"><i class="feather-trash-2"></i> Sampah</a>
              </div>
            </h6>
            <div class="card-body box_filter">
                @if (session()->has('pesan'))
                    {!! session('pesan') !!}
                @endif

                <div class="row">
                    <div class="col-sm-12">

                    </div>
                </div>

                <form action="{{ url('/outlet/export') }}" method="POST">
                @csrf
                <div class="row">
                    @if (session('cluster_id') == null)
                    <div class="col-sm-2">
                        <select name="cluster" class="form-control select2" id="cluster">
                            <option value="">--Cluster--</option>
                            @foreach ($cluster as $item)
                                <option value="{{ $item->cluster_id }}">{{ $item->cluster_nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="col-sm-2">
                        <select name="region" class="form-control select2" id="region">
                            <option value="">--Region--</option>
                            @foreach ($region as $item)
                                <option value="{{ $item->id }}">{{ $item->kode }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-2">
                        <select name="area" class="form-control select2" id="area" disabled>
                            <option value="">--Area--</option>
                        </select>
                    </div>

                    <div class="col-sm-2">
                        <input type="text" name="cari" class="form-control" placeholder="Cari outlet">
                    </div>

                    <div class="col-sm-4">
                        <a href="#" class="btn btn-sm btn-warning" onclick="getList()">GO</a>
                        <a href="#" class="btn btn-sm btn-default" onclick="reset()"><i class="feather-rotate-ccw"></i></a>
                    </div>
                    <div class="col-sm-2">
                        @if (hakAksesMenu('outlet','create'))
                        {!! xButton('/outlet/create', 'tambah_view') !!}
                        @endif

                        @if (hakAksesMenu('outlet','print'))
                        {!! xButton('', 'print') !!}
                        @endif
                    </div>
                </div>
                </form>

                <hr>

                <table class="table table-hover table-sm data-list">
                    <thead>
                        <tr>
                            <th width="20">no</th>
                            <th width="70">region</th>
                            <th width="70">area</th>
                            <th width="50">kode</th>
                            <th width="100">outlet</th>
                            <th width="400">alamat</th>
                            <th width="70"></th>
                        </tr>
                    </thead>
                </table>
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
    getList();

    function reset(){
        $('input[name="cari"]').val('');
        $('#region').val('').change();
        $('#area').val('').change();

        getList();
    }

    function getList(){
        $('.data-list').DataTable({
            processing: true,
            serverSide: true,
            searching : false,
            lengthChange : false,
            pageLength  : 10,
            bDestroy: true,
            ajax: {
                url  : "/ajaxOutlet",
                type : "POST",
                data : function(d){
                    d._token = $("input[name=_token]").val();
                    d.cari = $('input[name="cari"]').val();
                    d.status = $('input[name="_status"]').val();
                    d.region = $('select[name="region"]').val();
                    d.area = $('select[name="area"]').val();
                },
            },
            columns: [
                { data: 'nomor'},
                { data: 'region'},
                { data: 'area'},
                { data: 'kode'},
                { data: 'outlet'},
                { data: 'alamat'},
                { data: 'aksi'},
            ]
        });
    }

</script>
@endsection
