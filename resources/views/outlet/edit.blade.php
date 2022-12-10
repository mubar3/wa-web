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
                <form action="{{ url('/outlet',['outlet'=>$outlet->outlet_id]) }}" method="POST" id="my-form">
                    @csrf
                    @method('PATCH')

                    <div class="form-group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="">Area</label>
                            <select name="region" class="form-control select2" id="region">
                                <option value="">-- Region --</option>
                                @foreach ($region as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == $outlet->area->region_id ? 'selected' : '' }}>{{ $item->kode }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <label for="">Area</label>
                            <select name="area" class="form-control select2" id="area">
                                <option value="">-- Area --</option>
                                @foreach ($area as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == $outlet->outlet_area ? 'selected' : '' }}>{{ $item->area }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label for="">Kode Outlet</label>
                            <input class="form-control" type="text" name="kode" value="{{ $outlet->outlet_kode_gg }}" required="required" disabled>
                        </div>
                        <div class="col-sm-6">
                            <label for="">Nama Outlet</label>
                            <input class="form-control" type="text" name="nama" value="{{ $outlet->outlet_nama }}" required="required">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Alamat</label>
                        <input class="form-control" type="text" name="alamat" value="{{ $outlet->outlet_alamat }}">
                    </div>

                  <hr>

                  <div class="form-buttons-w">
                    {!! xButton('','edit') !!}
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
