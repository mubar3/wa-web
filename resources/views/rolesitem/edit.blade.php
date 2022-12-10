@extends('master.master')

@section('pengaturanActive','active')
@section('page_title',$title)

@section('konten')

      <div class="row">
        <div class="col-sm-6">
          <div class="card">
            <h6 class="card-header">
              {{ $title }}
            </h6>
            <div class="card-body">
                <form action="{{ url('/rolesitem',['rolesitem'=>$rolesitem->id]) }}" method="POST" id="my-form">
                    @csrf
                    @method('PATCH')
                  <div class="form-group">
                    <label for="">Nama Roles Item</label>
                    <input class="form-control" type="name" name="nama" value="{{ $rolesitem->nama }}">
                  </div>
                  <div class="form-buttons-w">
                    {!! xButton('','edit') !!}
                    {!! xButton('/rolesitem') !!}
                  </div>
                </form>
              </div>
          </div>
        </div>
      </div>

@endsection

@section('my-script')
    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! $validator->selector('#my-form') !!}
@endsection
