@extends('master.master')

@section('pricingActive','active')
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

                <form action="{{ url('/report/pricing/export') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-2">
                        <input type="text" name="takhir" class="form-control tAkhir" value="{{ $tAkhir }}">
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

                    @if (hakAksesMenu('pricing','print'))
                    <div class="col-sm-1">
                        <button type="submit" class="btn btn-sm btn-outline-success float-right">
                            Export
                        </button>
                    </div>
                    @endif
                </div>
                <small>Data diambil 7 hari terakhir dari Tanggal yang dipilih</small>

                </form>

                <hr>

            <div class="row">
                <div class="col-sm-3">
                    <div style="width: 70px; height:20px; background:#FF7043; border:1px solid #999; display:inline-block;"></div>
                    <h6 style="margin-left:5px; display:inline-block; position:absolute;">Harga Promo</h6>
                </div>
            </div>

                <div class="table-responsive mt-3">
                    <table class="table table-hover table-bordered table-sm data-list">
                        <thead>
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Region</th>
                                <th rowspan="2">Area</th>
                                <th rowspan="2">Nama Store</th>
                                <th colspan="4" style="text-align: center;">Dancow 1+ Honey</th>
                                <th colspan="4" style="text-align: center;">Dancow 1+ Vanila</th>
                                <th colspan="2" style="text-align: center;">Dancow 1+ Choco</th>

                                <th colspan="4" style="text-align: center;">Dancow 3+ Honey</th>
                                <th colspan="3" style="text-align: center;">Dancow 3+ Vanila</th>
                                <th colspan="2" style="text-align: center;">Dancow 3+ Choco</th>

                                <th colspan="3" style="text-align: center;">Dancow 5+ Honey</th>
                                <th colspan="2" style="text-align: center;">Dancow 5+ Vanila</th>
                                <th colspan="3" style="text-align: center;">Dancow 5+ Choco</th>

                                <th colspan="4" style="text-align: center;">SGM 1+ Honey</th>
                                <th colspan="4" style="text-align: center;">SGM 1+ Vanila</th>
                                <th colspan="4" style="text-align: center;">SGM 3+ Honey</th>
                                <th colspan="3" style="text-align: center;">SGM 3+ Vanila</th>
                                <th colspan="2" style="text-align: center;">SGM 3+ Choco</th>
                                <th colspan="2" style="text-align: center;">SGM 5+ Honey</th>
                                <th colspan="2" style="text-align: center;">SGM 5+ Choco</th>

                                <th colspan="4" style="text-align: center;">Bebelove 1</th>
                                <th colspan="4" style="text-align: center;">Bebelove 2</th>
                                <th colspan="4" style="text-align: center;">Bebelac 3 Vanila</th>
                                <th colspan="5" style="text-align: center;">Bebelac 3 Honey</th>
                                <th colspan="4" style="text-align: center;">Bebelac 4 Vanila</th>
                                <th colspan="4" style="text-align: center;">Bebelac 4 Honey</th>
                                <th style="text-align: center;">Bebelac 4 Choco</th>

                                <th colspan="4" style="text-align: center;">Frisian Flag 123 Honey</th>
                                <th colspan="4" style="text-align: center;">Frisian Flag 123 Vanila</th>
                                <th colspan="2" style="text-align: center;">Frisian Flag 123 Choco</th>

                                <th colspan="4" style="text-align: center;">Frisian Flag 456 Honey</th>
                                <th colspan="3" style="text-align: center;">Frisian Flag 456 Vanila</th>
                                <th colspan="2" style="text-align: center;">Frisian Flag 456 Choco</th>
                            </tr>
                            <tr>
                                @php
                                    for($i=1; $i<=2; $i++){
                                @endphp
                                    {{-- Dancow 1+ --}}
                                    <th style="text-align: center;">200g</th>
                                    <th style="text-align: center;">400g</th>
                                    <th style="text-align: center;">800g</th>
                                    <th style="text-align: center;">1000g</th>
                                @php
                                    }
                                @endphp
                                <th style="text-align: center;">400g</th>
                                <th style="text-align: center;">800g</th>

                                {{-- Dancow 3+ Honey--}}
                                <th style="text-align: center;">200g</th>
                                <th style="text-align: center;">400g</th>
                                <th style="text-align: center;">800g</th>
                                <th style="text-align: center;">1000g</th>

                                {{-- Dancow 3+ Vanila--}}
                                <th style="text-align: center;">400g</th>
                                <th style="text-align: center;">800g</th>
                                <th style="text-align: center;">1000g</th>

                                {{-- Dancow 3+ Choco--}}
                                <th style="text-align: center;">400g</th>
                                <th style="text-align: center;">800g</th>

                                {{-- Dancow 5+ Honey--}}
                                <th style="text-align: center;">400g</th>
                                <th style="text-align: center;">800g</th>
                                <th style="text-align: center;">1000g</th>

                                {{-- Dancow 5+ Vanila--}}
                                <th style="text-align: center;">400g</th>
                                <th style="text-align: center;">800g</th>

                                {{-- Dancow 5+ Choco--}}
                                <th style="text-align: center;">400g</th>
                                <th style="text-align: center;">800g</th>
                                <th style="text-align: center;">1000g</th>


                                @php
                                    for($i=1; $i<=3; $i++){
                                @endphp
                                    {{-- SGM 1+ --}}
                                    <th style="text-align: center;">150g</th>
                                    <th style="text-align: center;">400g</th>
                                    <th style="text-align: center;">600g</th>
                                    <th style="text-align: center;">900g</th>
                                @php
                                    }
                                @endphp

                                {{-- SGM 3 --}}
                                <th style="text-align: center;">400g</th>
                                <th style="text-align: center;">600g</th>
                                <th style="text-align: center;">900g</th>
                                <th style="text-align: center;">400g</th>
                                <th style="text-align: center;">900g</th>

                                {{-- SGM 5 --}}
                                <th style="text-align: center;">400g</th>
                                <th style="text-align: center;">900g</th>
                                <th style="text-align: center;">400g</th>
                                <th style="text-align: center;">900g</th>

                                @php
                                for($i=1; $i<=2; $i++)
                                    {
                                @endphp
                                    {{-- BEBELOVE 1 --}}
                                    <th style="text-align: center;">200g</th>
                                    <th style="text-align: center;">400g</th>
                                    <th style="text-align: center;">800g</th>
                                    <th style="text-align: center;">1800g</th>
                                @php
                                    }
                                @endphp

                                {{-- BEBELAC 3 Vanila --}}
                                <th style="text-align: center;">400g</th>
                                <th style="text-align: center;">800g</th>
                                <th style="text-align: center;">1000g</th>
                                <th style="text-align: center;">1800g</th>

                                {{-- BEBELAC 3 Honey --}}
                                <th style="text-align: center;">200g</th>
                                <th style="text-align: center;">400g</th>
                                <th style="text-align: center;">800g</th>
                                <th style="text-align: center;">1000g</th>
                                <th style="text-align: center;">1800g</th>

                                @php
                                    for($i=1; $i<=2; $i++){
                                @endphp
                                    {{-- BEBELAC 4 --}}
                                    <th style="text-align: center;">400g</th>
                                    <th style="text-align: center;">800g</th>
                                    <th style="text-align: center;">1000g</th>
                                    <th style="text-align: center;">1800g</th>
                                @php
                                    }
                                @endphp

                                <th style="text-align: center;">400g</th>

                                {{-- FF  --}}
                                <th style="text-align: center;">150g</th>
                                <th style="text-align: center;">400g</th>
                                <th style="text-align: center;">800g</th>
                                <th style="text-align: center;">1200g</th>

                                {{-- FF  --}}
                                <th style="text-align: center;">400g</th>
                                <th style="text-align: center;">800g</th>
                                <th style="text-align: center;">1200g</th>

                                <th style="text-align: center;">400g</th>
                                <th style="text-align: center;">800g</th>

                                @php
                                    for($i=1; $i<=2; $i++){
                                @endphp
                                    {{-- FF 456 --}}
                                    <th style="text-align: center;">150g</th>
                                    <th style="text-align: center;">400g</th>
                                    <th style="text-align: center;">800g</th>
                                    <th style="text-align: center;">1200g</th>
                                @php
                                    }
                                @endphp

                                <th style="text-align: center;">400g</th>
                                <th style="text-align: center;">800g</th>

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
        $('select[name="spv"]').val('').trigger('change');
        $('input[name="cari"]').val('');

        getList();
    }

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

    function getList(){
        // console.log('data'+ Math.random());

        let dataList = $('.data-list').DataTable({
            fixedColumns:   {
                left: 4,
                // right: 4
            },
            scrollY:        "400px",
            scrollX:        true,
            scrollCollapse: false,
            paging : false,
            processing: true,
            serverSide: true,
            searching : false,
            lengthChange : false,
            pageLength  : 10,
            bDestroy: true,
            ajax: {
                url  : "/report/ajaxPricing",
                type : "POST",
                data : function(d){
                    d._token = $("input[name=_token]").val();
                    d.takhir = $('input[name="takhir"]').val();
                    d.spv    = $('select[name="spv"]').val();
                },
            },
            columns: [
                { data: 'nomor'},
                { data: 'region'},
                { data: 'area'},
                { data: 'outlet_nama'},
                { data: 'd1_Madu_200'},
                { data: 'd1_Madu_400'},
                { data: 'd1_Madu_800'},
                { data: 'd1_Madu_1000'},
                { data: 'd1_Vanila_200'},
                { data: 'd1_Vanila_400'},
                { data: 'd1_Vanila_800'},
                { data: 'd1_Vanila_1000'},
                { data: 'd1_Cokelat_400'},
                { data: 'd1_Cokelat_800'},
                { data: 'd3_Madu_200'},
                { data: 'd3_Madu_400'},
                { data: 'd3_Madu_800'},
                { data: 'd3_Madu_1000'},
                { data: 'd3_Vanila_400'},
                { data: 'd3_Vanila_800'},
                { data: 'd3_Vanila_1000'},
                { data: 'd3_Cokelat_400'},
                { data: 'd3_Cokelat_800'},
                { data: 'd5_Madu_400'},
                { data: 'd5_Madu_800'},
                { data: 'd5_Madu_1000'},
                { data: 'd5_Vanila_400'},
                { data: 'd5_Vanila_800'},
                { data: 'd5_Cokelat_400'},
                { data: 'd5_Cokelat_800'},
                { data: 'd5_Cokelat_1000'},
                { data: 'SGM_1_Madu_150'},
                { data: 'SGM_1_Madu_400'},
                { data: 'SGM_1_Madu_600'},
                { data: 'SGM_1_Madu_900'},
                { data: 'SGM_1_Vanila_150'},
                { data: 'SGM_1_Vanila_400'},
                { data: 'SGM_1_Vanila_600'},
                { data: 'SGM_1_Vanila_900'},
                { data: 'SGM_3_Madu_150'},
                { data: 'SGM_3_Madu_400'},
                { data: 'SGM_3_Madu_600'},
                { data: 'SGM_3_Madu_900'},
                { data: 'SGM_3_Vanila_400'},
                { data: 'SGM_3_Vanila_600'},
                { data: 'SGM_3_Vanila_900'},
                { data: 'SGM_3_Cokelat_400'},
                { data: 'SGM_3_Cokelat_900'},
                { data: 'SGM_5_Madu_400'},
                { data: 'SGM_5_Madu_900'},
                { data: 'SGM_5_Cokelat_400'},
                { data: 'SGM_5_Cokelat_900'},
                { data: 'Bebelove_1_200'},
                { data: 'Bebelove_1_400'},
                { data: 'Bebelove_1_800'},
                { data: 'Bebelove_1_1800'},
                { data: 'Bebelove_2_200'},
                { data: 'Bebelove_2_400'},
                { data: 'Bebelove_2_800'},
                { data: 'Bebelove_2_1800'},
                { data: 'Bebelac_3_Vanila_400'},
                { data: 'Bebelac_3_Vanila_800'},
                { data: 'Bebelac_3_Vanila_1000'},
                { data: 'Bebelac_3_Vanila_1800'},
                { data: 'Bebelac_3_Madu_200'},
                { data: 'Bebelac_3_Madu_400'},
                { data: 'Bebelac_3_Madu_800'},
                { data: 'Bebelac_3_Madu_1000'},
                { data: 'Bebelac_3_Madu_1800'},
                { data: 'Bebelac_4_Vanila_400'},
                { data: 'Bebelac_4_Vanila_800'},
                { data: 'Bebelac_4_Vanila_1000'},
                { data: 'Bebelac_4_Vanila_1800'},
                { data: 'Bebelac_4_Madu_400'},
                { data: 'Bebelac_4_Madu_800'},
                { data: 'Bebelac_4_Madu_1000'},
                { data: 'Bebelac_4_Madu_1800'},
                { data: 'Bebelac_4_Cokelat_400'},
                { data: 'FF123_Honey_150'},
                { data: 'FF123_Honey_400'},
                { data: 'FF123_Honey_800'},
                { data: 'FF123_Honey_1200'},
                { data: 'FF123_Vanila_150'},
                { data: 'FF123_Vanila_400'},
                { data: 'FF123_Vanila_800'},
                { data: 'FF123_Vanila_1200'},
                { data: 'FF123_Choco_400'},
                { data: 'FF123_Choco_800'},
                { data: 'FF456_Honey_150'},
                { data: 'FF456_Honey_400'},
                { data: 'FF456_Honey_800'},
                { data: 'FF456_Honey_1200'},
                { data: 'FF456_Vanila_400'},
                { data: 'FF456_Vanila_800'},
                { data: 'FF456_Vanila_1200'},
                { data: 'FF456_Choco_400'},
                { data: 'FF456_Choco_800'},
            ]
        });

        // return false;
    }

</script>
@endsection
