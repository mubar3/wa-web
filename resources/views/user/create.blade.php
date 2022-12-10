@extends('master.master')

@section('pengaturanActive','active')
@section('page_title',$title)

@section('konten')
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <h6 class="card-header">
              {{ $title }}
            </h6>
            <div class="card-body">
                <form action="{{ url('/user') }}" method="POST" id="my-form">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Username</label>
                                    <input class="form-control" type="name" name="username">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Nama</label>
                                    <input class="form-control" type="name" name="nama">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input class="form-control" type="email" name="email">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">Region</label>
                                    <select name="region[]" class="form-control select2" id="region" multiple="multiple">
                                        @foreach ($region as $item)
                                            <option value="{{ $item->id }}">{{ $item->kode }}</option>
                                        @endforeach
                                    </select>
                                    <small>Untuk semua region biarkan kosong</small>
                                </div>
                            </div>
                            {{-- <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Area</label>
                                    <select name="area[]" class="form-control select2" id="area" multiple="multiple">
                                        @foreach ($area as $item)
                                            <option value="{{ $item->workarea_id }}">{{ $item->area }}</option>
                                        @endforeach
                                    </select>
                                    <small>Untuk semua area biarkan kosong</small>
                                </div>
                            </div> --}}
                        </div>

                        <div class="form-group">
                            <label for="">Cluster</label>
                            <select name="cluster" class="form-control select2" id="cluster">
                                <option value="">-- Semua Cluster --</option>
                                @foreach ($cluster as $item)
                                    <option value="{{ $item->cluster_id }}">{{ $item->cluster_nama }}</option>
                                @endforeach
                            </select>
                            <small>Biarkan kosong untuk pilih semua cluster</small>
                        </div>

                        <div class="form-group">
                            <label for="">Refresi User</label>
                            <select name="ma_id" class="form-control select2" id="spv">
                                <option value="">-- Pilih User --</option>
                                @foreach ($spv as $item)
                                    <option value="{{ $item->userid }}">{{ $item->nama }} - {{ $item->jabatan->jabatan_nama }} -  {{ $item->area->area }}</option>
                                @endforeach
                            </select>
                            <small>Biarkan kosong untuk menampilkan data dari semua user</small>
                        </div>
                    </div>
                    <div class="col-sm-1"></div>
                    <div class="col-sm-4">
                        <div class="form-group">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Roles</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($roles as $item)
                                <tr>
                                    <td>{{ $item->nama }}</td>
                                    <td><input type="checkbox" name="roles[]" value="{{ $item->id }}"></td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">Data tidak tersedia</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="form-buttons-w">
                    {!! xButton('', 'tambah') !!}
                    {!! xButton('/user') !!}
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
