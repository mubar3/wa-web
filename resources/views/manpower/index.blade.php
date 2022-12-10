@extends('master.master')

@section('manpowerActive','active')
@section('page_title', $title)

@section('konten')
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <h6 class="card-header">
              {{ $title }}
              <div class="list-display"><a href="#" id="btn-on" class="btn-display" data-status="on"><i class="feather-eye"></i> Semua</a> | <a href="#" id="btn-off" class="btn-display" data-status="off"><i class="feather-trash-2"></i> Sampah</a></div>
            </h6>
            <div class="card-body box_filter">
                @if (session()->has('pesan'))
                    {!! session('pesan') !!}
                @endif

                <form action="{{ url('/manpower/export') }}" method="POST">
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
                            <select name="jabatan" class="form-control select2" id="jabatan">
                                <option value="">-- Jabatan --</option>
                                @foreach ($jabatan as $item)
                                    <option value="{{ $item->jabatan_id }}">{{ $item->jabatan_nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-2">
                            <input type="text" name="cari" class="form-control" placeholder="Cari Username / Nama">
                        </div>

                        <div class="col-sm-2">
                            <button type="button" class="btn btn-sm btn-warning" onclick="getList()">GO</button>
                            <button type="button" class="btn btn-sm btn-default" onclick="resetList()"><i class="feather-rotate-ccw"></i></button>
                        </div>

                        <div class="col-sm-1">
                            @if (hakAksesMenu('manpower','print'))
                            {!! xButton('', 'print') !!}
                            @endif
                        </div>

                        <div class="col-sm-1">
                            @if (hakAksesMenu('manpower','create'))
                            {!! xButton('/manpower/create', 'tambah_view') !!}
                            @endif
                        </div>
                    </div>
                </form>

                <hr>

                <table class="table table-hover table-sm data-list">
                    <thead>
                        <tr>
                            <th width="15">No.</th>
                            <th width="60">Cluster</th>
                            <th width="40">region</th>
                            <th width="80">area</th>
                            <th width="150">supervisor</th>
                            <th width="100">username</th>
                            <th width="50">id bp</th>
                            <th>nama</th>
                            <th width="">jabatan</th>
                            <th width="60"></th>
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

    function resetList(){
        $('select[name="cluster"]').val('').trigger('change');
        $('select[name="region"]').val('').trigger('change');
        $('select[name="area"]').val('').trigger('change');
        $('select[name="jabatan"]').val('').trigger('change');
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
                url  : "/ajaxManPower",
                type : "POST",
                data : function(d){
                    d._token = $("input[name=_token]").val();
                    d.cari = $('input[name="cari"]').val();
                    d.cluster = $('select[name="cluster"]').val();
                    d.region = $('select[name="region"]').val();
                    d.area = $('select[name="area"]').val();
                    d.jabatan = $('select[name="jabatan"]').val();
                    d.status = $('input[name="_status"]').val();
                },
            },
            columns: [
                { data: 'nomor'},
                { data: 'cluster'},
                { data: 'region'},
                { data: 'area'},
                { data: 'spv'},
                { data: 'username'},
                { data: 'bp_id'},
                { data: 'nama'},
                { data: 'jabatan'},
                { data: 'aksi'},
            ]
        });
    }
</script>
@endsection
