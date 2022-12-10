@extends('master.master')

@section('visitActive','active')
@section('page_title', $title)

@section('konten')

      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <form action="{{ url('/visit/export') }}" method="POST">
            <h6 class="card-header">
              {{ $title }}

              @if (hakAksesMenu('visit','print'))

                @csrf
                {!! xButton('', 'print') !!}

                <button type="submit" name="exportImage" value="exportImage" class="btn btn-sm btn-primary float-right">Export Image</button>

              @endif
            </h6>
            <div class="card-body box_filter">
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

                    @if (session('cluster_id') == null)
                    <div class="col-sm-2">
                        <select name="cluster" class="form-control select2" id="cluster">
                            <option value="">--Cluster--</option>
                            @foreach ($cluster as $item)
                                <option value="{{ $item->cluster_id }}">{{ $item->cluster_nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="col-sm-2">
                        <select name="region" class="form-control select2" id="region">
                            <option value="">--Region--</option>
                            @foreach ($region as $item)
                                <option value="{{ $item->id }}">{{ $item->kode }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-2">
                        <select name="area" class="form-control select2" id="area" disabled>
                            <option value="">--Area--</option>
                        </select>
                    </div>

                    <div class="col-sm-2">
                        <input type="text" name="cari" class="form-control" placeholder="Cari Username / Nama">
                    </div>

                    <div class="col-sm-2">
                        <a href="#" class="btn btn-sm btn-warning" onclick="getList()">GO</a>
                        <a href="#" class="btn btn-sm btn-default" onclick="reset()"><i class="feather-rotate-ccw"></i></a>
                    </div>
                </div>
            </form>

                <hr>

                <table class="table table-hover table-sm data-list">
                    <thead>
                        <tr>
                            <th width="250">User</th>
                            <th width="80">area</th>
                            <th width="200">outlet</th>
                            <th>Checkin</th>
                            <th>Checkout</th>
                        </tr>
                    </thead>
                </table>
            </div>
          </div>
        </div>

      </div>

      {{-- modal Maps --}}
      <div class="modal modal-maps" tabindex="-1">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">xxx</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="modal-foto"></div>
                        <h2 class="modal-nama" style="font-size:1.3rem; margin:5px 0; "></h2>
                        <div class="modal-alamat" style="font-size: .8rem; margin-bottom:10px;"></div>
                        <div class="modal-tanggal"></div>
                        <div class="modal-outlet"></div>
                    </div>
                    <div class="col-sm-9">
                        <div id="modal-maps" style="height: 500px"></div>
                    </div>
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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

{{-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgTb1CFpkhDxfrNFKLP9bwGErvC1VP9Ew"></script> --}}
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmWwiQKyJhiwyFrW6DSWR-nrlbUFcguDs"></script>

<script>
    getList();

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
        $('input[name="cari"]').val('');

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
                url  : "/ajaxVisit",
                type : "POST",
                data : function(d){
                    d._token = $("input[name=_token]").val();
                    d.cari = $('input[name="cari"]').val();
                    d.tmulai = $('input[name="tmulai"]').val();
                    d.takhir = $('input[name="takhir"]').val();
                    d.cluster = $('select[name="cluster"]').val();
                    d.region = $('select[name="region"]').val();
                    d.area = $('select[name="area"]').val();
                },
            },
            columns: [
                { data: 'userdetail'},
                { data: 'area'},
                { data: 'outlet'},
                { data: 'checkin'},
                { data: 'checkout'},
            ]
        });
    }

    $('.data-list').on('click','.visit_btn', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var modal_lat = $(this).data('lat');
        var modal_long = $(this).data('long');
        var modal_foto = $(this).data('foto');
        var modal_nama = $(this).data('nama');
        var modal_alamat = $(this).data('alamat');
        var modal_tanggal = $(this).data('tanggal');
        var modal_outlet = $(this).data('outlet');
        var title = $(this).data('title');

        // alert(modal_lat+'----'+modal_long);

        $('.modal-maps').modal('show');
        $('.modal-title').text(title);
        $('.modal-foto').html('<div style="width:100%; height:310px; overflow:hidden;"><img width="100%" src="{{urlTes()}}'+modal_foto+'"></div>');
        $('.modal-alamat').text(modal_alamat);
        $('.modal-nama').text(modal_nama);
        $('.modal-tanggal').html('<div class="badge badge-default">'+modal_tanggal+'</div>');
        $('.modal-outlet').text(modal_outlet);

        // maps
        const posisi = { lat: modal_lat, lng: modal_long };
        const map    = new google.maps.Map(document.getElementById("modal-maps"), {
            zoom  : 16,
            center: posisi,
        });

        addMarker(posisi, map,'I','green');
    });

    function addMarker(location,map,label,warna) {
        new google.maps.Marker({
        position: location,
        // label: label,
        map: map,
        icon : {
            url : 'http://maps.google.com/mapfiles/ms/icons/'+warna+'-dot.png',
        },
        animation: google.maps.Animation.BOUNCE
        });
    }

    function ExportImage(){
        document.location.href = '{{url("/visit/exportImage")}}';
    }

</script>
@endsection
