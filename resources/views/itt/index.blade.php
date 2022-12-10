@extends('master.master')

@section('itineraryActive','active')
@section('page_title', $title)

@section('konten')

      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <form action="{{ url('/itinerary/export') }}" method="POST">
            @csrf

            <h6 class="card-header">
              {{ $title }}

                @if (hakAksesMenu('Itinerary','print'))
                    <a href="{{ url('/itinerary/templates') }}" class="float-right btn btn-sm btn-link"><i class="feather-file-text"></i> Template ITT</a>
                @endif

            </h6>
            <div class="card-body">
                @if (session()->has('pesan'))
                    {!! session('pesan') !!}
                @endif

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

                    <div class="col-sm-2">
                        <a href="#" class="btn btn-sm btn-warning" onclick="getList()">GO</a>
                        <a href="#" class="btn btn-sm btn-default" onclick="filterTambahan(event)" title="Filter tambahan"><i class="feather-filter"></i></a>
                        <a href="#" class="btn btn-sm btn-default" onclick="reset()"><i class="feather-rotate-ccw"></i></a>
                    </div>

                    @if (hakAksesMenu('Itinerary','create'))
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-sm btn-outline-danger float-right" onclick="importModal()">
                                Import
                            </button>
                        </div>
                    @endif
                    @if (hakAksesMenu('Itinerary','print'))
                    <div class="col-sm-1">
                        <button type="submit" class="btn btn-sm btn-outline-success float-right">
                            Export
                        </button>
                    </div>
                    @endif
                    @if (hakAksesMenu('Itinerary','create'))
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-sm btn-outline-primary float-right" onclick="tambahModal()">
                                tambah
                            </button>
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
                                            <select name="jabatan" class="form-control select2" id="jabatan">
                                                <option value="">--Jabatan--</option>
                                                @foreach ($jabatan as $item)
                                                    <option value="{{ $item->jabatan_id }}">{{ $item->jabatan_nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
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
                                    <div class="row" style="margin-top: 10px;">
                                        {{-- <div class="col-sm-4">
                                            <select name="oos" class="form-control select2" id="oos">
                                                <option value="">--OOS & SOS--</option>
                                                <option value="y">Ya</option>
                                                <option value="n">Tidak</option>
                                            </select>
                                        </div> --}}

                                        <div class="col-sm-4">
                                            <select name="visit" class="form-control select2" id="">
                                                <option value="">--Visit--</option>
                                                <option value="y">Ya</option>
                                                <option value="n">Tidak</option>
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
                @if (hakAksesMenu('Itinerary','update') || hakAksesMenu('Itinerary','delete'))
                <div class="row">
                    <div class="col-sm-2">
                        <select name="action" class="select2">
                            <option value="">----</option>
                            {{-- <option value="oos_no">Matikan OOS</option>
                            <option value="oos_yes">Hidupkan OOS</option> --}}
                            @if (hakAksesMenu('Itinerary','delete'))
                            <option value="hapus_itt">Hapus Itinerary</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <button class="btn btn-outline-primary" type="button" id="prosesFilter">Proses</button>
                    </div>
                </div>
                <br>
                @endif

                <div style="text-align: center; margin-bottom:30px; display:none;" class="loadingitt">Loading....</div>
                <table class="table table-hover table-sm data-list">
                    <thead>
                        <tr>
                            <th></th>
                            <th width="90">Tanggal</th>
                            {{-- <th width="60">cluster</th> --}}
                            <th width="60">region</th>
                            <th width="70">area</th>
                            <th width="80">username</th>
                            <th width="200">nama</th>
                            <th width="20">jabatan</th>
                            <th width="100">outlet kode</th>
                            <th width="150">outlet</th>
                            {{-- <th width="80">oos & sos</th> --}}
                            <th width="70">pricing & promo</th>
                            <th width="40">visit</th>
                            <th width="50">Ket.</th>
                        </tr>
                    </thead>
                </table>
            </div>
          </div>
        </div>

      </div>

<!-- Modal -->
<div class="modal fade" id="userVisit" tabindex="-1" aria-labelledby="userVisitLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="userVisitLabel">Data yang sudah visit</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger notifUserVisit"></div>
            <div id="userVisitBody"></div>
        </div>
        </div>
    </div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="importItt" tabindex="-1" aria-labelledby="importIttLabel" aria-hidden="true">
    <div class="modal-dialog modal-xs modal-dialog-scrollable">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="importIttLabel">Import Itinerary</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div id="notif"></div>
            <div class="form-group">
                <label for="">File Excel</label>
                <input type="file" name="file_excel" id="file_excel" class="form-control">
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary btn-unggah" onclick="prosesImport()">Unggah</button>
        </div>
        </div>
    </div>
</div>

<!-- Modal tambah -->
<div class="modal fade" id="tambahItt" tabindex="-1" aria-labelledby="tambahIttLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="tambahIttLabel">Tambah Itinerary</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div id="notif-tambah-itt"></div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="">Username</label>
                    <select name="username[]" class="select2 form-control">
                        <option value="">-- Username --</option>
                        @foreach ($user as $item)
                            <option value="{{ $item->userid }}">{{ $item->username }} - {{ $item->nama }} - {{ $item->jabatan->jabatan_kode }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <label for="">Outlet</label>
                    <select name="outlet[]" class="select2 form-control">
                        <option value="">-- Outlet --</option>
                        @foreach ($outlet as $item)
                            <option value="{{ $item->outlet_id }}">{{ $item->outlet_kode }} - {{ $item->outlet_nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2">
                    <label for="">Tanggal</label>
                    <input type="text" name="tanggal[]" class="form-control tanggal" value="<?= date("Y-m-d"); ?>">
                </div>
                <div class="col-sm-2">
                    <label for="">Pricing & Promo</label>
                    <select name="oos[]" class="select2 form-control">
                        <option value="n">Tidak</option>
                        <option value="y">Ya</option>
                    </select>
                </div>
                <div class="col-sm-1">
                    <button class="mt-4 btn btn-dark btn-tambah" onclick="tambahForm()">+</button>
                </div>
            </div>
            <span class="boxTambahForm"></span>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary btn-unggah" onclick="prosesTambah()">Simpan</button>
        </div>
        </div>
    </div>
</div>

@endsection

@section('my-script')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>

<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    getList();

    function importModal(){
		$('#importItt').modal({backdrop: 'static', keyboard: false});
	}

    function tambahModal(){
		$('#tambahItt').modal({backdrop: 'static', keyboard: false});
	}

    function prosesImport(){
		var file_data = $('#file_excel').prop('files')[0];
        var token     = $("input[name=_token]").val();
	    var form_data = new FormData();
	    form_data.append('berkas', file_data);
        form_data.append('_token', token);

	    $.ajax({
	        url         : '/itinerary/import', // point to server-side PHP script
	        type        : 'POST',
	        cache       : false,
	        contentType : false,
	        processData : false,
	        data        : form_data,
	        beforeSend : function(){
	        	$('#notif').html('').hide();
	        	$('.btn-unggah').text('Loading...').attr('disabled','disabled');
	        	$('.close').hide();
	        },
	        success: function(msg){
	        	var status = msg.status;
                var pesan  = msg.pesan;

	           	if(status === false){
	           		$('#notif').html('<div class="alert alert-danger">'+pesan+'</div>').show();

	           	}else{
	           		$('#notif').html('<div class="alert alert-success">'+pesan+'</div>').show();
	           		setTimeout(function(){
	           			$('#importItt').modal('hide');
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
        $('select[name="cluster"]').val('').trigger('change');
        $('select[name="region"]').val('').trigger('change');
        $('select[name="area"]').val('').trigger('change');
        $('select[name="jabatan"]').val('').trigger('change');
        $('select[name="oos"]').val('').trigger('change');
        $('select[name="visit"]').val('').trigger('change');
        $('input[name="cari"]').val('');

        getList();
    }

    function getList(){
        var tabel_list = $('.data-list').DataTable({
            processing: true,
            serverSide: true,
            searching : false,
            lengthChange : false,
            pageLength  : 10,
            bDestroy: true,
            ajax: {
                url  : "/ajaxItinerary",
                type : "POST",
                data : function(d){
                    d._token = $("input[name=_token]").val();
                    d.tmulai = $('input[name="tmulai"]').val();
                    d.takhir = $('input[name="takhir"]').val();
                    d.cari = $('input[name="cari"]').val();
                    d.cluster = $('select[name="cluster"]').val();
                    d.region = $('select[name="region"]').val();
                    d.area = $('select[name="area"]').val();
                    d.jabatan = $('select[name="jabatan"]').val();
                    // d.oos = $('select[name="oos"]').val();
                    d.visit = $('select[name="visit"]').val();
                },
            },
            columns: [
                { data: 'nomor'},
                { data: 'tanggal_iso'},
                // { data: 'cluster'},
                { data: 'region'},
                { data: 'area'},
                { data: 'username'},
                { data: 'nama'},
                { data: 'jabatan_nama'},
                { data: 'outlet_kode'},
                { data: 'outlet'},
                { data: 'oos'},
                { data: 'visit'},
                { data: 'keterangan'},
            ],
            columnDefs: [
                {
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true
                    },
                }
            ],
            select: {
                'style': 'multi'
            },
            order: [[1, 'asc']]
        });

        $('#prosesFilter').on('click', function(e){
            e.preventDefault();

            const checkboxList = [];
            const datanya = tabel_list.column(0).checkboxes.selected();

            $.each(datanya, function(index, val){
                checkboxList.push(val);
            });

            if(checkboxList.length > 0){
                const aksinya = $('select[name="action"]').val();
                if(aksinya == 'oos_no'){
                    var title_modal = 'Hapus Mandatory OOS & SOS?'
                }
                else if(aksinya == 'oos_yes'){
                    var title_modal = 'Tambah Mandatory OOS & SOS?'
                }
                else if(aksinya == 'hapus_itt'){
                    var title_modal = 'Hapus Itineraray'
                }
                Swal.fire({
                    title : title_modal,
                    text  : 'Anda ingin melakukan ini?',
                    icon  : 'warning',
                    width : '20rem',
                    confirmButtonText : 'Tetap Proses',
                    cancelButtonText : 'Batal',
                    showCancelButton : true,
                }).then((result) => {
                    if(result.isConfirmed){
                    $.ajax({
                        type : 'POST',
                        url  : '/ajaxUpdateItt',
                        data : {
                            _token  : $("input[name=_token]").val(),
                            items     : checkboxList,
                            action  : $('select[name="action"]').val(),
                        },
                        beforeSend : function(){
                            $('.loadingitt').show();
                        },
                        success : function(msg){
                            const status = msg.status;
                            $('.loadingitt').hide();

                            // jika sudah ada user yang visit
                            if(status == false){
                                const data = msg.data;
                                const pesan= data[0].pesan;

                                $('#userVisit').modal('show');
                                $('.notifUserVisit').text(pesan);

                                var listTable = '<table class="table">';
                                    listTable+= '<thead><tr><th>Username</th><th>Nama</th><th>Outlet</th><th>Checkin</th></tr></thead>';
                                    listTable+= '<tbody>';
                                        $.each(data, function(index, val){
                                            listTable+= '<tr><td>'+val.username+'</td><td>'+val.nama+'</td><td>'+val.outlet+'</td><td>'+val.time_checkin+'</td></tr>';
                                        });
                                    listTable+= '</tbody>';
                                    listTable+= '</table>';

                                $('#userVisitBody').html(listTable);
                            }

                            if(status == true){
                                Swal.fire({
                                    title : 'Berhasil',
                                    text  : msg.pesan,
                                    icon  : 'success',
                                    width : '20rem',
                                    timer : 3000,
                                    showConfirmButton : false,
                                    showCancelButton : false,
                                });

                                getList();
                            }
                        }
                    });
                    return false;
                    }
                });
            }

        });
    }

    function filterTambahan(e){
        e.preventDefault();

        $('#box_filter').toggle('slow');
    }

    flatpickr('.tanggal',{
        dateFormat: 'Y-m-d',
        monthSelectorType: 'static',
        // defaultDate : '<?= date("Y-m-d"); ?>',
    });

    function tambahForm(){
        const box = '<div class="row" style="margin-top: 20px;"><div class="col-sm-4"><select name="username[]" class="select3 form-control"><option value="">-- Username --</option>@foreach ($user as $item)<option value="{{ $item->userid }}">{{ $item->username }} - {{ $item->nama }} - {{ $item->jabatan->jabatan_kode }}</option>@endforeach</select></div><div class="col-sm-3"><select name="outlet[]" class="select3 form-control"><option value="">-- Outlet --</option>@foreach ($outlet as $item)<option value="{{ $item->outlet_id }}">{{ $item->outlet_kode }} - {{ $item->outlet_nama }}</option>@endforeach</select></div><div class="col-sm-2"><input type="text" name="tanggal[]" class="form-control tanggal-pop" value="<?= date("Y-m-d"); ?>"></div><div class="col-sm-2"><select name="oos[]" class="select3 form-control"><option value="n">Tidak</option><option value="y">Ya</option></select></div><div class="col-sm-1"><button class="btn btn-sm btn-outline-danger hapusBoxForm">X</button></div></div>';

        var jumlah = $('select[name="username[]"]').length;
        if(jumlah > 6){
            Swal.fire({
                title : 'Peringatan',
                text  : 'Sekali Input Maksimal 7 Data',
                icon  : 'error',
                width : '20rem',
                timer : 3000,
                showConfirmButton : false,
                showCancelButton : false,
            });

        }else{
            $('.boxTambahForm').append(box);
            jumlah ++;
        }

        $(document).ready(function(){
            $('.select3').select2();

            flatpickr('.tanggal-pop',{
                dateFormat: 'Y-m-d',
                monthSelectorType: 'static',
                // defaultDate : '<?= date("Y-m-d"); ?>',
            });
        });
    }

    function prosesTambah(){
        var userid      = [];
        var outletid    = [];
        var tgl         = [];
        var isoos       = [];

        var username = $('select[name="username[]"]');
        var outlet   = $('select[name="outlet[]"]');
        var tanggal  = $('input[name="tanggal[]"]');
        var oos      = $('select[name="oos[]"]');

        $(username).each(function(){
            userid.push($(this).val());
        });

        $(outlet).each(function(){
            outletid.push($(this).val());
        });

        $(tanggal).each(function(){
            tgl.push($(this).val());
        });

        $(oos).each(function(){
            isoos.push($(this).val());
        });

        $.ajax({
            method : 'POST',
            url    : '/itinerary/create',
            data   : {
                userid : userid,
                outletid : outletid,
                tanggal : tgl,
                oos : isoos,
                _token : $('input[name="_token"]').val(),
            },
            success : function(msg){
                const status = msg.status;

                if(status == false){
                    $('#notif-tambah-itt').html('<div class="alert alert-danger">'+msg.error+'</div>');
                }else{
                    $('#notif-tambah-itt').html('<div class="alert alert-success">'+msg.error+'</div>');
                    getList();

                    setTimeout(function(){
                        $('#tambahItt').modal('hide');
                    },1500);
                }
            }
        });
    }

    $(document).ready(function(){
        $('.boxTambahForm').on('click','.hapusBoxForm', function(){
            $(this).parent().parent().remove();
        });
    });
</script>
@endsection
