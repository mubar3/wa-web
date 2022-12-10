@extends('master.master')

@section('transaksiActive','active')
@section('page_title', $title)

@section('konten')

      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <h6 class="card-header">
              {{ $title }}
            </h6>
            <div class="card-body box_filter">
                @if (session()->has('pesan'))
                    {!! session('pesan') !!}
                @endif

                <form action="{{ url('/report/transaksi/export') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-2">
                        <input type="text" name="tmulai" class="form-control tMulai" value="{{ $tMulai }}">
                    </div>

                    @if (session('ma_id') == '' || session('ma_id') == null)
                    <div class="col-sm-3">
                        <select name="spv" id="spv" class="form-control select2">
                            <option value="">-- Semua TC --</option>
                            @foreach ($spv as $item)
                                <option value="{{ $item->userid }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="col-sm-6">
                        <button type="button" class="btn btn-sm btn-warning" onclick="getList()">GO</button>
                        <button type="button" class="btn btn-sm btn-default" onclick="resetList()"><i class="feather-rotate-ccw"></i></button>
                    </div>

                    @if (hakAksesMenu('transaksi','print'))
                    <div class="col-sm-1">
                        <button type="submit" class="btn btn-sm btn-outline-success float-right">
                            Export
                        </button>
                    </div>
                    @endif
                </div>


                </form>

                <hr>

                NW = NEW USER <br>
                FS = FIRST SUBMISSION <br>
                ST = STRUK
                <div class="table-responsive mt-3">
                    <table class="table table-hover table-bordered table-sm data-list">
                        <thead>
                            <tr>
                                <th rowspan="2">tc</th>
                                <th rowspan="2">NA</th>
                                <th rowspan="2">NIK</th>
                                <th rowspan="2">Periode</th>
                                @for ($i = 1; $i <= 31; $i++)
                                    <th colspan="3" style="text-align:center;">{{ $i }}</th>
                                @endfor
                                <th colspan="3">Total</th>
                            </tr>
                            <tr>
                                @for ($i = 1; $i <= 31; $i++)
                                    <th>Nw</th>
                                    <th>fs</th>
                                    <th>st</th>
                                @endfor
                                <th>NW</th>
                                <th>fs</th>
                                <th>st</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
          </div>
        </div>

      </div>

@endsection

@section('my-script')
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
{{-- <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script> --}}
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css"> --}}
<script src="https://cdn.datatables.net/fixedcolumns/4.0.2/js/dataTables.fixedColumns.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.11/dist/plugins/monthSelect/index.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.11/dist/plugins/monthSelect/style.css">

<style>
    table > thead > tr > th, table.dataTable.table-sm > tbody > tr > td{
        background: white;
    }
    .ijo{
        background:#4CAF50 !important;
        color: white !important;
    }
    .orange{
        background:#FFA726 !important;
        color: white !important;
    }
    .biru{
        background:#2196F3 !important;
        color: white !important;
    }
    .coklat{
        background:#795548 !important;
        color: white !important;
    }
    .dataTables_filter label input[type="search"]{
        border: 1px solid #999 !important;
        border-radius: 2px;
        margin-left: 5px;
        height: 30px;
        padding-left: 10px;
    }
</style>

<script>
    getList();

    function resetList(){
        $('select[name="status"]').val('').trigger('change');
        $('input[name="cari"]').val('');

        getList();
    }

    function getList(){
        $('.data-list').DataTable({
            fixedColumns:   {
                left: 4,
                // right: 4
            },
            scrollY:        "400px",
            scrollX:        true,
            scrollCollapse: true,
            paging : false,
            processing: true,
            serverSide: true,
            searching : true,
            lengthChange : false,
            pageLength  : 10,
            bDestroy: true,
            ajax: {
                url  : "/report/ajaxTransaksi",
                type : "POST",
                data : function(d){
                    d._token = $("input[name=_token]").val();
                    d.tmulai = $('input[name="tmulai"]').val();
                    d.spv    = $('select[name="spv"]').val();
                },
            },
            columns: [
                { data: 'spv'},
                { data: 'nama'},
                { data: 'nik'},
                { data: 'periode'},
                { data: 'new_1'},
                { data: 'tgl_1'},
                { data: 'str_1'},
                { data: 'new_2'},
                { data: 'tgl_2'},
                { data: 'str_3'},
                { data: 'new_3'},
                { data: 'tgl_3'},
                { data: 'str_3'},
                { data: 'new_4'},
                { data: 'tgl_4'},
                { data: 'str_4'},
                { data: 'new_5'},
                { data: 'tgl_5'},
                { data: 'str_5'},
                { data: 'new_6'},
                { data: 'tgl_6'},
                { data: 'str_6'},
                { data: 'new_7'},
                { data: 'tgl_7'},
                { data: 'str_7'},
                { data: 'new_8'},
                { data: 'tgl_8'},
                { data: 'str_8'},
                { data: 'new_9'},
                { data: 'tgl_9'},
                { data: 'str_9'},
                { data: 'new_10'},
                { data: 'tgl_10'},
                { data: 'str_10'},
                { data: 'new_11'},
                { data: 'tgl_11'},
                { data: 'str_11'},
                { data: 'new_12'},
                { data: 'tgl_12'},
                { data: 'str_12'},
                { data: 'new_13'},
                { data: 'tgl_13'},
                { data: 'str_13'},
                { data: 'new_14'},
                { data: 'tgl_14'},
                { data: 'str_14'},
                { data: 'new_15'},
                { data: 'tgl_15'},
                { data: 'str_15'},
                { data: 'new_16'},
                { data: 'tgl_16'},
                { data: 'str_16'},
                { data: 'new_17'},
                { data: 'tgl_17'},
                { data: 'str_17'},
                { data: 'new_18'},
                { data: 'tgl_18'},
                { data: 'str_18'},
                { data: 'new_19'},
                { data: 'tgl_19'},
                { data: 'str_19'},
                { data: 'new_20'},
                { data: 'tgl_20'},
                { data: 'str_20'},
                { data: 'new_21'},
                { data: 'tgl_21'},
                { data: 'str_21'},
                { data: 'new_22'},
                { data: 'tgl_22'},
                { data: 'str_22'},
                { data: 'new_23'},
                { data: 'tgl_23'},
                { data: 'str_23'},
                { data: 'new_24'},
                { data: 'tgl_24'},
                { data: 'str_24'},
                { data: 'new_25'},
                { data: 'tgl_25'},
                { data: 'str_25'},
                { data: 'new_26'},
                { data: 'tgl_26'},
                { data: 'str_26'},
                { data: 'new_27'},
                { data: 'tgl_27'},
                { data: 'str_27'},
                { data: 'new_28'},
                { data: 'tgl_28'},
                { data: 'str_28'},
                { data: 'new_29'},
                { data: 'tgl_29'},
                { data: 'str_29'},
                { data: 'new_30'},
                { data: 'tgl_30'},
                { data: 'str_30'},
                { data: 'new_31'},
                { data: 'tgl_31'},
                { data: 'str_31'},
                { data: 'total_nw'},
                { data: 'total_fs'},
                { data: 'total_st'},
            ]
        });
    }

    // Tanggal Flat
    flatpickr('.tMulai',{
        plugins: [
            new monthSelectPlugin({
                shorthand: true, //defaults to false
                dateFormat: "Y-m", //defaults to "F Y"
                // altFormat: "F Y", //defaults to "F Y"
            })
        ]
    });

</script>
@endsection
