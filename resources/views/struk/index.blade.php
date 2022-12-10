@extends('master.master')

@section('strukActive','active')
@section('page_title', $title)

@section('konten')

      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <h6 class="card-header">
              {{ $title }}
            </h6>
            <div class="card-body box_filter">
                @if (session()->has('pesan'))
                    {!! session('pesan') !!}
                @endif

                {{-- <form action="{{ url('/struk/export') }}" method="POST"> --}}
                {{-- @csrf --}}
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
                        <button type="button" class="btn btn-sm btn-warning" onclick="getList()">GO</button>
                        <button type="button" class="btn btn-sm btn-default" title="Filter tambahan" onclick="filterTambahan()"><i class="feather-filter"></i></button>
                        <button type="button" class="btn btn-sm btn-default" onclick="resetList()"><i class="feather-rotate-ccw"></i></button>
                    </div>
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

                                        <div class="col-sm-4">
                                            <select name="status" class="form-control select2" id="status">
                                                <option value="">--Status--</option>
                                                <option value="0">Belum Diproses</option>
                                                <option value="1">Disetujui</option>
                                                <option value="2">Ditolak</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                {{-- </form> --}}

                <hr>

                <table class="table table-hover table-sm data-list">
                    <thead>
                        <tr>
                            <th width="20">No.</th>
                            <th>Region</th>
                            <th width="120">area</th>
                            <th>NA</th>
                            <th>nama</th>
                            <th>Foto</th>
                            <th>status</th>
                            <th>Alasan</th>
                            <th>time input</th>
                        </tr>
                    </thead>
                </table>
            </div>
          </div>
        </div>

      </div>

      <div class="modal fade" id="strukModal" tabindex="-1" aria-labelledby="strukModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="strukModalLabel">Detail Struk</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="struk-notif"></div>
                <div class="row">
                    <div class="col-sm-12"><input type="hidden" id="idstruk" name="idstruk" value=""></div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6"><div id="strukDetail"></div></div>
                            <div class="col-sm-6"><div id="strukDetail2"></div></div>
                            <div class="col-sm-6"><div id="strukDetail3"></div></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-12"><div id="unikDetail"></div></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xs modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Tolak</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <label for="">Berikan alasan</label>
               <input type="text" class="form-control" name="alasan">
            </div>
            <div class="modal-footer" id="buttonConfirm">
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

<script>
    getList();

    function resetList(){
        $('select[name="region"]').val('').trigger('change');
        $('select[name="area"]').val('').trigger('change');
        $('select[name="status"]').val('').trigger('change');
        $('input[name="cari"]').val('');

        getList();
    }

    function filterTambahan(){
        $('#box_filter').toggle('slow');
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
                url  : "/ajaxStruk",
                type : "POST",
                data : function(d){
                    d._token = $("input[name=_token]").val();
                    d.tmulai = $('input[name="tmulai"]').val();
                    d.takhir = $('input[name="takhir"]').val();
                    d.cari = $('input[name="cari"]').val();
                    d.region = $('select[name="region"]').val();
                    d.area = $('select[name="area"]').val();
                    d.cluster = $('select[name="cluster"]').val();
                    d.status = $('select[name="status"]').val();
                },
            },
            columns: [
                { data: 'nomor'},
                { data: 'region'},
                { data: 'area'},
                { data: 'username'},
                { data: 'nama'},
                { data: 'foto'},
                { data: 'status'},
                { data: 'alasan_reject'},
                { data: 'tgl_input'},
            ]
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

    function openImage(id, e){
        e.preventDefault();
        $.ajax({
            type : 'POST',
            url  : '/getStrukUnik',
            data : {
                _token : $('input[name="_token"]').val(),
                idstruk: id
            },
            success : function(msg){
                var strukid = msg.strukid;
                var struk = msg.struk;
                var produk= msg.produk;
                var konsumen = msg.konsumen;
                var video    = msg.video;
                var status_acc = msg.status_acc;

                console.log(video);

                if(video == ''){
                    var link_video = '';
                }else{
                    var link_video = '<video width="400" controls><source width="100%" src="{{urlTes("video")}}'+video+'" type="video/mp4">Your browser does not support HTML video.</video>';
                }

                if(status_acc == '0'){
                    var button_approve = '<button type="button" class="btn btn-secondary" onclick="prosesStruk(\'tolak\')">Tolak</button> <button type="button" class="btn btn-primary" onclick="prosesStruk(\'setuju\')">Setujui</button>';
                }else{
                    var button_approve = '';
                }

                $('#strukModal').modal('show');
                $('.modal-footer').html(button_approve);

                $('#idstruk').val(id);
                $('#strukDetail').html('<h6>STRUK | #'+strukid+'</h6><hr>'+struk+'<h6>');
                $('#strukDetail2').html('<h6>KONSUMEN</h6><hr>'+konsumen);
                $('#strukDetail3').html(link_video);

                $('#unikDetail').html('');
                $(produk).each(function(index, val){
                    var foto_unik = '<div><img width="90%" class="rounded" src="{{urlTes()}}'+val.foto_unik+'"></div>';
                    var kode_unik = val.kode_unik;
                    var produk_nama= val.produk_nama;

                    var detailStruk = '<h6>'+produk_nama+' | '+kode_unik+'</h6><hr>'+foto_unik+'<br><hr><br>';
                    $('#unikDetail').append(detailStruk);
                });
            }
        });
        return false;
    }

function prosesStruk(label){
    var idstruk = $('#idstruk').val();
    if(label == 'tolak'){
        var textInfo = 'Anda yakin ingin menolak struk ini?';
        var btnInfo  = 'Tolak';
    }else{
        var textInfo = 'Anda yakin ingin menyetujui struk ini?';
        var btnInfo  = 'Setuju';
    }

    if(label == 'tolak'){
        $('#confirmModal').modal('show');
        $('#buttonConfirm').html('<button class="btn btn-primary" onclick="prosesConfirm()">Proses</button>');

    }else{
        Swal.fire({
                title : 'Perhatian',
                text  : textInfo,
                icon  : 'warning',
                width : '20rem',
                confirmButtonText : btnInfo,
                cancelButtonText : 'Batal',
                showCancelButton : true,
            }).then((result) => {
                if(result.isConfirmed){
                    $.ajax({
                        type : 'POST',
                        url  : '/prosesStruk',
                        data : {
                            _token : $('input[name="_token"]').val(),
                            idstruk: idstruk,
                            label  : label,
                            alasan : '',
                        },
                        success : function(msg){
                            if(msg.status == true){
                                $('.struk-notif').html('<span class="alert alert-success">'+msg.pesan+'</span>');
                                getList();

                                setTimeout(() => {
                                    $('#strukModal').modal('hide');
                                }, 1500);
                            }
                        }
                    });
                    return false;
                }
        });
    }
    return false;
}

function prosesConfirm(){
    var idstruk = $('#idstruk').val();
    var alasan  = $('input[name="alasan"]').val();

    $.ajax({
        type : 'POST',
        url  : '/prosesStruk',
        data : {
            _token : $('input[name="_token"]').val(),
            idstruk: idstruk,
            label  : 2,
            alasan : alasan,
        },
        success : function(msg){
            if(msg.status == true){
                $('.struk-notif').html('<span class="alert alert-success">'+msg.pesan+'</span>');
                getList();

                setTimeout(() => {
                    $('#strukModal').modal('hide');
                }, 1500);
            }
            $('#confirmModal').modal('hide');
        }
    });
    // return false;
}

</script>
@endsection
