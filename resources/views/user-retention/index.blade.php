@extends('master.master')

@section('retentionActive','active')
@section('page_title', $title)

@section('konten')

    <div class="row">
        <div class="col-sm-12">
          <div class="card">
            {{-- <h6 class="card-header">
              New User & Retention
            </h6> --}}
            <div class="card-body box_filter">
                @if (session()->has('pesan'))
                    {!! session('pesan') !!}
                @endif

                <div class="row">
                    <div class="col-sm-1">
                        <label>Month : </label>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control select2" name="bulan">
                            <option value="01">[1] January</option>
                            <option value="02">[2] February</option>
                            <option value="03">[3] March</option>
                            <option value="04">[4] April</option>
                            <option value="05">[5] May</option>
                            <option value="06">[6] June</option>
                            <option value="07">[7] July</option>
                            <option value="08">[8] August</option>
                            <option value="09">[9] September</option>
                            <option value="10">[10] October</option>
                            <option value="11">[11] November</option>
                            <option value="12">[12] December</option>
                        </select>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-sm-1">
                        <label>Year : </label>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control select2" name="tahun">
                            <?= $tahun ?>
                        </select>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-1">
                        <button class="btn btn-sm btn-info" onclick="allReport(1)">
                            Submit
                        </button>
                    </div>
                    <div class="col-sm-1">
                        <button class="btn btn-sm btn-info" onclick="allReport(0)">
                            Submit M0
                        </button>
                    </div>
                    <div class="col-sm-1">
                        <button class="btn btn-sm btn-success" onclick="exportData()">
                            Export
                        </button>
                    </div>
                </div>

            </div>
          </div>
        </div>

    </div>

    <br>

    <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <h6 class="card-header">
              Report By Region
            </h6>
            <div class="card-body box_filter">
                <div class="table-responsive">
                <table class="table table-hover table-sm data-region">
                    <thead>
                        <tr>
                            <th rowspan="2" width="20">No</th>
                            <th rowspan="2">Region</th>
                            <th rowspan="2">#of BP</th>
                            <th colspan="4">New User</th>
                            <th colspan="2">M+1</th>
                            <th colspan="2">M+2</th>
                            <th colspan="2">M+3</th>
                            <th colspan="4">SKU</th>
                            <th rowspan="2">Subtotal Gramasi</th>
                        </tr>
                        <tr>
                            <th>Target</th>
                            <th>Actual Register</th>
                            <th>Actual Submission</th>
                            <th>%</th>
                            <th>Actual</th>
                            <th>%</th>
                            <th>Actual</th>
                            <th>%</th>
                            <th>Actual</th>
                            <th>%</th>
                            <th>200</th>
                            <th>400</th>
                            <th>800</th>
                            <th>1000</th>
                        </tr>
                    </thead>
                    <tfoot align="right">
                        <tr>
                            <th colspan="2"></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
                </div>
            </div>
          </div>
        </div>

    </div>

    <br>

    <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <h6 class="card-header">
              Report By Area
            </h6>
            <div class="card-body box_filter">
                <div class="table-responsive">
                <table class="table table-hover table-sm data-area">
                    <thead>
                        <tr>
                            <th rowspan="2" width="20">No</th>
                            <th rowspan="2">Kota</th>
                            <th rowspan="2">#of BP</th>
                            <th colspan="4">New User</th>
                            <th colspan="2">M+1</th>
                            <th colspan="2">M+2</th>
                            <th colspan="2">M+3</th>
                            <th colspan="4">SKU</th>
                            <th rowspan="2">Subtotal Gramasi</th>
                        </tr>
                        <tr>
                            <th>Target</th>
                            <th>Actual Register</th>
                            <th>Actual Submission</th>
                            <th>%</th>
                            <th>Actual</th>
                            <th>%</th>
                            <th>Actual</th>
                            <th>%</th>
                            <th>Actual</th>
                            <th>%</th>
                            <th>200</th>
                            <th>400</th>
                            <th>800</th>
                            <th>1000</th>
                        </tr>
                    </thead>
                    <tfoot align="right">
                        <tr>
                            <th colspan="2"></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
                </div>
            </div>
          </div>
        </div>

    </div>

    <br>

    <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <h6 class="card-header">
              Report By TC
            </h6>
            <div class="card-body box_filter">
                <div class="table-responsive">
                <table class="table table-hover table-sm data-tc">
                    <thead>
                        <tr>
                            <th rowspan="2" width="20">No</th>
                            <th rowspan="2">TC</th>
                            <th rowspan="2">#of BP</th>
                            <th colspan="4">New User</th>
                            <th colspan="2">M+1</th>
                            <th colspan="2">M+2</th>
                            <th colspan="2">M+3</th>
                            <th colspan="4">SKU</th>
                            <th rowspan="2">Subtotal Gramasi</th>
                        </tr>
                        <tr>
                            <th>Target</th>
                            <th>Actual Register</th>
                            <th>Actual Submission</th>
                            <th>%</th>
                            <th>Actual</th>
                            <th>%</th>
                            <th>Actual</th>
                            <th>%</th>
                            <th>Actual</th>
                            <th>%</th>
                            <th>200</th>
                            <th>400</th>
                            <th>800</th>
                            <th>1000</th>
                        </tr>
                    </thead>
                    <tfoot align="right">
                        <tr>
                            <th colspan="2"></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
                </div>
            </div>
          </div>
        </div>

    </div>

    <br>

    <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <h6 class="card-header">
              Report By NA
            </h6>
            <div class="card-body box_filter">
                <div class="table-responsive">
                <table class="table table-hover table-sm data-na">
                    <thead>
                        <tr>
                            <th rowspan="2" width="20">No</th>
                            <th rowspan="2">TC</th>
                            <th rowspan="2">NA</th>
                            <th colspan="4">New User</th>
                            <th colspan="2">M+1</th>
                            <th colspan="2">M+2</th>
                            <th colspan="2">M+3</th>
                            <th colspan="4">SKU</th>
                            <th rowspan="2">Subtotal Gramasi</th>
                        </tr>
                        <tr>
                            <th>Target</th>
                            <th>Actual Register</th>
                            <th>Actual Submission</th>
                            <th>%</th>
                            <th>Actual</th>
                            <th>%</th>
                            <th>Actual</th>
                            <th>%</th>
                            <th>Actual</th>
                            <th>%</th>
                            <th>200</th>
                            <th>400</th>
                            <th>800</th>
                            <th>1000</th>
                        </tr>
                    </thead>
                    <tfoot align="right">
                        <tr>
                            <th colspan="3"></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
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

