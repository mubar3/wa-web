@extends('master.master')

@section('import','active')
{{-- @section('page_title', $title) --}}

@section('konten')

<div class="row">
    <div class="col-sm-2">
        <input type="text" name="tmulai" class="form-control tMulai" value="{{ $tMulai }}">
    </div>
    {{-- <div class="col-sm-2">
        <input type="text" name="takhir" class="form-control tAkhir" value="{{ $tAkhir }}">
    </div> --}}
    <div class="col-sm-3">
        <input type="text" name="cari" class="form-control" placeholder="Cari NIK / Nama">
    </div>

    <div class="col-sm-2">
        <a href="#" class="btn btn-sm btn-warning" onclick="getList()">GO</a>
        {{-- <a href="#" class="btn btn-sm btn-default" onclick="filterTambahan(event)" title="Filter tambahan"><i class="feather-filter"></i></a> --}}
        <a href="#" class="btn btn-sm btn-default" onclick="reset()"><i class="feather-rotate-ccw"></i></a>
    </div>

</div>

<hr>

{{-- start navigasi --}}
<div class="row">
    <div class="col-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="whocode-tab" data-toggle="tab" href="#whocode" role="tab" aria-controls="whocode" aria-selected="true">WHO CODE</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="roleplay-tab" data-toggle="tab" href="#roleplay" role="tab" aria-controls="roleplay" aria-selected="false">AOST</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="presentation-tab" data-toggle="tab" href="#presentation" role="tab" aria-controls="presentation" aria-selected="false">PRESENTATION</a>
            </li>
        </ul>
    </div>
</div>
{{-- end navigasi --}}

{{-- panggil view navigasi --}}
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="whocode" role="tabpanel" aria-labelledby="whocode-tab">
        @include('importdriver.whocode')
    </div>
    <div class="tab-pane fade" id="roleplay" role="tabpanel" aria-labelledby="roleplay-tab">
        @include('importdriver.roleplay')
    </div>
    <div class="tab-pane fade" id="presentation" role="tabpanel" aria-labelledby="presentation-tab">
        @include('importdriver.presentation')
    </div>
</div>
{{-- end panggil view navigasi --}}

@endsection

@section('my-script')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>

