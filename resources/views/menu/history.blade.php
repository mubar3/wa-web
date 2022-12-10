@php
$title_web='History WA' 
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
                <!-- <button type="button" class="btn-display btn-success">download</button> -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <!--   <li class="nav-item" role="presentation">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">MAPS</a>
            </li> -->




                <div class="card-body">
                    <div class="table-responsive">
                        <label>Filter :</label>
                        <form action="{{ url('/download_excel') }}" method="POST" id="my-form"> @csrf
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="" style="color:black">Api</span>
                          </div>
                            <select name="api" id="api" class="form-control">
                                <option value="" >Pilih Api</option>
                                @foreach($data as $data)    
                                <option value="{{$data['url']}}" >{{$data['url']}}</option>
                                @endforeach
                            </select>
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="" style="color:black">Dari Tanggal</span>
                          </div> 
                          <input type="date" id="tanggal_awal" class="form-control" name="tanggal_awal">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="" style="color:black">Sampai Tanggal</span>
                          </div> 
                          <input type="date" id="tanggal_akhir" class="form-control" name="tanggal_akhir">
                        </div>
                        <br>   
                        <button class="btn btn-primary" type="submit" target="_blank" id="download_excel" style="margin-bottom:30px;">
                            Download Excel
                        </button>
                        </form>
                        <!-- <input type="text" id="search" name="search" placeholder="Cari (press Enter)" class="form-control"> -->
                        <!-- <table id="table1" class="table table1 table-hover table-striped table-bordered"> -->
                        <div id="loading">
                          <img width="5%" src="{{ url('storage/'.'loading.gif' )}}" alt="userr">
                        </div>
                        <table  id="table1" class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">API</th>
                                    <th class="text-center">Penerima</th>
                                    <th class="text-center">Pesan</th>
                                    <th class="text-center">Waktu</th>
                                    <th class="text-center">Status Kirim</th>
                                </tr>
                            </thead>
                          <!--   <tbody>
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
            <div class="modal-body">                    
                <div class="form-group col-xs-12 col-lg-12">
                    <label class="control-label">Url</label>
                    {{ Form::text('url', null, ['class' => 'form-control']) }}
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" crossorigin="anonymous"></script>
<script type="text/javascript">
    // document.getElementById('last_check').innerHTML ='sdaw';
    var search=0;
    var idEdit = 0;
    var idCek = 0;
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $(document).ready(function(){        
        getIndex();
    });

    //  $( "#download_excel" ).click(function() {
    //     // window.open('about:blank');
    //     var urls = "{{ url('/download_excel') }}";
    //     var type = 'get';

    //     $.ajax({
    //         type : type,
    //         url : urls,
    //         data : {
    //             // idedit : idEdit,
    //             // url : urls,
    //         },
    //         success : function(data){
    //             console.log(data);   
    //         },
    //     });
    // });

    $( "#cek_status" ).click(function() {
        idCek = 1;
        getIndex();
    });

    function getIndex(){
        var urls;
        var datas;
        var types;
        const result=[];
        // var hasil='';

        if(search == 0){
            urls="{{ url('/data_history') }}";
            idCek = 0;
            // urls=urls+'/'+$('[name=search]').val();

            types='get';
            datas={};   
            // console.log(url);
        }else{
            urls="{{ url('/search_history') }}";
            types='post';
            datas={
                api : $('[name=api]').val(),
                tanggal_awal : $('[name=tanggal_awal]').val(),
                tanggal_akhir : $('[name=tanggal_akhir]').val()
            };
        }

        $('#loading').show();
        $.ajax({
            type : types,
            url : urls,
            data : datas,
            success : function(data){  
                    // $('tbody').html('');  
                    // result='';
                    myTable.clear().draw(); 
                    $(data).each(function(x,y){
                    //     // result=[];
                        var status='';
                        if(y.status_kirim==1){status='<center><i class="fa-solid fa-check"></i></center>'}
                        else{status='<center><i class="fa-solid fa-xmark"></i></center>'}
                        var today =  new Date(y.dikirim);

                        const month = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];

                        var date = today.getDate()+' '+month[(today.getMonth())]+' '+today.getFullYear();    
                        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                        var pengirim=y.telpon;
                        if (y.nama != null) {pengirim=y.nama;}
                            else{pengirim=y.telpon;}
                    //     // result = 
                    //     // '<tr>'
                    //     //     + '<td>'+y.api+'</td>'
                    //     //     + '<td>'+pengirim+'</td>'
                    //     //     + '<td>'+y.pesan+'</td>'
                    //     //     + '<td>'+time+', '+date+'</td>'
                    //     //     + '<td>'+status+'</td>'
                    //     // + '</tr>';

                    //     // $('tbody').append(result);
                        result.push(y.api);
                        result.push(pengirim);
                        result.push(y.pesan);
                        result.push(time+', '+date);
                        result.push(status);

                        // result.push(y.api,pengirim,y.pesan,time+', '+date,status);
                        myTable.row.add(result).draw();
                        // console.log(result);
                        result.length = 0;
                    }); 
                    $('#loading').hide();
            },
        });
    }

    // $("#search").change(function() {
    //     getIndex();
    // });

    $("#api").change(function() {
        search=1;
        // console.log(search);
        getIndex();
    });


    $("#tanggal_awal").change(function() {
        search=1;
        getIndex();
    });

    $("#tanggal_akhir").change(function() {
        search=1;
        getIndex();
    });

    function submit(){
        var url;
        var type;
        var result;

        if( idEdit != 0 ){
            // var link="{{ url('/edit_aksi_contact') }}";
            // var link2='/'+idEdit;
            // var link_all=link+link2;
            url = "{{ url('/edit_aksi_api_wa') }}";
            type = 'post';
        }else{
            url = "{{ url('/save_api_wa') }}";
            type = 'post';
        }

        $.ajax({
            type : type,
            url : url,
            data : {
                idedit : idEdit,
                url : $('[name=url]').val(),
            },
            success : function(data){   
                idEdit = 0;   
                $('[name=url]').val('');
                getIndex();
                jQuery.noConflict();
                $('#formApi').modal('hide');
            },
        });
    }

    function editPegawai(id){    
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
                $('[name=url]').val(data.url);                             
            },
        });
    }

    function destroyPegawai(element, id){    
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



<input type="hidden" name="page1">
<input type="hidden" name="page2">
<input type="hidden" name="page3">
<input type="hidden" name="page4">
<input type="hidden" name="page5">

@endsection

@section('my-script')
{{-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgTb1CFpkhDxfrNFKLP9bwGErvC1VP9Ew"></script> --}}
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmWwiQKyJhiwyFrW6DSWR-nrlbUFcguDs"></script>
<script src="{{ url('/js/clustermap.js') }}"></script>

<!-- {{-- datatable --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
{{-- end datatable --}} -->

{{-- flatpicker --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.11/dist/plugins/monthSelect/index.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.11/dist/plugins/monthSelect/style.css">
{{-- end flatpicker --}}

{{-- chart --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" ></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-annotation/0.5.7/chartjs-plugin-annotation.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
{{-- end chart --}}

{{-- better dropdown --}}
<!-- <script src="{{ asset('js/jquery.betterdropdown.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/jquery.betterdropdown.css') }}"> -->
{{-- end better dropdown --}}

<style>
    .week-range{
        margin-top: 5px;
        font-size: .7rem !important;
        color: #242424;
        font-weight: normal;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

