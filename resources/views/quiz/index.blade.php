@extends('master.master')

@section('quizActive','active')
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
                    <div class="col-sm-2">
                        <input type="text" name="tmulai" class="form-control tMulai" value="{{ $tMulai }}">
                    </div>
                    <div class="col-sm-2">
                        <input type="text" name="takhir" class="form-control tAkhir" value="{{ $tAkhir }}">
                    </div>

                    {{-- <div class="col-sm-2">
                        <select name="jabatan[]" class="form-control select2" id="jabatan" multiple="multiple">
                            @foreach ($jabatan as $item)
                                <option value="{{ $item->jabatan_id }}">{{ $item->jabatan_kode }}</option>
                            @endforeach
                        </select>
                    </div> --}}

                    <div class="col-sm-3">
                        <select name="kategori" class="form-control select2" id="kategori">
                            <option value="">--Semua Kategori--</option>
                            <option value="Basic Nutrition Test">Basic Nutrition Test</option>
                            <option value="Product Knowledge Test">Product Knowledge Test</option>
                        </select>
                    </div>

                    <div class="col-sm-3">
                        <a href="#" class="btn btn-sm btn-warning" onclick="getList()">GO</a>
                        <a href="#" class="btn btn-sm btn-default" onclick="reset()"><i class="feather-rotate-ccw"></i></a>
                    </div>
                    <div class="col-sm-2">
                        @if (hakAksesMenu('quiz','create'))
                        {!! xButton('/quiz/create', 'tambah_view') !!}
                        @endif

                        {{-- @if (hakAksesMenu('outlet','print'))
                        {!! xButton('', 'print') !!}
                        @endif --}}
                    </div>
                </div>
                </form>

                <hr>

                <table class="table table-hover table-sm data-list">
                    <thead>
                        <tr>
                            <th width="10">no</th>
                            <th width="150">quiz</th>
                            <th width="10">periode</th>
                            <th width="10">bulan</th>
                            <th width="50">diperuntukan</th>
                            <th width="50">durasi</th>
                            <th width="70">mulai</th>
                            <th width="70">berakhir</th>
                            <th width="40"></th>
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

{{-- flatpicker --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
{{-- end flatpicker --}}

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

    function reset(){
        $('input[name="tmulai"]').val('{{ $tMulai }}');
        $('input[name="takhir"]').val('{{ $tAkhir }}');

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
                url  : "/ajaxQuiz",
                type : "POST",
                data : function(d){
                    d._token = $("input[name=_token]").val();
                    // d.cari = $('input[name="cari"]').val();
                    d.status = $('input[name="_status"]').val();
                    d.tmulai = $('input[name="tmulai"]').val();
                    d.takhir = $('input[name="takhir"]').val();
                    d.jabatan = $('select[name="jabatan[]"]').val();
                    d.kategori = $('select[name="kategori"]').val();
                    // d.area = $('select[name="area"]').val();
                },
            },
            columns: [
                { data: 'nomor'},
                { data: 'modul'},
                { data: 'tahun'},
                { data: 'bulan'},
                { data: 'jabatan_concat'},
                { data: 'duration'},
                { data: 'time_start'},
                { data: 'time_end'},
                { data: 'aksi'},
            ]
        });
    }

</script>
@endsection
