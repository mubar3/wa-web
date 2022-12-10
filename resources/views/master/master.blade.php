<!DOCTYPE html>
<html>
  <head>
    <title>@yield('page_title', $page_title)</title>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="{{ asset('/img/favicon.png') }}" rel="shortcut icon">
	<link rel="stylesheet" href="{{ asset('/css/admin.css') }}">
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/6e703c102f.js" crossorigin="anonymous"></script>
    <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">  -->


  </head>
  <body class="sidebar-dark">
    <div class="main-wrapper">
        @include('master.sidebar')

        <div class="page-wrapper">
            @include('master.topnavbar')

            <div class="page-content">
                @yield('konten')
            </div>
        </div>

        {{-- <footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between">
            <p class="text-muted text-center text-md-left">Copyright © 2020 <a href="https://www.nobleui.com" target="_blank">NobleUI</a>. All rights reserved</p>
            <p class="text-muted text-center text-md-left mb-0 d-none d-md-block">Handcrafted With <i class="mb-1 text-primary ml-1 icon-small" data-feather="heart"></i></p>
        </footer> --}}

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_status" value="">
    </div>

    <script src="{{ asset('js/admin.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" integrity="sha512-7x3zila4t2qNycrtZ31HO0NnJr8kg2VI67YLoRSyi9hGhRN66FHYWr7Axa9Y1J9tGYHVBPqIjSE1ogHrJTz51g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
    @yield('my-script','')
    <script src="{{ asset('js/master.js') }}"></script>
      <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" crossorigin="anonymous"></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css"> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    {{-- datatable --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
{{-- end datatable --}}



  </body>
</html>

                            
<script type="text/javascript">
    $(document).ready(function(){
         $(".select4").select2({
          tags: true
        });
    });
</script>


<script type="text/javascript">
    var myTable;
    $(document).ready(function () {
        myTable = $('#table1').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": false,
            "info": false,
            "autoWidth": false,
            "sDom": 'lfrtip'
        });
    //     myTable.row.add( {
    //     "0": "Tiger Nixon",
    //     "1": "System Architect",
    //     "2": "$3,120",
    //     "3": "2011/04/25",
    //     "4": "Edinburgh",
    // } ).draw();

    });
       
</script>