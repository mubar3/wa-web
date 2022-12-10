@extends('master.master')

@section('attendanceActive','active')
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

                <form action="{{ url('/report/attendance/export') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-2">
                        <input type="text" name="tmulai" class="form-control tMulai" value="{{ $tMulai }}">
                    </div>

                    <div class="col-sm-2">
                        <select name="jabatan" id="jabatan" class="form-control select2">
                            <option value="">-- Semua Jabatan --</option>
                            @foreach ($jabatan as $item)
                                <option value="{{ $item->jabatan_id }}">{{ $item->jabatan_kode }}</option>
                            @endforeach
                        </select>
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

                    <div class="col-sm-4">
                        <button type="button" class="btn btn-sm btn-warning" onclick="getList()">GO</button>
                        <button type="button" class="btn btn-sm btn-default" onclick="resetList()"><i class="feather-rotate-ccw"></i></button>
                    </div>

                    @if (hakAksesMenu('attendance','print'))
                    <div class="col-sm-1">
                        <button type="submit" class="btn btn-sm btn-outline-success float-right">
                            Export
                        </button>
                    </div>
                    @endif
                </div>

                </form>

                <hr>

                {{-- <div class="table-responsive"> --}}
                    <table class="table table-hover table-bordered table-sm data-list">
                        <thead>
                            <tr>
                                <th>Region</th>
                                <th>area</th>
                                <th>supervisor</th>
                                <th>nik</th>
                                <th>nama</th>
                                <th>jbt</th>
                                @for ($i = 1; $i <= 31; $i++)
                                <th>{{ $i }}</th>
                                @endfor
                                <th>hk</th>
                                <th>sakit</th>
                                <th>cuti</th>
                                <th>izin</th>
                            </tr>
                        </thead>
                    </table>
                {{-- </div> --}}
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
    },
</style>

<script>
    getList();

    function resetList(){
        $('input[name="cari"]').val('');

        getList();
    }

    function filterTambahan(){
        $('#box_filter').toggle('slow');
    }

    function getList(){
        $('.data-list').DataTable({
            scrollY:        "380px",
            scrollX:        true,
            scrollCollapse: true,
            paging : false,
            fixedColumns:   {
                left: 6,
                right: 4
            },
            processing: true,
            serverSide: true,
            searching : false,
            lengthChange : false,
            pageLength  : 10,
            bDestroy: true,
            ajax: {
                url  : "/report/ajaxAttendance",
                type : "POST",
                data : function(d){
                    d._token = $("input[name=_token]").val();
                    d.tmulai = $('input[name="tmulai"]').val();
                    d.spv    = $('select[name="spv"]').val();
                    d.jabatan= $('select[name="jabatan"]').val();
                },
            },
            columns: [
                { data: 'region'},
                { data: 'area'},
                { data: 'spv'},
                { data: 'nik'},
                { data: 'nama'},
                { data: 'jabatan'},
                { data: 'tgl_1'},
                { data: 'tgl_2'},
                { data: 'tgl_3'},
                { data: 'tgl_4'},
                { data: 'tgl_5'},
                { data: 'tgl_6'},
                { data: 'tgl_7'},
                { data: 'tgl_8'},
                { data: 'tgl_9'},
                { data: 'tgl_10'},
                { data: 'tgl_11'},
                { data: 'tgl_12'},
                { data: 'tgl_13'},
                { data: 'tgl_14'},
                { data: 'tgl_15'},
                { data: 'tgl_16'},
                { data: 'tgl_17'},
                { data: 'tgl_18'},
                { data: 'tgl_19'},
                { data: 'tgl_20'},
                { data: 'tgl_21'},
                { data: 'tgl_22'},
                { data: 'tgl_23'},
                { data: 'tgl_24'},
                { data: 'tgl_25'},
                { data: 'tgl_26'},
                { data: 'tgl_27'},
                { data: 'tgl_28'},
                { data: 'tgl_29'},
                { data: 'tgl_30'},
                { data: 'tgl_31'},
                { data: 'hk'},
                { data: 'sakit'},
                { data: 'cuti'},
                { data: 'izin'},
            ],
            columnDefs: [
                {
                    targets: 37,
                    className: 'ijo'
                },
                {
                    targets: 38,
                    className: 'orange'
                },
                {
                    targets: 39,
                    className: 'biru'
                },
                {
                    targets: 40,
                    className: 'coklat'
                }
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
