@php
$title_web='Kirim File WA'
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
        <!-- <h4 style="text-align:center" >Kirim Pesan WA</h4><br> -->
        <div class="alert" role="alert"></div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <!--   <li class="nav-item" role="presentation">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">MAPS</a>
            </li> -->

                <!-- <form action="{{ url('/sent_wa') }}" method="POST" id="my-form"> -->
                <form id="fileUploadForm1" action="{{ url('/sent_file') }}" method="POST">
                     @csrf
                     <div>
            
                     <div class="form-group">
                        <label for="exampleInputEmail1">Nomor</label>
                        <select name="no_hp" class="select4 form-control" required>
                                <option value="" >Pilih Kontak</option>
                                @foreach($contact as $data)    
                                <option value="{{$data->telpon}}" >{{$data->nama}}</option>
                                @endforeach
                            </select> 
                        <br>
                        <label for="exampleInputEmail1">Tipe</label>
                        <select name="tipe" class="select4 form-control" required>
                                <option value="" >Pilih tipe</option>
                                @foreach($tipe_send as $data)
                                    @if(in_array($data->id,$tipe_send_umum))    
                                        <option value="{{$data->id}}" selected>{{$data->nama}}</option>
                                    @else
                                        <option value="{{$data->id}}" >{{$data->nama}}</option>
                                    @endif
                                @endforeach
                            </select> 
                        <br>
                        @error('data')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Pesan</label>
                        <textarea id="pesan" name="pesan" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Url file</label>
                        <textarea id="file" name="file" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button id="send" type="submit" class="btn btn-primary btn-sm"> Kirim</button>
                    </div>
                </form>

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

{{-- datatable --}}
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script> -->
{{-- end datatable --}}

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
<!-- <script src="{{ asset('js/jquery.betterdropdown.js') }}"></script> -->
<!-- <link rel="stylesheet" href="{{ asset('css/jquery.betterdropdown.css') }}"> -->
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





<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" crossorigin="anonymous"></script>
    <script>
        
   
        $(function () {
            $(document).ready(function () {
                $('#fileUploadForm1').ajaxForm({
                    beforeSend: function () {
                        var percentage = '0';
                        document.getElementById("send").disabled = true;
                    },
                    uploadProgress: function (event, position, total, percentComplete) {
                        // var percentage = percentComplete;
                        // $('.progress .progress-bar').css("width", percentage+'%', function() {
                        //   return $(this).attr("aria-valuenow", percentage) + "%";
                        // })
                    },
                    complete: function (xhr) {
                        // var percentage = percentComplete;
                        document.getElementById("pesan").value = null;
                        document.getElementById("file").value = null;
                        $('.progress .progress-bar').css("width",'100%')
                        $('.alert').removeClass('alert-success');
                        $('.alert').removeClass('alert-danger');
                        var hasil=xhr.responseJSON.status;
                        if(hasil=='true'){
                        $('.alert').addClass('alert-success').html(xhr.responseJSON.message);

                        }else{
                        $('.alert').addClass('alert-danger').html(xhr.responseJSON.message);

                        }
                        // await sleep(1);
                        setTimeout(() => {
                        $('.progress .progress-bar').css("width",'0%');
                        }, 1000);
                        document.getElementById("send").disabled = false;
                    }
                });

                
            });
        });
    </script>