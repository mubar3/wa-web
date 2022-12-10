@php
    $title_web='Bulk WA'
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
        
    </div>
</div>
<!-- <h4 style="text-align:center">Bulk WA</h4><br> -->
<div class="alert" role="alert"></div>
<div class="row">
    <div class="col-12">
                @if (session()->has('pesan_excel'))
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12">
                                                {!! session('pesan_excel') !!}
                                            </div>
                                        </div>
                                        @endif

             
        <label for="exampleInputEmail1">Contoh Format Excel</label>   
        <a href="{{ url('storage/pesan.xlsx') }}">Download</a>   <br>
        <!-- <img width="40%" src="{{ url('img/pesan_excel.png') }}" alt="userr"> -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <!--   <li class="nav-item" role="presentation">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">MAPS</a>
            </li> -->
                <form id="fileUploadForm" action="{{ url('/sent_wa_excel') }}"  enctype="multipart/form-data" method="POST" >
                <!-- <form id="my-form" action="{{ url('/sent_wa_excel') }}"  enctype="multipart/form-data" method="POST" > -->
                <!-- <form target="_blank" id="my-form" action="{{ url('/sent_wa_excel') }}"  enctype="multipart/form-data" method="POST" > -->
                     @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">File Excel (csv,xls,xlsx)</label>
                        <input id="file_excel" type="file" name="excel" class="form-control" >
                        <input type="hidden" name="user" value="{{ Auth::user()->id }}" class="form-control" >
                    </div>
                    <div class="form-group">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button id="send" type="submit" class="btn btn-primary btn-sm"> Upload Excel</button>
                        <!-- <input  type="submit" value="submit" class="btn btn-primary btn-sm"> -->
                    </div>
                </form>



        </ul>
                
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
<!-- {{-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgTb1CFpkhDxfrNFKLP9bwGErvC1VP9Ew"></script> --}}
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmWwiQKyJhiwyFrW6DSWR-nrlbUFcguDs"></script>
<script src="{{ url('/js/clustermap.js') }}"></script> -->

{{-- datatable --}}
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css"> -->
<!-- <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script> -->
<!-- <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script> -->
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

<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" crossorigin="anonymous"></script>

    <script>
    var intervalId = null;
    var varCounter = 0;
    var varName = function(){
         if(varCounter == 0) {
            $.ajax({
                url: '{{ url('/sent_wa_cek') }}',
                data: {
                }
              })
              .done(function(data) {
                console.log(data);

                // alert(data);
                if(data>0){

                                // document.getElementById("send").disabled = true;
                }
                if(data<100){
                $('.progress .progress-bar').css("width", data+'%', function() {
                                  return $(this).attr("aria-valuenow", data) + "%";
                                })
                }
                if(data=='100'){
                                varCounter = 1;
                                document.getElementById("file_excel").value = null;
                                $('.progress .progress-bar').css("width", data+'%', function() {
                                  return $(this).attr("aria-valuenow", data) + "%";
                                })  
                                $('.alert').addClass('alert-success').html("Berhasil");
                                setTimeout(() => {
                                $('.progress .progress-bar').css("width","0%");
                                }, 1000);
                                document.getElementById("send").disabled = false;
                                }

              })
              .fail(function(data) {
                console.log(data);
              });
         } else {
              clearInterval(intervalId);
         }
    };

    // setInterval(function() {

    //     $.ajax({
    //     url: '{{ url('/sent_wa_cek') }}',
    //     data: {
    //     }
    //   })
    //   .done(function(data) {
    //     console.log(data);

    //     // alert(data);
    //     if(data>0){

    //                     // document.getElementById("send").disabled = true;
    //     }
    //     if(data<100){
    //     $('.progress .progress-bar').css("width", data+'%', function() {
    //                       return $(this).attr("aria-valuenow", data) + "%";
    //                     })
    //     }
    //     if(data=='100'){
    //                     document.getElementById("file_excel").value = null;
    //                     $('.progress .progress-bar').css("width", data+'%', function() {
    //                       return $(this).attr("aria-valuenow", data) + "%";
    //                     })  
    //                     $('.alert').addClass('alert-success').html("Berhasil");
    //                     setTimeout(() => {
    //                     $('.progress .progress-bar').css("width","0%");
    //                     }, 1000);
    //                     document.getElementById("send").disabled = false;
    //                     }

    //   })
    //   .fail(function(data) {
    //     console.log(data);
    //   });
    //  },1000);


        $(function () {
            $(document).ready(function () {
                $('#fileUploadForm').ajaxForm({
                    beforeSend: function () {
                        var percentage = '0';
                        document.getElementById("send").disabled = true;
                        varCounter = 0;
                        intervalId = setInterval(varName, 1000);
                    },
                    uploadProgress: function (event, position, total, percentComplete) {
                        // var percentage = percentComplete;
                        // $('.progress .progress-bar').css("width", percentage+'%', function() {
                        //   return $(this).attr("aria-valuenow", percentage) + "%";
                        // })
                    },
                    complete: function (xhr) {
                        var hasil=xhr.responseJSON.status;
                        if(hasil=='false'){
                        $('.alert').addClass('alert-danger').html("Gagal");

                        }
                        varCounter = 1;
                        console.log('File has uploaded');
                        document.getElementById("file_excel").value = null;
                        document.getElementById("send").disabled = false;
                    }
                });

                
            });
        });
    </script>