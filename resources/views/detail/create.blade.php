@extends('master.master')

@section('manpowerActive','active')
@section('page_title',$title)

@section('konten')
<form action="{{ url('/manpower') }}" method="POST" id="my-form">
@csrf
    <div class="row">
        <div class="col-sm-4">
          <div class="card">
            <h6 class="card-header">
              {{ $title }}
            </h6>
            <div class="card-body">
                    <div class="form-group">
                        <label for="">Area</label>
                        <select name="area" class="form-control select2">
                            <option value="">-- Area --</option>
                            @foreach ($area as $item)
                                <option value="{{ $item->id }}">{{ $item->area }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Jabatan</label>
                        <select name="jabatan" class="form-control select2">
                            <option value="">-- Jabatan --</option>
                            @foreach ($jabatan as $item)
                                <option value="{{ $item->jabatan_id }}">{{ $item->jabatan_nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Supervisor</label>
                        <select name="spv" class="form-control select2">
                            <option value="">-- Supervisor --</option>
                            @foreach ($spv as $item)
                                <option value="{{ $item->userid }}">{{ $item->jabatan->jabatan_nama }} - {{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
              </div>
          </div>
        </div>

        <div class="col-sm-4">
            <div class="card">
                <h6 class="card-header">
                    {{ $title }}
                </h6>
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Username</label>
                        <input class="form-control" type="text" name="username">
                    </div>
                    <div class="form-group">
                        <label for="">Nama Manpower</label>
                        <input class="form-control" type="text" name="nama">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input class="form-control" type="text" name="email">
                    </div>
                    <div class="form-group">
                        <label for="">No. Telpon</label>
                        <input class="form-control" type="text" name="telpon">
                    </div>
                    <hr>
                    <div class="form-buttons-w">
                      {!! xButton('','tambah') !!}
                      {!! xButton('/manpower') !!}
                    </div>
                </div>
            </div>
          </div>
    </div>
</form>
@endsection

@section('my-script')
    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! $validator->selector('#my-form') !!}
@endsection
