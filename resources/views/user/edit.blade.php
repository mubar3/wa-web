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
                <form action="{{ url('/user',['user'=>$user->userid]) }}" method="POST" enctype="multipart/form-data" id="my-form">
                    @csrf
                    @method('PATCH')

                    <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Username</label>
                                    <input class="form-control" type="name" name="username" value="{{ $user->username }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Nama</label>
                                    <input class="form-control" type="name" name="nama" value="{{ $user->nama }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input class="form-control" type="email" name="email" value="{{ $user->email }}">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">Region</label>
                                    <select name="region[]" class="form-control select2" multiple="multiple">
                                        @if ($userarea == null)
                                            @foreach ($region as $item)
                                            <option value="{{ $item->id }}">{{ $item->kode }}</option>
                                            @endforeach

                                        @else
                                            @foreach ($region as $item)
                                                @if (in_array($item->id, $regionids))
                                                    <option value="{{ $item->id }}" selected="true">{{ $item->kode }}</option>
                                                @else
                                                    <option value="{{ $item->id }}">{{ $item->kode }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    <small>Untuk semua area biarkan kosong</small>
                                </div>
                            </div>

                            {{-- <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Area</label>
                                    <select name="area[]" class="form-control select2" multiple="multiple">
                                        @if ($userarea == null)
                                            @foreach ($area as $item)
                                            <option value="{{ $item->workarea_id }}">{{ $item->area }}</option>
                                            @endforeach

                                        @else
                                            @foreach ($area as $item)
                                                @if (in_array($item->workarea_id, $areaids))
                                                    <option value="{{ $item->workarea_id }}" selected="true">{{ $item->area }}</option>
                                                @else
                                                    <option value="{{ $item->workarea_id }}">{{ $item->area }}</option>
                                                @endif
                                            @endforeach
                                        @endif
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
                                    <option {{ $item->cluster_id == $userarea->cluster_id ? 'selected' : '' }}  value="{{ $item->cluster_id }}">{{ $item->cluster_nama }}</option>
                                @endforeach
                            </select>
                            <small>Biarkan kosong untuk pilih semua cluster</small>
                        </div>
                        <div class="form-group">
                            <label for="">Refresi User</label>
                            <select name="ma_id" class="form-control select2" id="spv">
                                <option value="">-- Pilih User --</option>
                                @foreach ($spv as $item)
                                    <option {{ $item->userid == $user->ma_id ? 'selected' : '' }} value="{{ $item->userid }}">{{ $item->nama }} - {{ $item->jabatan->jabatan_nama }} -  {{ $item->area->area }}</option>
                                @endforeach
                            </select>
                            <small>Biarkan kosong untuk menampilkan data dari semua user</small>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Ganti Sandi</label>
                                    <input class="form-control" type="password" name="password">
                                    <small>Biarkan kosong jika tidak ingin mengganti sandi</small>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Konfirmasi Sandi</label>
                                    <input class="form-control" type="password" name="password_confirmation">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-1"></div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="">Foto</label>
                            <input class="form-control" type="file" name="foto">
                        </div>
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
                                    <td><input type="checkbox" name="roles[]" {{ $item->user_userid !== NULL ? 'checked' : '' }} value="{{ $item->id }}"></td>
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
                    <div class="col-sm-2">
                        <img src="{{ url('/storage/foto/'.$user->foto) }}" alt="" width="80">
                    </div>
                    </div>

                  <hr>

                  <div class="form-buttons-w">
                    {!! xButton('', 'edit') !!}
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
