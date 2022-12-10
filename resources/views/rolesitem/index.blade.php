@extends('master.master')

@section('pengaturanActive','active')
@section('page_title', $title)

@section('konten')

      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <h6 class="card-header">
              {{ $title }}
            </h6>
            <div class="card-body">
                @if (session()->has('pesan'))
                    {!! session('pesan') !!}
                @endif



                <div class="row">
                    <div class="col-sm-8"></div>
                    <div class="col-sm-4">
                        @if (hakAksesMenu('rolesitem','create'))
                            {!! xButton('/rolesitem/create', 'tambah_view') !!}
                        @endif
                    </div>
                </div>

                <table class="table table-sm table-hover data-list">
                    <thead>
                        <tr>
                            <th>Roles Item</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
          </div>
        </div>

      </div>

@endsection

@section('my-script')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
<script>
    var data_list = $('.data-list').DataTable({
        processing: true,
        serverSide: true,
        searching : false,
        lengthChange : false,
        pageLength  : 10,
        ajax: {
            url  : "/ajaxRolesItem",
            type : "POST",
            data : function(d){
                d._token = $("input[name=_token]").val();
            },
        },
        columns: [
            { data: 'nama'},
            { data: 'aksi'},
        ]
    });
</script>
@endsection
