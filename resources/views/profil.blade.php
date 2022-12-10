@php
$title_web='Profile'
@endphp

@extends('master.master')

@section('page_title',$title)

@section('konten')

      <div class="row">
        <div class="col-sm-6">
          <div class="card">
            <h6 class="card-header">
              {{ $title }}
            </h6>

            <div class="card-body">
                @if (session()->has('pesan'))
                    {!! session('pesan')  !!}
                @endif

                <form action="{{ url('/profil', ['profil' => $user->id]) }}" method="POST" enctype="multipart/form-data" id="my-form">
                    @csrf
                    @method('PATCH')
                  <div class="form-group">
                    <label for="">Username</label>
                    <input class="form-control" type="name" name="username" value="{{ $user->username }}" disabled>
                  </div>
                  <div class="form-group">
                    <label for="">Nama</label>
                    <input class="form-control" type="name" name="nama" value="{{ $user->nama }}" required>
                  </div>
                  <div class="form-group">
                    <label for="">Email</label>
                    <input class="form-control" type="email" name="email" value="{{ $user->email }}" required>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-8">
                        <label for="">Foto</label>
                        <input class="form-control" type="file" name="foto" >
                    </div>
                    <div class="col-sm-4">
                        <img src="{{ url('storage/foto/'.Auth::user()->foto) }}" alt="" width="100">
                        <!-- <img src="{{ url('app/public/foto/').Auth::user()->foto }}" alt="" width="100"> -->
                    </div>
                  </div>

                  <div class="form-buttons-w">
                    {!! xButton('','tambah') !!}
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
