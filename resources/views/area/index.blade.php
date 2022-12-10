@extends('master.master')

@section('areaActive','active')
@section('page_title', $title)

@section('konten')

      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <h6 class="card-header">
              {{ $title }}
            </h6>
            <div class="card-body">
                @if (session()->has('pesan'))
                    {!! session('pesan') !!}
                @endif

                <div class="row">
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-sm-4">
                                <input type="text" name="cari" class="form-control" placeholder="Cari Area">
                            </div>

                            <div class="col-sm-3">
                                <a href="#" class="btn btn-sm btn-warning" onclick="getList()">GO</a>
                                <a href="#" class="btn btn-sm btn-default" onclick="reset()"><i class="feather-rotate-ccw"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        @if (hakAksesMenu('area','create'))
                        {!! xButton('/area/create', 'tambah_view') !!}
                        @endif
                    </div>
                </div>

                <hr>

                <table class="table table-hover table-sm data-list">
                    <thead>
                        <tr>
                            <th>no</th>
                            <th>area</th>
                            <th>singkatan</th>
                            <th>status</th>
                            <th></th>
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
                url  : "/ajaxArea",
                type : "POST",
                data : function(d){
                    d._token = $("input[name=_token]").val();
                    d.cari = $('input[name="cari"]').val();
                },
            },
            columns: [
                { data: 'nomor'},
                { data: 'area'},
                { data: 'area_singkatan'},
                { data: 'status'},
                { data: 'aksi'},
            ]
        });
    }

</script>
@endsection
