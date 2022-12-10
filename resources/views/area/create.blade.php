@extends('master.master')

@section('areaActive','active')
@section('page_title',$title)

@section('konten')

      <div class="row">
        <div class="col-sm-6">
          <div class="card">
            <h6 class="card-header">
              {{ $title }}
            </h6>
            <div class="card-body">
                <form action="{{ url('/area') }}" method="POST" id="my-form">
                    @csrf
                    <div class="form-group">
                        <label for="">Nama Area</label>
                        <input class="form-control" type="text" name="nama" required="required">
                    </div>
                    <div class="form-group">
                        <label for="">Singkatan</label>
                        <input class="form-control" type="text" name="singkatan" required="required">
                    </div>

                  <hr>

                  <div class="form-buttons-w">
                    {!! xButton('','tambah') !!}
                    {!! xButton('/area') !!}
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
