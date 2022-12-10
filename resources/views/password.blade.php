@php
$title_web='Password'
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

                <form action="{{ url('/ganti-password', ['profil' => $user->id]) }}" method="POST" id="my-form">
                    @csrf
                    @method('PATCH')
                  <div class="form-group">
                    <label for="">Sandi Lama</label>
                    <input class="form-control" type="password" name="sandi">
                  </div>
                  <div class="form-group">
                    <label for="">Sandi Baru</label>
                    <input class="form-control" type="password" name="password">
                  </div>
                  <div class="form-group">
                    <label for="">Konfirmasi Sandi</label>
                    <input class="form-control" type="password" name="password_confirmation">
                  </div>


                  {!! xButton('','tambah') !!}
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
