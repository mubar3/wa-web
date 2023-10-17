@php
$title_web='Api WA'
@endphp
@extends('master.master')

@section('berandaActive','active')
{{-- @section('page_title', $title) --}}

@section('konten')

{{-- start navigasi --}}
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css"> -->
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"></script> -->
<div class="row">
    <div class="col-12">
                @if (session()->has('pesan'))
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12">
                                                {!! session('pesan') !!}
                                            </div>
                                        </div>
                                        @endif
        <!-- <h4 style="text-align:center" >Kontak</h4><br> -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <!--   <li class="nav-item" role="presentation">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">MAPS</a>
            </li> -->



            <div class="table-responsive">
                <div class="card-body">
                        <a class="btn btn-primary" href="javascript:;" onclick="tambah()" data-toggle="modal" data-target="#formApi" style="margin-bottom:30px;">
                            Tambah Data
                        </a>
                        <button id="cek_status" class="btn btn-primary" href="javascript:;" style="margin-bottom:30px;">
                            Cek Status
                        </button> 
                        <!-- <div id="loading"> -->
                          <img id="loading" width="3%" style="padding-bottom:30px;" src="{{ url('storage/'.'loading.gif' )}}" alt="userr">
                        <!-- </div> -->
                        <div style="padding-bottom: 10px;">
                        <span>Last Check : </span>
                        <span id="last_check"></span>
                        </div>
                        <!-- <input type="text" id="search" name="search" placeholder="Cari (press Enter)" class="form-control"> -->
                        <!-- <table id="table1" class="table table1 table-hover table-striped table-bordered"> -->
                        <table id="table1" class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Url</th>
                                    <th class="text-center">Nomor</th>
                                    <th class="text-center">Tipe</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center"> </th>
                                </tr>
                            </thead>
                            <!-- <tbody>
                                
                            </tbody> -->
                        </table>
                    </div>

                </div>


                <div id="formApi" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form API</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="alert" role="alert"></div>
            <div class="modal-body">                    
                <div class="form-group col-xs-12 col-lg-12">
                    <label class="control-label">Url</label>
                    {{-- {{ Form::text('url', null, ['class' => 'form-control']) }} --}}
                    <input type='text' id="url" class="form-control" >
                    <br>
                    <label class="control-label">Nomor</label>
                    <input type='text' id="nomor" class="form-control" >
                    <br>
                    <label class="control-label">Tipe</label>
                    <select id="tipe" class="form-control" required>
                        <option value="" >Pilih tipe</option>
                        @foreach($tipe_send as $data)
                            <option value="{{$data->id}}" >{{$data->nama}}</option>
                        @endforeach
                    </select> 
                    <br>
                    <label class="control-label">Jenis</label>
                    <select id="jenis" class="form-control" required>
                        <option value="single" >Single</option>
                        <option value="multiple" >Multiple</option>
                    </select> 
                    <br>
                    <label class="control-label">Aktif</label>
                    <select id="status" class="form-control" required>
                        <option value="1" >Iya</option>
                        <option value="0" >Tidak</option>
                    </select> 
                    <br>
                    <label class="control-label">Nomor Baru</label>
                    <select id="baru" class="form-control" required>
                        <option value="y" >Iya</option>
                        <option value="n" >Tidak</option>
                    </select> 
                    <br>
                    <label class="control-label">Training</label>
                    <select id="training" class="form-control" required>
                        <option value="y" >Iya</option>
                        <option value="n" >Tidak</option>
                    </select> 
                    <br>
                    <label class="control-label">Cronjob</label>
                    <select id="cron" class="form-control" required>
                        <option value="y" >Iya</option>
                        <option value="n" >Tidak</option>
                    </select> 
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="submit()">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  crossorigin="anonymous"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" crossorigin="anonymous"></script> -->
    <script src="{{ url('/js/jquery.form.min.js') }}"></script>
