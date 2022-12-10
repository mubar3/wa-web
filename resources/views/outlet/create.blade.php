@extends('master.master')

@section('outletActive','active')
@section('Collapse','show active')
@section('page_title',$title)

@section('konten')

      <div class="row">
        <div class="col-sm-6">
          <div class="card">
            <h6 class="card-header">
              {{ $title }}
            </h6>
            <div class="card-body box_filter">
                <form action="{{ url('/outlet') }}" method="POST" id="my-form">
                    @csrf

                    <div class="form-group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="">Region</label>
                            <select name="region" class="form-control select2" id="region">
                                <option value="">-- Region --</option>
                                @foreach ($region as $item)
                                    <option value="{{ $item->id }}">{{ $item->kode }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <label for="">Area</label>
                            <select name="area" class="form-control select2" id="area" disabled>
                                <option value="">-- Area --</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="">Nama Outlet</label>
                            <input class="form-control" type="text" name="nama" required="required">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Alamat</label>
                        <input class="form-control" type="text" name="alamat">
                    </div>

                  <hr>

                  <div class="form-buttons-w">
                    {!! xButton('','tambah') !!}
                    {!! xButton('/outlet') !!}
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
