@extends('master.master')

@section('detailActive','active')
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

                <form action="{{ url('/detail/export') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-sm-2">
                        <input type="text" name="tmulai" class="form-control tMulai" value="{{ $tMulai }}">
                    </div>
                    <div class="col-sm-2">
                        <input type="text" name="takhir" class="form-control tAkhir" value="{{ $tAkhir }}">
                    </div>

                    <div class="col-sm-3">
                        <input type="text" name="cari" class="form-control" placeholder="Cari Username / Nama">
                    </div>

                    <div class="col-sm-4">
                        <button type="button" class="btn btn-sm btn-warning" onclick="getList()">GO</button>
                        <button type="button" class="btn btn-sm btn-default" title="Filter tambahan" onclick="filterTambahan()"><i class="feather-filter"></i></button>
                        <button type="button" class="btn btn-sm btn-default" onclick="resetList()"><i class="feather-rotate-ccw"></i></button>
                    </div>

                    @if (hakAksesMenu('detail','print'))
                    <div class="col-sm-1">
                        {!! xButton('', 'print') !!}
                    </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-7">
                        <section id="box_filter" class="box_filter" style="margin:10px 0 0 0; display:none;">
                            <div class="card text-white bg-dark">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12"><h6 style="margin-bottom: 5px;">Filter Tambahan</h6></div>
                                        @if (session('cluster_id') == null)
                                        <div class="col-sm-4">
                                            <select name="cluster" class="form-control select2" id="cluster">
                                                <option value="">--Cluster--</option>
                                                @foreach ($cluster as $item)
                                                    <option value="{{ $item->cluster_id }}">{{ $item->cluster_nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif

                                        <div class="col-sm-4">
                                            <select name="region" class="form-control select2" id="region">
                                                <option value="">--Region--</option>
                                                @foreach ($region as $item)
                                                    <option value="{{ $item->id }}">{{ $item->kode }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-sm-4">
                                            <select name="area" class="form-control select2" id="area" disabled>
                                                <option value="">--Area--</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                </form>

                <hr>

                <table class="table table-hover table-sm data-list">
                    <thead>
                        <tr>
                            <th>username</th>
                            <th>nama</th>
                            <th>outlet</th>
                            <th>gambar</th>
                            <th>time open</th>
                            <th>durasi</th>
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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    getList();

    // Tanggal Flat
    flatpickr('.tMulai',{
        dateFormat: 'Y-m-d',
        monthSelectorType: 'static',
        onChange : function(selectedDates, dateStr, instance){
        updatetAkhir(dateStr);
        }
    });

    flatpickr('.tAkhir',{
        dateFormat: 'Y-m-d',
        monthSelectorType: 'static',
    });

    function updatetAkhir(tgl){
        var date = new Date(tgl);
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        var tanggal = formatDate(lastDay);
        $('.tAkhir').val(tanggal);
        $('.tAkhir').flatpickr(function(){
            defaultDate : ''+tanggal+''
        });
    }

    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }

    function filterTambahan(){
        $('#box_filter').toggle('slow');
    }

    function resetList(){
        $('select[name="cluster"]').val('').trigger('change');
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
                url  : "/ajaxDetail",
                type : "POST",
                data : function(d){
                    d._token = $("input[name=_token]").val();
                    d.cari = $('input[name="cari"]').val();
                    d.cluster = $('select[name="cluster"]').val();
                    d.region = $('select[name="region"]').val();
                    d.area = $('select[name="area"]').val();
                    d.jabatan = $('select[name="jabatan"]').val();
                    d.status = $('input[name="_status"]').val();
                    d.tmulai = $('input[name="tmulai"]').val();
                    d.takhir = $('input[name="takhir"]').val();
                },
            },
            columns: [
                { data: 'username'},
                { data: 'nama'},
                { data: 'outlet'},
                { data: 'gambar'},
                { data: 'time_open'},
                { data: 'durasi'},
            ]
        });
    }
</script>
@endsection