<script type="text/javascript">
    // document.getElementById('last_check').innerHTML ='sdaw';
    var idEdit = 0;
    var idCek = 0;
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $(document).ready(function(){        
        getIndex();
        $('#loading').hide();
    });

    $( "#cek_status" ).click(function() {
        idCek = 1;
        document.getElementById("cek_status").disabled = true;
        getIndex();
    });

    function getIndex(){
        var date='';
        var time='';
        const result=[];
            if(idCek != 0){
            var url="{{ url('/data_api_wa_cek') }}"; 
            $('#loading').show();
            }else{
            var url="{{ url('/data_api_wa') }}";
            }
        $.ajax({
            type : 'get',
            url : url,
            success : function(data){  
                myTable.clear().draw();          
                $(data).each(function(x,y){
                    var status='';
                    if(y.status==1){status='<center><i class="fa-solid fa-check"></i></center>'}
                    else{status='<center><i class="fa-solid fa-xmark"></i></center>'}
                    result.push(y.url);
                    result.push(y.nomor);
                    result.push(y.nama);
                    result.push(status);
                    result.push('<a href="javascript:;" style="padding-right: 10px;" onclick="editApi('+y.id+','+y.id_tipe+')"><i class="fas fa-edit"></i> Edit</a> | <a href="javascript:;" onclick="hapusApi(this.parentNode.parentNode, '+y.id+')"> <i class="fas fa-trash-alt"></i> Hapus</a>');
                    myTable.row.add(result).draw();
                    result.length = 0;

                    var today = new Date(y.updated_at);

                    const month = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];

                    date = today.getDate()+' '+month[(today.getMonth())]+' '+today.getFullYear();    
                    time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();

                });            
                document.getElementById('last_check').innerHTML =time+', '+date;
                if(idCek != 0){
                document.getElementById("cek_status").disabled = false;
                $('#loading').hide();
                idCek = 0;
                }
            },
        });
    }

    // setInterval(function() {
    //     getIndex();
    // },1000);

    // $("#search").change(function() {
    //     getIndex();
    // });

    function submit(){
        var url;
        var type;
        var result;

        if( idEdit != 0 ){
            url = "{{ url('/edit_aksi_api_wa') }}";
            type = 'post';
        }else{
            url = "{{ url('/save_api_wa') }}";
            type = 'post';
        }

        // if(!($('#url').val()).includes('send-message')){
        if(!($('#url').val()).includes('http')){
            $('.alert').addClass('alert-danger').html('url tidak valid');
        }else{
            $.ajax({
                type : type,
                url : url,
                data : {
                    idedit : idEdit,
                    url : $('#url').val(),
                    tipe : $('#tipe').val(),
                    baru : $('#baru').val(),
                    training : $('#training').val(),
                    cron : $('#cron').val(),
                    nomor : $('#nomor').val(),
                    status : $('#status').val(),
                    jenis : $('#jenis').val(),
                },
                success : function(data){   
                    idEdit = 0;   
                    $('#url').val('');
                    $('#tipe').val('');
                    getIndex();
                    jQuery.noConflict();
                    $('#formApi').modal('hide');
                },
            });
        }
    }

    function tambah() {
        $('#url').val('');
        $('#tipe').val('');   
        $('#baru').val('y');   
        $('#training').val('y');   
        $('#cron').val('y');   
        $('#status').val('1');   
        $('#jenis').val('multiple');   
        $('.alert').removeClass('alert-danger');
        $('.alert').html('');
    }

    function editApi(id,id_tipe){   
        // console.log(id_tipe); 
        var link="{{ url('/edit_api_wa') }}";
        var link2='/'+id;
        var link_all=link+link2;    
        $.ajax({
            type : 'get',
            url : link_all,
            success : function(data){
                idEdit = data.id; 
                jQuery.noConflict();               
                $('#formApi').modal('show');
                $('#url').val(data.url);
                $('#tipe').val(id_tipe);                             
                $('#baru').val(data.baru);                             
                $('#training').val(data.training);                             
                $('#cron').val(data.cronjob);                             
                $('#nomor').val(data.nomor);                             
                $('#status').val(data.status);                             
                $('#jenis').val(data.jenis);                             
            },
        });
    }
    
    function hapusApi(element, id){    
        var link="{{ url('/delete_api_wa') }}";
        var link2='/'+id;
        var link_all=link+link2;
        // alert(link_all);
        // return;  
        $.ajax({
            type : 'get',
            url : link_all,
            success : function(data){
                if( data == 'sukses' ){
                    element.remove();
                }                                
            },
        });
    }
</script>

        </ul>
    </div>
</div>
                
    </div>
</div>
{{-- end navigasi --}}


@endsection


