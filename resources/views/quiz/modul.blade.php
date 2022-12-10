{{-- @dd($pk_modul); --}}
@extends('master.master')

@section('quizActive','active')
@section('page_title', $title)

@section('konten')

      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <h6 class="card-header">
              {{ $title }}
              {{-- <div class="list-display">
                <a href="#" id="btn-on" class="btn-display" data-status="on"><i class="feather-eye"></i> Semua</a> |
                <a href="#" id="btn-off" class="btn-display" data-status="off"><i class="feather-trash-2"></i> Sampah</a>
              </div> --}}
                 @if (hakAksesMenu('quiz','print'))
                    <a href="{{ url('/quiz/templates/soal') }}" class="float-right btn btn-sm btn-link"><i class="feather-file-text"></i> Template Soal</a>
                @endif
            </h6>
            <div class="card-body box_filter">
                @if (session()->has('pesan'))
                    {!! session('pesan') !!}
                @endif

                <div class="row">
                    <div class="col-sm-12">

                    </div>
                </div>

                <form action="{{ url('/quiz/export') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            @if (hakAksesMenu('quiz','create'))
                            {!! xButton('', 'tambahsoal') !!}
                            {!! xButton('', 'importsoal') !!}
                            @endif
                        </div>
                    </div>
                </form>

                <hr>

                <table class="table table-hover table-sm data-list">
                    <thead>
                        <tr>
                            <th width="20">no</th>
                            <th width="40">gambar</th>
                            <th width="100">soal</th>
                            <th width="70">pilihan a</th>
                            <th width="70">pilihan b</th>
                            <th width="70">pilihan c</th>
                            <th width="70">pilihan d</th>
                            <th width="50">jawaban</th>
                            <th width="50"></th>
                        </tr>
                    </thead>
                </table>
            </div>
          </div>
        </div>

      </div>

    <!-- Modal -->
    <div class="modal fade" id="modalTambahSoal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form action="{{ url('/quiz/tambahsoal') }}" method="POST" id="my-form">
            @csrf

            <input type="hidden" name="idpk_module" value="{{ $pk_modul[0]['idpk_module'] }}">
            <input type="hidden" name="bulan" value="{{ $pk_modul[0]['bulan'] }}">
            <input type="hidden" name="tahun" value="{{ $pk_modul[0]['tahun'] }}">
            <input type="hidden" name="no_soal" value="1">
            <input type="hidden" name="idsoal" value="">
            <input type="hidden" name="gambarunlink" value="">

            <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title title_tambah_soal" id="exampleModalLabel">Tambah Soal Quiz</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-sm-1 mb-1">
                            <label>Gambar:</label>
                        </div>
                        <div class="col-sm-11">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1" checked>
                                <label class="custom-control-label" for="customSwitch1"></label>
                            </div>
                        </div>
                        <div class="col-sm-8 displai">
                            <input class="form-control" type="file" name="sumberupload" id="sumberupload">
                            <small><span class="text-danger">*</span> bisa menggunakan gambar atau url</small>

                            <hr>
                            <input class="form-control" type="text" name="sumberurl" placeholder="contoh : https://pbs.twimg.com/media/FNxEVJAVIAAs8Ct?format=jpg&name=large">
                        </div>
                        <div class="col-sm-3 ml-3 displai">
                            {{-- <img src="{{ url('storage/gambarsoal/mase.jpg') }}" alt="" width="100" class="img-thumbnail"> --}}
                            <img src="" alt="" style="max-width: 150; max-height: 130px" class="img-thumbnail" id="gambaredit">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="">Soal:</label>
                            <textarea class="form-control" name="soal" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label for="">Pilihan A:</label>
                            <textarea class="form-control" name="pilihan1" rows="3"></textarea>
                        </div>
                        <div class="col-sm-6">
                            <label for="">Pilihan B:</label>
                            <textarea class="form-control" name="pilihan2" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label for="">Pilihan C:</label>
                            <textarea class="form-control" name="pilihan3" rows="3"></textarea>
                        </div>
                        <div class="col-sm-6">
                            <label for="">Pilihan D:</label>
                            <textarea class="form-control" name="pilihan4" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="">Jawaban:</label>
                            <select name="jawaban" class="form-control select2" id="jawaban">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="cubauploadgambar()">Simpan</button>
                </div>
            </div>
            </div>
        </form>
    </div>
    <!-- Modal End -->

    <!-- Modal Import -->
    <div class="modal fade" id="importItt" tabindex="-1" aria-labelledby="importIttLabel" aria-hidden="true">
        <div class="modal-dialog modal-xs modal-dialog-scrollable">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importIttLabel">Import Soal</h5>
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

    <!-- Modal Gambar -->
    <div class="modal fade" id="modalGambar" tabindex="-1" aria-labelledby="modalGambarLabel" aria-hidden="true">
        {{-- <div class="modal-dialog modal-xs modal-dialog-scrollable"> --}}
        <div class="modal-dialog modal-xs modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalGambarLabel">Gambar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="gambarku" src="" alt="" class="img-thumbnail" style="width: 100%">
            </div>
            <div class="modal-footer">
                
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

    function reset(){

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
                url  : "/ajaxModul",
                type : "POST",
                data : function(d){
                    d._token = $("input[name=_token]").val();
                    d.status = $('input[name="_status"]').val();
                    d.idpk_module = <?php echo $pk_modul[0]['idpk_module']; ?>;
                },
            },
            columns: [
                { data: 'nomor'},
                { data: 'gambarsoal'},
                { data: 'soal'},
                { data: 'pilihan1'},
                { data: 'pilihan2'},
                { data: 'pilihan3'},
                { data: 'pilihan4'},
                { data: 'jawaban'},
                { data: 'aksi'},
            ]
        });
    }

    function cubauploadgambar() {
        let file_data = $('#sumberupload').prop('files')[0];
        let token     = $("input[name=_token]").val();
	    let form_data = new FormData();
	    form_data.append('berkas', file_data);
        form_data.append('_token', token);
        form_data.append('id_soal', $('input[name="idsoal"]').val());
        form_data.append('idpk_module', $('input[name="idpk_module"]').val());
        form_data.append('tahun', $('input[name="tahun"]').val());
        form_data.append('bulan', $('input[name="bulan"]').val(),);
        form_data.append('no_soal', $('input[name="no_soal"]').val());
        form_data.append('gambarunlink', $('input[name="gambarunlink"]').val());
        form_data.append('soal', $('textarea[name="soal"]').val());
        form_data.append('pilihan1', $('textarea[name="pilihan1"]').val());
        form_data.append('pilihan2', $('textarea[name="pilihan2"]').val());
        form_data.append('pilihan3', $('textarea[name="pilihan3"]').val());
        form_data.append('pilihan4', $('textarea[name="pilihan4"]').val());
        form_data.append('jawaban', $('select[name="jawaban"]').val());
        form_data.append('sumberurl', $('input[name="sumberurl"]').val());
        form_data.append('gambarswitch', $("#customSwitch1").val());

        $.ajax({
	        url         : '/quiz/tambaheditsoal', // point to server-side PHP script
	        type        : 'POST',
	        cache       : false,
	        contentType : false,
	        processData : false,
	        data        : form_data,
	        success : function(msg){
                if(msg.tipe === true){
                    Swal.fire({
                        title : 'Berhasil',
                        text  : msg.pesan,
                        icon  : 'success',
                        width : '20rem',
                        timer : 3000,
                        showConfirmButton : false,
                        showCancelButton : false,
                    });

                }else{
                    Swal.fire({
                        title : 'Error',
                        text  : msg.pesan,
                        icon  : 'error',
                        width : '20rem',
                        // timer : 3000,
                        showConfirmButton : false,
                        showCancelButton : false,
                    });
                }

                // data_list.ajax.reload();
                resetModal();
                $('.modal').modal('hide');
                getList();

            }
        });
    }

    // function tambahEdit() {

    //     $.ajax({
    //         type : 'POST',
    //         url  : '/quiz/tambaheditsoal',
    //         dataType : 'json',
    //         data : {
    //             _token          : $('input[name="_token"]').val(),
    //             'id_soal'       : $('input[name="idsoal"]').val(),
    //             'idpk_module'   : $('input[name="idpk_module"]').val(),
    //             'tahun'         : $('input[name="tahun"]').val(),
    //             'bulan'         : $('input[name="bulan"]').val(),
    //             'no_soal'       : $('input[name="no_soal"]').val(),
    //             'soal'          : $('textarea[name="soal"]').val(),
    //             'pilihan1'      : $('textarea[name="pilihan1"]').val(),
    //             'pilihan2'      : $('textarea[name="pilihan2"]').val(),
    //             'pilihan3'      : $('textarea[name="pilihan3"]').val(),
    //             'pilihan4'      : $('textarea[name="pilihan4"]').val(),
    //             'jawaban'       : $('select[name="jawaban"]').val(),
    //         },
    //         success : function(msg){
    //             if(msg.tipe === true){
    //                 Swal.fire({
    //                     title : 'Berhasil',
    //                     text  : msg.pesan,
    //                     icon  : 'success',
    //                     width : '20rem',
    //                     timer : 3000,
    //                     showConfirmButton : false,
    //                     showCancelButton : false,
    //                 });

    //             }else{
    //                 Swal.fire({
    //                     title : 'Error',
    //                     text  : msg.pesan,
    //                     icon  : 'error',
    //                     width : '20rem',
    //                     // timer : 3000,
    //                     showConfirmButton : false,
    //                     showCancelButton : false,
    //                 });
    //             }

    //             // data_list.ajax.reload();
    //             resetModal();
    //             $('.modal').modal('hide');
    //             getList();

    //         }
    //     });
    // }

    function resetModal() {
        $('input[name="idsoal"]').val(''),
        $('input[name="sumberurl"]').val(''),
        $('input[name="sumberupload"]').val(''),
        $('textarea[name="soal"]').val(''),
        $('textarea[name="pilihan1"]').val(''),
        $('textarea[name="pilihan2"]').val(''),
        $('textarea[name="pilihan3"]').val(''),
        $('textarea[name="pilihan4"]').val(''),
        $('select[name="jawaban"]').val('A').trigger('change');
        $('.title_tambah_soal').html('Tambah Soal Quiz');
        $('#gambaredit').attr("src",'<?= $urlbantu ;?>gambarsoal/no_image.gif');
        $('#customSwitch1').prop('checked',true);
        $('#customSwitch1').val("true");
        $(".displai").removeClass("d-none");
    }

    $('#modalTambahSoal').on('show.bs.modal', function(e) {

        resetModal();

		//get data-id attribute of the clicked element

		let idsoal = $(e.relatedTarget).data('idsoal');
		let gambar = $(e.relatedTarget).data('gambar');
		let soal = $(e.relatedTarget).data('soal');
		let pilihan1 = $(e.relatedTarget).data('pilihan1');
		let pilihan2 = $(e.relatedTarget).data('pilihan2');
		let pilihan3 = $(e.relatedTarget).data('pilihan3');
		let pilihan4 = $(e.relatedTarget).data('pilihan4');
		let jawaban = $(e.relatedTarget).data('jawaban');

        if( idsoal != undefined ) {
            //populate the textbox
            $(e.currentTarget).find('.title_tambah_soal').html('Edit Soal Quiz');
            $(e.currentTarget).find('#gambaredit').attr("src",gambar);
            $(e.currentTarget).find('input[name="gambarunlink"]').val(gambar);
            $(e.currentTarget).find('input[name="idsoal"]').val(idsoal);
            $(e.currentTarget).find('textarea[name="soal"]').val(soal);
            $(e.currentTarget).find('textarea[name="pilihan1"]').val(pilihan1);
            $(e.currentTarget).find('textarea[name="pilihan2"]').val(pilihan2);
            $(e.currentTarget).find('textarea[name="pilihan3"]').val(pilihan3);
            $(e.currentTarget).find('textarea[name="pilihan4"]').val(pilihan4);
            $(e.currentTarget).find('select[name="jawaban"]').val(jawaban).trigger('change');
        }

	});

    function importModal(){
		$('#importItt').modal({backdrop: 'static', keyboard: false});
	}

    function prosesImport(){
		var file_data = $('#file_excel').prop('files')[0];
        var token     = $("input[name=_token]").val();
	    var form_data = new FormData();
	    form_data.append('berkas', file_data);
        form_data.append('_token', token);
        form_data.append('idpk_module', <?= $pk_modul[0]['idpk_module'] ?>);
        form_data.append('tahun', <?= $pk_modul[0]['tahun'] ?>);
        form_data.append('bulan', <?= $pk_modul[0]['bulan'] ?>);

	    $.ajax({
	        url         : '/quiz/import', // point to server-side PHP script
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

    function modalGambar(srcgambar) {
        $("#gambarku").attr("src",srcgambar);
        $('#modalGambar').modal({backdrop: 'static', keyboard: false});
    }

    $("#customSwitch1").on('change', function() {
        if ($(this).is(':checked')) {
            $(this).attr('value', 'true');
            // alert($(this).val());
            $(".displai").removeClass("d-none");
        }
        else {
           $(this).attr('value', 'false');
        //    alert($(this).val());
            $(".displai").addClass("d-none");
        }
    });

</script>
@endsection
