@extends('master.master')

@section('sesiActive','active')
@section('page_title', $title)

@section('konten')

    <div style="margin-bottom: 10px">
        <div class="row">
            <div class="col-md-4 stretch-card grid-margin grid-margin-md-0">
                <div class="card">
                  <div class="card-body">
                    <h5 class="text-center text-uppercase mt-3 mb-4">Total</h5>
                    <h2 class="text-center" style="color: #1600d6;"><i class="feather-users"></i></h2>
                    <h3 class="text-center font-weight-light" id="user_total">0</h3>
                  </div>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin grid-margin-md-0">
                <div class="card">
                  <div class="card-body">
                    <h5 class="text-center text-uppercase mt-3 mb-4">Aktif</h5>
                    <h2 class="text-center" style="color: green;"><i class="feather-user-check"></i></h2>
                    <h3 class="text-center font-weight-light" id="user_aktif">0</h3>
                  </div>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin grid-margin-md-0">
                <div class="card">
                  <div class="card-body">
                    <h5 class="text-center text-uppercase mt-3 mb-4">Off</h5>
                    <h2 class="text-center" style="color: #d40b0b;"><i class="feather-user-x"></i></h2>
                    <h3 class="text-center font-weight-light" id="user_off">0</h3>
                  </div>
                </div>
            </div>
        </div>
    </div>

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

                <div class="row box_filter">
                    @if (session('cluster_id') == '' || session('cluster_id') == null)
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
                        <select name="status" class="form-control select2" id="status">
                            <option value="y">Aktif</option>
                            <option value="n">Logout</option>
                        </select>
                    </div>

                    <div class="col-sm-2">
                        <input type="text" name="cari" class="form-control" placeholder="Cari Username / Nama">
                    </div>

                    <div class="col-sm-2">
                        <button type="button" class="btn btn-sm btn-warning" onclick="getList()">GO</button>
                        <button type="button" class="btn btn-sm btn-default" onclick="reset()"><i class="feather-rotate-ccw"></i></button>
                    </div>
                </div>

                <hr>

                <table class="table table-hover table-sm data-list">
                    <thead>
                        <tr>
                            <th width="20">No.</th>
                            <th width="30">region</th>
                            <th width="150">area</th>
                            <th width="100">username</th>
                            <th>nama</th>
                            <th>jabatan</th>
                            <th>status</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
          </div>
        </div>

      </div>

      {{-- modal Maps --}}
      <div class="modal modal-maps" tabindex="-1">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">xxx</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="modal-foto"></div>
                        <h2 class="modal-nama" style="font-size:1.3rem; margin:5px 0; "></h2>
                        <div class="modal-alamat" style="font-size: .8rem; margin-bottom:10px;"></div>
                        <div class="modal-tanggal"></div>
                        <div class="modal-outlet"></div>
                    </div>
                    <div class="col-sm-9">
                        <div id="modal-maps" style="height: 500px"></div>
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
    getList();
    getDashboard();

    function reset(){
        $('select[name="cluster"]').val('').trigger('change');
        $('select[name="region"]').val('').trigger('change');
        $('select[name="area"]').val('').trigger('change');
        $('select[name="status"]').val('y').trigger('change');
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
                url  : "/ajaxSesi",
                type : "POST",
                data : function(d){
                    d._token = $("input[name=_token]").val();
                    d.cari = $('input[name="cari"]').val();
                    d.cluster = $('select[name="cluster"]').val();
                    d.region = $('select[name="region"]').val();
                    d.area = $('select[name="area"]').val();
                    d.status = $('select[name="status"]').val();
                },
            },
            columns: [
                { data: 'nomor'},
                { data: 'kode'},
                { data: 'area'},
                { data: 'username'},
                { data: 'nama'},
                { data: 'jabatan'},
                { data: 'status'},
                { data: 'aksi'},
            ]
        });
    }

    function getDashboard(){
        $.ajax({
            type : 'GET',
            url  : '/getDashboard',
            success : function(msg){
                var data = msg.data;
                $('#user_total').text(data.user_total);
                $('#user_aktif').text(data.user_on);
                $('#user_off').text(data.user_off);
            }
        });
    }

</script>
@endsection