{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> --}}
<script src="https://cdn.datatables.net/plug-ins/1.10.19/api/sum().js"></script>

<script>
    let bulan = '{{ $bulan }}';
    $('select[name="bulan"]').val(bulan).change();

    function allReport(id) {
        reportByRegion(id);
        // reportByArea(id);
        // reportByTC(id);
        // reportByNA(id);
    }
    
    function reportByRegion(id){
        if(id == 1) {
            idExport = 1;
            // urlAjax = "/reportByRegion";
        }
        if(id == 0) {
            idExport = 0;
            // urlAjax = "/reportByRegionM0";
        }
        $('.data-region').DataTable({
            dom: 'Blrtip',
            processing: true,
            serverSide: true,
            searching : false,
            // lengthChange : false,
            pageLength  : 10,
            bDestroy: true,
            order: [[ 0, "asc" ]],
            ajax: {
                url  : "/reportByRegion",
                type : "POST",
                data : function(d){
                    d._token = $("input[name=_token]").val();
                    d.bulan = $('select[name="bulan"]').val();
                    d.tahun = $('select[name="tahun"]').val();
                    d.number = id;
                },
            },
            lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
            columns: [
                { data: 'userid'},
                { data: 'region'},
                { data: 'bp'},
                { data: 'target'},
                { data: 'new_user'},
                { data: 'submission'},
                { data: 'percent0'},
                { data: 'm1'},
                { data: 'percent1'},
                { data: 'total_m2'},
                { data: 'percent2'},
                { data: 'total_m3'},
                { data: 'percent3'},
                { data: 'sku_200'},
                { data: 'sku_400'},
                { data: 'sku_800'},
                { data: 'sku_1000'},
                { data: 'subtotal_gramasi'}
            ],
            columnDefs: [{
                "targets": 6,
                "render": function ( data, type, full, meta ) {
                    return countPercent(full.target, full.submission);
                }
            },{
                "targets": 8,
                "render": function ( data, type, full, meta ) {
                    return countPercent(full.new_user, full.m1);
                }
            },{
                "targets": 10,
                "render": function ( data, type, full, meta ) {
                    return countPercent(full.submission, full.total_m2);
                }
            },{
                "targets": 12,
                "render": function ( data, type, full, meta ) {
                    return countPercent(full.submission, full.total_m3);
                }
            },{
                "targets": 17,
                "render": function ( data, type, full, meta ) {
                    return countSubtotal(full.sku_200, full.sku_400, full.sku_800, full.sku_1000);
                }
            },{
                className: "text-right", "targets": [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17] 
            }],
            "initComplete":function( settings, json){
                reportByArea(id);
            },
            "fnRowCallback" : function(nRow, aData, iDisplayIndex){
                $("td:first", nRow).html(iDisplayIndex +1);
                let result = countPercent(aData.submission, aData.total_m3);
                if(parseFloat(result) < 35) $("td:eq(12)", nRow).css("background-color", '#FF4444');
                return nRow;
            },
            "drawCallback": function( settings ) {
                var api = this.api();
                var bp = api.column(2).data().sum();
                var target = api.column(3).data().sum();
                var actualRegister = api.column(4).data().sum();
                var actualSubmission = api.column(5).data().sum();
                var percent0 = api.column(6).data().sum();
                var actual1 = api.column(7).data().sum();
                var percent1 = api.column(8).data().sum();
                var actual2 = api.column(9).data().sum();
                var percent2 = api.column(10).data().sum();
                var actual3 = api.column(11).data().sum();
                var percent3 = api.column(12).data().sum();
                var sku_200 = api.column(13).data().sum();
                var sku_400 = api.column(14).data().sum();
                var sku_800 = api.column(15).data().sum();
                var sku_1000 = api.column(16).data().sum();
                var subtotal = api.column(17).data().sum();
                
                $( api.column(0).footer() ).html('Total');
                $( api.column(2).footer() ).html(bp);
                $( api.column(3).footer() ).html(target);
                $( api.column(4).footer() ).html(actualRegister);
                $( api.column(5).footer() ).html(actualSubmission);
                $( api.column(6).footer() ).html(percent0);
                $( api.column(7).footer() ).html(actual1);
                $( api.column(8).footer() ).html(percent1);
                $( api.column(9).footer() ).html(actual2);
                $( api.column(10).footer() ).html(percent2);
                $( api.column(11).footer() ).html(actual3);
                $( api.column(12).footer() ).html(percent3);
                $( api.column(13).footer() ).html(sku_200);
                $( api.column(14).footer() ).html(sku_400);
                $( api.column(15).footer() ).html(sku_800);
                $( api.column(16).footer() ).html(sku_1000);
                $( api.column(17).footer() ).html(subtotal);

                let temp0 = countPercent(target, actualSubmission);
                let temp1 = countPercent(actualRegister, actual1);
                let temp2 = countPercent(actualSubmission, actual2);
                let temp3 = countPercent(actualSubmission, actual3);
                let temp4 = countSubtotal(sku_200, sku_400, sku_800, sku_1000);
                $( api.rows(18).column(6).footer() ).html(temp0);
                $( api.rows(18).column(8).footer() ).html(temp1);
                $( api.rows(18).column(10).footer() ).html(temp2);
                $( api.rows(18).column(12).footer() ).html(temp3);
                $( api.rows(18).column(17).footer() ).html(temp4);
            }
        });
    }

    function reportByArea(id){
        if(id == 1) {
            idExport = 1;
            // urlAjax = "/reportByArea";
        }
        if(id == 0) {
            idExport = 0;
            // urlAjax = "/reportByAreaM0";
        }
        $('.data-area').DataTable({
            dom: 'Blrtip',
            processing: true,
            serverSide: true,
            searching : false,
            // lengthChange : false,
            pageLength  : 10,
            bDestroy: true,
            order: [[ 0, "asc" ]],
            ajax: {
                url  : "/reportByArea",
                type : "POST",
                data : function(d){
                    d._token = $("input[name=_token]").val();
                    d.bulan = $('select[name="bulan"]').val();
                    d.tahun = $('select[name="tahun"]').val();
                    d.number = id;
                },
            },
            lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
            columns: [
                { data: 'userid'},
                { data: 'area'},
                { data: 'bp'},
                { data: 'target'},
                { data: 'new_user'},
                { data: 'submission'},
                { data: 'percent0'},
                { data: 'm1'},
                { data: 'percent1'},
                { data: 'total_m2'},
                { data: 'percent2'},
                { data: 'total_m3'},
                { data: 'percent3'},
                { data: 'sku_200'},
                { data: 'sku_400'},
                { data: 'sku_800'},
                { data: 'sku_1000'},
                { data: 'subtotal_gramasi'}
            ],
            columnDefs: [{
                "targets": 6,
                "render": function ( data, type, full, meta ) {
                    return countPercent(full.target, full.submission);
                }
            },{
                "targets": 8,
                "render": function ( data, type, full, meta ) {
                    return countPercent(full.new_user, full.m1);
                }
            },{
                "targets": 10,
                "render": function ( data, type, full, meta ) {
                    return countPercent(full.submission, full.total_m2);
                }
            },{
                "targets": 12,
                "render": function ( data, type, full, meta ) {
                    return countPercent(full.submission, full.total_m3);
                }
            },{
                "targets": 17,
                "render": function ( data, type, full, meta ) {
                    return countSubtotal(full.sku_200, full.sku_400, full.sku_800, full.sku_1000);
                }
            },{
                className: "text-right", "targets": [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17] 
            }],
            "initComplete":function( settings, json){
                reportByTC(id);
            },
            "fnRowCallback" : function(nRow, aData, iDisplayIndex){
                $("td:first", nRow).html(iDisplayIndex +1);
                let result = countPercent(aData.submission, aData.total_m3);
                if(parseFloat(result) < 35) $("td:eq(12)", nRow).css("background-color", '#FF4444');
                return nRow;
            },
            "drawCallback": function( settings ) {
                var api = this.api();
                var bp = api.column(2).data().sum();
                var target = api.column(3).data().sum();
                var actualRegister = api.column(4).data().sum();
                var actualSubmission = api.column(5).data().sum();
                var percent0 = api.column(6).data().sum();
                var actual1 = api.column(7).data().sum();
                var percent1 = api.column(8).data().sum();
                var actual2 = api.column(9).data().sum();
                var percent2 = api.column(10).data().sum();
                var actual3 = api.column(11).data().sum();
                var percent3 = api.column(12).data().sum();
                var sku_200 = api.column(13).data().sum();
                var sku_400 = api.column(14).data().sum();
                var sku_800 = api.column(15).data().sum();
                var sku_1000 = api.column(16).data().sum();
                var subtotal = api.column(17).data().sum();
                
                $( api.column(0).footer() ).html('Total');
                $( api.column(2).footer() ).html(bp);
                $( api.column(3).footer() ).html(target);
                $( api.column(4).footer() ).html(actualRegister);
                $( api.column(5).footer() ).html(actualSubmission);
                $( api.column(6).footer() ).html(percent0);
                $( api.column(7).footer() ).html(actual1);
                $( api.column(8).footer() ).html(percent1);
                $( api.column(9).footer() ).html(actual2);
                $( api.column(10).footer() ).html(percent2);
                $( api.column(11).footer() ).html(actual3);
                $( api.column(12).footer() ).html(percent3);
                $( api.column(13).footer() ).html(sku_200);
                $( api.column(14).footer() ).html(sku_400);
                $( api.column(15).footer() ).html(sku_800);
                $( api.column(16).footer() ).html(sku_1000);
                $( api.column(17).footer() ).html(subtotal);

                let temp0 = countPercent(target, actualSubmission);
                let temp1 = countPercent(actualRegister, actual1);
                let temp2 = countPercent(actualSubmission, actual2);
                let temp3 = countPercent(actualSubmission, actual3);
                let temp4 = countSubtotal(sku_200, sku_400, sku_800, sku_1000);
                $( api.rows(18).column(6).footer() ).html(temp0);
                $( api.rows(18).column(8).footer() ).html(temp1);
                $( api.rows(18).column(10).footer() ).html(temp2);
                $( api.rows(18).column(12).footer() ).html(temp3);
                $( api.rows(18).column(17).footer() ).html(temp4);
            }
        });
    }

    function reportByTC(id){
        if(id == 1) {
            idExport = 1;
            // urlAjax = "/reportByTC";
        }
        if(id == 0) {
            idExport = 0;
            // urlAjax = "/reportByTCM0";
        }
        $('.data-tc').DataTable({
            dom: 'Blrtip',
            processing: true,
            serverSide: true,
            searching : false,
            // lengthChange : false,
            pageLength  : 10,
            bDestroy: true,
            order: [[ 0, "asc" ]],
            ajax: {
                url  : "/reportByTC",
                type : "POST",
                data : function(d){
                    d._token = $("input[name=_token]").val();
                    d.bulan = $('select[name="bulan"]').val();
                    d.tahun = $('select[name="tahun"]').val();
                    d.number = id;
                },
            },
            lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
            columns: [
                { data: 'userid'},
                { data: 'spv'},
                { data: 'bp'},
                { data: 'target'},
                { data: 'new_user'},
                { data: 'submission'},
                { data: 'percent0'},
                { data: 'm1'},
                { data: 'percent1'},
                { data: 'total_m2'},
                { data: 'percent2'},
                { data: 'total_m3'},
                { data: 'percent3'},
                { data: 'sku_200'},
                { data: 'sku_400'},
                { data: 'sku_800'},
                { data: 'sku_1000'},
                { data: 'subtotal_gramasi'}
            ],
            columnDefs: [{
                "targets": 6,
                "render": function ( data, type, full, meta ) {
                    return countPercent(full.target, full.submission);
                }
            },{
                "targets": 8,
                "render": function ( data, type, full, meta ) {
                    return countPercent(full.new_user, full.m1);
                }
            },{
                "targets": 10,
                "render": function ( data, type, full, meta ) {
                    return countPercent(full.submission, full.total_m2);
                }
            },{
                "targets": 12,
                "render": function ( data, type, full, meta ) {
                    return countPercent(full.submission, full.total_m3);
                }
            },{
                "targets": 17,
                "render": function ( data, type, full, meta ) {
                    return countSubtotal(full.sku_200, full.sku_400, full.sku_800, full.sku_1000);
                }
            },{
                className: "text-right", "targets": [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17] 
            }],
            "initComplete":function( settings, json){
                reportByNA(id);
            },
            "fnRowCallback" : function(nRow, aData, iDisplayIndex){
                $("td:first", nRow).html(iDisplayIndex +1);
                let result = countPercent(aData.submission, aData.total_m3);
                if(parseFloat(result) < 35) $("td:eq(12)", nRow).css("background-color", '#FF4444');
                return nRow;
            },
            "drawCallback": function( settings ) {
                var api = this.api();
                var bp = api.column(2).data().sum();
                var target = api.column(3).data().sum();
                var actualRegister = api.column(4).data().sum();
                var actualSubmission = api.column(5).data().sum();
                var percent0 = api.column(6).data().sum();
                var actual1 = api.column(7).data().sum();
                var percent1 = api.column(8).data().sum();
                var actual2 = api.column(9).data().sum();
                var percent2 = api.column(10).data().sum();
                var actual3 = api.column(11).data().sum();
                var percent3 = api.column(12).data().sum();
                var sku_200 = api.column(13).data().sum();
                var sku_400 = api.column(14).data().sum();
                var sku_800 = api.column(15).data().sum();
                var sku_1000 = api.column(16).data().sum();
                var subtotal = api.column(17).data().sum();
                
                $( api.column(0).footer() ).html('Total');
                $( api.column(2).footer() ).html(bp);
                $( api.column(3).footer() ).html(target);
                $( api.column(4).footer() ).html(actualRegister);
                $( api.column(5).footer() ).html(actualSubmission);
                $( api.column(6).footer() ).html(percent0);
                $( api.column(7).footer() ).html(actual1);
                $( api.column(8).footer() ).html(percent1);
                $( api.column(9).footer() ).html(actual2);
                $( api.column(10).footer() ).html(percent2);
                $( api.column(11).footer() ).html(actual3);
                $( api.column(12).footer() ).html(percent3);
                $( api.column(13).footer() ).html(sku_200);
                $( api.column(14).footer() ).html(sku_400);
                $( api.column(15).footer() ).html(sku_800);
                $( api.column(16).footer() ).html(sku_1000);
                $( api.column(17).footer() ).html(subtotal);

                let temp0 = countPercent(target, actualSubmission);
                let temp1 = countPercent(actualRegister, actual1);
                let temp2 = countPercent(actualSubmission, actual2);
                let temp3 = countPercent(actualSubmission, actual3);
                let temp4 = countSubtotal(sku_200, sku_400, sku_800, sku_1000);
                $( api.rows(18).column(6).footer() ).html(temp0);
                $( api.rows(18).column(8).footer() ).html(temp1);
                $( api.rows(18).column(10).footer() ).html(temp2);
                $( api.rows(18).column(12).footer() ).html(temp3);
                $( api.rows(18).column(17).footer() ).html(temp4);
            }
        });
    }

    function reportByNA(id){
        if(id == 1) {
            idExport = 1;
            // urlAjax = "/reportByNA";
        }
        if(id == 0) {
            idExport = 0;
            // urlAjax = "/reportByNAM0";
        }
        $('.data-na').DataTable({
            dom: 'Blrtip',
            processing: true,
            serverSide: true,
            searching : false,
            // lengthChange : false,
            pageLength  : 10,
            bDestroy: true,
            order: [[ 0, "asc" ]],
            ajax: {
                url  : "/reportByNA",
                type : "POST",
                data : function(d){
                    d._token = $("input[name=_token]").val();
                    d.bulan = $('select[name="bulan"]').val();
                    d.tahun = $('select[name="tahun"]').val();
                    d.number = id;
                },
            },
            lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
            columns: [
                { data: 'userid'},
                { data: 'spv'},
                { data: 'nama'},
                { data: 'target'},
                { data: 'new_user'},
                { data: 'submission'},
                { data: 'percent0'},
                { data: 'm1'},
                { data: 'percent1'},
                { data: 'total_m2'},
                { data: 'percent2'},
                { data: 'total_m3'},
                { data: 'percent3'},
                { data: 'sku_200'},
                { data: 'sku_400'},
                { data: 'sku_800'},
                { data: 'sku_1000'},
                { data: 'subtotal_gramasi'}
            ],
            columnDefs: [{
                "targets": 6,
                "render": function ( data, type, full, meta ) {
                    return countPercent(full.target, full.submission);
                }
            },{
                "targets": 8,
                "render": function ( data, type, full, meta ) {
                    return countPercent(full.new_user, full.m1);
                }
            },{
                "targets": 10,
                "render": function ( data, type, full, meta ) {
                    return countPercent(full.submission, full.total_m2);
                }
            },{
                "targets": 12,
                "render": function ( data, type, full, meta ) {
                    return countPercent(full.submission, full.total_m3);
                }
            },{
                "targets": 17,
                "render": function ( data, type, full, meta ) {
                    return countSubtotal(full.sku_200, full.sku_400, full.sku_800, full.sku_1000);
                }
            },{
                className: "text-right", "targets": [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17] 
            }],
            "fnRowCallback" : function(nRow, aData, iDisplayIndex){
                $("td:first", nRow).html(iDisplayIndex +1);
                let result = countPercent(aData.submission, aData.total_m3);
                if(parseFloat(result) < 35) $("td:eq(12)", nRow).css("background-color", '#FF4444');
                return nRow;
            },
            "drawCallback": function( settings ) {
                var api = this.api();
                var target = api.column(3).data().sum();
                var actualRegister = api.column(4).data().sum();
                var actualSubmission = api.column(5).data().sum();
                var percent0 = api.column(6).data().sum();
                var actual1 = api.column(7).data().sum();
                var percent1 = api.column(8).data().sum();
                var actual2 = api.column(9).data().sum();
                var percent2 = api.column(10).data().sum();
                var actual3 = api.column(11).data().sum();
                var percent3 = api.column(12).data().sum();
                var sku_200 = api.column(13).data().sum();
                var sku_400 = api.column(14).data().sum();
                var sku_800 = api.column(15).data().sum();
                var sku_1000 = api.column(16).data().sum();
                var subtotal = api.column(17).data().sum();
                
                $( api.column(0).footer() ).html('Total');
                $( api.column(3).footer() ).html(target);
                $( api.column(4).footer() ).html(actualRegister);
                $( api.column(5).footer() ).html(actualSubmission);
                $( api.column(6).footer() ).html(percent0);
                $( api.column(7).footer() ).html(actual1);
                $( api.column(8).footer() ).html(percent1);
                $( api.column(9).footer() ).html(actual2);
                $( api.column(10).footer() ).html(percent2);
                $( api.column(11).footer() ).html(actual3);
                $( api.column(12).footer() ).html(percent3);
                $( api.column(13).footer() ).html(sku_200);
                $( api.column(14).footer() ).html(sku_400);
                $( api.column(15).footer() ).html(sku_800);
                $( api.column(16).footer() ).html(sku_1000);
                $( api.column(17).footer() ).html(subtotal);

                let temp0 = countPercent(target, actualSubmission);
                let temp1 = countPercent(actualRegister, actual1);
                let temp2 = countPercent(actualSubmission, actual2);
                let temp3 = countPercent(actualSubmission, actual3);
                let temp4 = countSubtotal(sku_200, sku_400, sku_800, sku_1000);
                $( api.rows(18).column(6).footer() ).html(temp0);
                $( api.rows(18).column(8).footer() ).html(temp1);
                $( api.rows(18).column(10).footer() ).html(temp2);
                $( api.rows(18).column(12).footer() ).html(temp3);
                $( api.rows(18).column(17).footer() ).html(temp4);
            }
        });
    }

    function countPercent(target=1,actual=0) {
        if(target == 0) target = 1;
        let result = (parseInt(actual) * 100) / parseInt(target);
        return result.toFixed(2)+'%';
    }

    function countRetention(val1,val2) {
        let result = parseInt(val1) + parseInt(val2);
        return result;
    }

    function countSubtotal(sku_200,sku_400,sku_800,sku_1000) {
        let temp1 = parseInt(sku_200) * 200;
        let temp2 = parseInt(sku_400) * 400;
        let temp3 = parseInt(sku_800) * 800;
        let temp4 = parseInt(sku_1000) * 1000;
        let result = temp1 + temp2 + temp3 + temp4;
        return result;
    }

    function exportData() {
        if(idExport == 1) window.location = '{{ url("user-retention/1/export") }}';
        if(idExport == 0) window.location = '{{ url("user-retention/0/export") }}';
    }

</script>
@endsection
