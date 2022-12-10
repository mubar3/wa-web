@extends('master.master')

@section('manpowerActive','active')
@section('page_title',$title)

@section('konten')
<form action="{{ url('/manpower',['manpower'=>$manpower->userid]) }}" method="POST" id="my-form">
@csrf
@method('PATCH')
    <div class="row">
        <div class="col-sm-4">
          <div class="card">
            <h6 class="card-header">
              {{ $title }}
            </h6>
            <div class="card-body box_filter">
                    <div class="form-group">
                        <label for="">Region</label>
                        <select name="region" class="form-control select2" id="region">
                            <option value="">-- Region --</option>
                            @foreach ($region as $item)
                                <option value="{{ $item->id }}" {{ ($item->id == $manpower->area->region_id) ? 'selected' : '' }}>{{ $item->kode }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Area</label>
                        <select name="area" class="form-control select2" id="area">
                            <option value="">-- Area --</option>
                            @foreach ($area as $item)
                                <option value="{{ $item->id }}" {{ $item->id == $manpower->area_id ? 'selected' : '' }}>{{ $item->area }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Jabatan</label>
                        <select name="jabatan" class="form-control select2">
                            <option value="">-- Jabatan --</option>
                            @foreach ($jabatan as $item)
                                <option value="{{ $item->jabatan_id }}" {{ $item->jabatan_id == $manpower->jabatan_id ? 'selected' : '' }}>{{ $item->jabatan_nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Supervisor</label>
                        <select name="spv" class="form-control select2">
                            <option value="">-- Supervisor --</option>
                            @foreach ($spv as $item)
                                <option value="{{ $item->userid }}" {{ $item->userid == $manpower->supervisor ? 'selected':'' }}>{{ $item->jabatan->jabatan_kode }} - {{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
              </div>
          </div>
        </div>

        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Username</label>
                        <input class="form-control" type="text" disabled value="{{ $manpower->username }}">
                    </div>
                    <div class="form-group">
                        <label for="">Nama Manpower</label>
                        <input class="form-control" type="text" name="nama" value="{{ $manpower->nama }}">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input class="form-control" type="text" name="email" value="{{ $manpower->email }}">
                    </div>
                    <div class="form-group">
                        <label for="">No. Telpon</label>
                        <input class="form-control" type="text" name="telpon" value="{{ $manpower->telp }}">
                    </div>
                    <div class="form-group">
                        <label for="">Target</label>
                        <input class="form-control" type="number" name="target" value="{{ $manpower->target }}">
                    </div>
                    <hr>

                    <div class="form-group">
                        <label for="">Password <small>Biarkan kosong jika tidak ingin mengganti sandi</small></label>
                        <input class="form-control" type="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="">Konfirmasi Password</label>
                        <input class="form-control" type="password" name="password_confirmation">
                    </div>
                    <hr>
                    <div class="form-buttons-w">
                        {!! xButton('', 'edit') !!}
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
    <script type="text/javascript">
        $('input[name="target"]').change(function() {
            let val = $(this).val();
            if(val < 0) $(this).val(0);
            else $(this).val(parseInt(val));
        });
    </script>
@endsection