<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
{{-- plugin month select --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/style.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/index.js"></script>

<script>
    flatpickr('.tanggal',{
        dateFormat: 'Y-m-d',
        monthSelectorType: 'static',
        // defaultDate : '<?= date("Y-m-d"); ?>',
    });

    getList();

    function importModalWhocode(){
		$('#importWhocode').modal({backdrop: 'static', keyboard: false});
	}

    function importModalRoleplay(){
		$('#importRoleplay').modal({backdrop: 'static', keyboard: false});
	}

    function importModalPresentation(){
		$('#importPresentation').modal({backdrop: 'static', keyboard: false});
	}

    function prosesImportWhocode(){
		var file_data = $('#file_excel_whocode').prop('files')[0];
        var token     = $("input[name=_token]").val();
	    var form_data = new FormData();
	    form_data.append('berkas', file_data);
        form_data.append('_token', token);

	    $.ajax({
	        url         : '/importdriver/importwhocode', // point to server-side PHP script
	        type        : 'POST',
	        cache       : false,
	        contentType : false,
	        processData : false,
	        data        : form_data,
	        beforeSend : function(){
	        	$('#notif-whocode').html('').hide();
	        	$('.btn-unggah').text('Loading...').attr('disabled','disabled');
	        	$('.close').hide();
	        },
	        success: function(msg){
	        	var status = msg.status;
                var pesan  = msg.pesan;

	           	if(status === false){
	           		$('#notif-whocode').html('<div class="alert alert-danger">'+pesan+'</div>').show();

	           	}else{
	           		$('#notif-whocode').html('<div class="alert alert-success">'+pesan+'</div>').show();
	           		setTimeout(function(){
	           			$('#importWhocode').modal('hide');
	           		},1500);
	           	}

                getList();
	           	$('.btn-unggah').text('Unggah').removeAttr('disabled');
	        	$('.close').show();
	        }
	     });
	}

    function prosesImportRoleplay(){
		var file_data = $('#file_excel_roleplay').prop('files')[0];
        var token     = $("input[name=_token]").val();
	    var form_data = new FormData();
	    form_data.append('berkas', file_data);
        form_data.append('_token', token);

	    $.ajax({
	        url         : '/importdriver/importroleplay', // point to server-side PHP script
	        type        : 'POST',
	        cache       : false,
	        contentType : false,
	        processData : false,
	        data        : form_data,
	        beforeSend : function(){
	        	$('#notif-roleplay').html('').hide();
	        	$('.btn-unggah').text('Loading...').attr('disabled','disabled');
	        	$('.close').hide();
	        },
	        success: function(msg){
	        	var status = msg.status;
                var pesan  = msg.pesan;

	           	if(status === false){
	           		$('#notif-roleplay').html('<div class="alert alert-danger">'+pesan+'</div>').show();

	           	}else{
	           		$('#notif-roleplay').html('<div class="alert alert-success">'+pesan+'</div>').show();
	           		setTimeout(function(){
	           			$('#importRoleplay').modal('hide');
	           		},1500);
	           	}

                getList();
	           	$('.btn-unggah').text('Unggah').removeAttr('disabled');
	        	$('.close').show();
	        }
	     });
	}

    function prosesImportPresentation(){
		var file_data = $('#file_excel_presentation').prop('files')[0];
        var token     = $("input[name=_token]").val();
	    var form_data = new FormData();
	    form_data.append('berkas', file_data);
        form_data.append('_token', token);

	    $.ajax({
	        url         : '/importdriver/importpresentation', // point to server-side PHP script
	        type        : 'POST',
	        cache       : false,
	        contentType : false,
	        processData : false,
	        data        : form_data,
	        beforeSend : function(){
	        	$('#notif-presentation').html('').hide();
	        	$('.btn-unggah').text('Loading...').attr('disabled','disabled');
	        	$('.close').hide();
	        },
	        success: function(msg){
	        	var status = msg.status;
                var pesan  = msg.pesan;

	           	if(status === false){
	           		$('#notif-presentation').html('<div class="alert alert-danger">'+pesan+'</div>').show();

	           	}else{
	           		$('#notif-presentation').html('<div class="alert alert-success">'+pesan+'</div>').show();
	           		setTimeout(function(){
	           			$('#importPresentation').modal('hide');
	           		},1500);
	           	}

                getList();
	           	$('.btn-unggah').text('Unggah').removeAttr('disabled');
	        	$('.close').show();
	        }
	     });
	}

    // Tanggal Flat
    flatpickr('.tMulai',{
        plugins: [
            new monthSelectPlugin({
            shorthand: true, //defaults to false
            dateFormat: "Y-m", //defaults to "F Y"
            altFormat: "F Y", //defaults to "F Y"
            theme: "light" // defaults to "light"
            })
        ]
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
        // $('input[name="takhir"]').val('{{ $tAkhir }}');
        $('input[name="cari"]').val('');

        getList();
    }

    function getList() {
        getListWhocode()
        getListRoleplay()
        getListPresentation()
    }

    function getListWhocode(){
        var tabel_list = $('.data-list-whocode').DataTable({
            processing: true,
            serverSide: true,
            searching : false,
            lengthChange : false,
            pageLength  : 10,
            bDestroy: true,
            ajax: {
                url  : "/ajaxImportwhocode",
                type : "POST",
                data : function(d){
                    d._token = $("input[name=_token]").val();
                    d.tmulai = $('input[name="tmulai"]').val();
                    // d.takhir = $('input[name="takhir"]').val();
                    d.cari = $('input[name="cari"]').val();
                },
            },
            columns: [
                { data: 'nomor'},
                { data: 'kode'},
                { data: 'area'},
                { data: 'nik'},
                { data: 'nama'},
                { data: 'namatc'},
                { data: 'join_date'},
                { data: 'status_user'},
                { data: 'tahun'},
                { data: 'kuartal'},
                { data: 'nilai_test'},
            ],
            // columnDefs: [
            //     {
            //         'targets': 0,
            //         'checkboxes': {
            //             'selectRow': true
            //         },
            //     }
            // ],
            // select: {
            //     'style': 'multi'
            // },
            // order: [[1, 'asc']]
        });
    }

    function getListRoleplay(){
        var tabel_list = $('.data-list-roleplay').DataTable({
            processing: true,
            serverSide: true,
            searching : false,
            lengthChange : false,
            pageLength  : 10,
            bDestroy: true,
            ajax: {
                url  : "/ajaxImportroleplay",
                type : "POST",
                data : function(d){
                    d._token = $("input[name=_token]").val();
                    d.tmulai = $('input[name="tmulai"]').val();
                    // d.takhir = $('input[name="takhir"]').val();
                    d.cari = $('input[name="cari"]').val();
                },
            },
            columns: [
                { data: 'nomor'},
                { data: 'kode'},
                { data: 'area'},
                { data: 'nik'},
                { data: 'nama'},
                { data: 'namatc'},
                { data: 'join_date'},
                { data: 'status_user'},
                { data: 'tahun'},
                { data: 'kuartal'},
                { data: 'nilai_test'},
            ],
            // columnDefs: [
            //     {
            //         'targets': 0,
            //         'checkboxes': {
            //             'selectRow': true
            //         },
            //     }
            // ],
            // select: {
            //     'style': 'multi'
            // },
            // order: [[1, 'asc']]
        });
    }

    function getListPresentation(){
        var tabel_list = $('.data-list-presentation').DataTable({
            processing: true,
            serverSide: true,
            searching : false,
            lengthChange : false,
            pageLength  : 10,
            bDestroy: true,
            ajax: {
                url  : "/ajaxImportpresentation",
                type : "POST",
                data : function(d){
                    d._token = $("input[name=_token]").val();
                    d.tmulai = $('input[name="tmulai"]').val();
                    // d.takhir = $('input[name="takhir"]').val();
                    d.cari = $('input[name="cari"]').val();
                },
            },
            columns: [
                { data: 'nomor'},
                { data: 'kode'},
                { data: 'area'},
                { data: 'nik'},
                { data: 'nama'},
                { data: 'namatc'},
                { data: 'join_date'},
                { data: 'status_user'},
                { data: 'tahun'},
                { data: 'kuartal'},
                { data: 'nilai_test'},
            ],
            // columnDefs: [
            //     {
            //         'targets': 0,
            //         'checkboxes': {
            //             'selectRow': true
            //         },
            //     }
            // ],
            // select: {
            //     'style': 'multi'
            // },
            // order: [[1, 'asc']]
        });
    }
</script>
@endsection
