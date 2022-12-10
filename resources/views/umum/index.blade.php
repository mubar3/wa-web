@extends('master.master')

@section('pengaturanActive','active')
@section('page_title',$title)

@section('konten')

      <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{ $title }}</h6>
                    <form action="{{ url('/umum',['umum'=>1]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        @if (session()->has('pesan'))
                            {!! session('pesan') !!}
                        @endif

                        <div class="form-group">
                            <label for="exampleInputUsername1">Nama Website</label>
                            <input type="text" class="form-control" name="nama" value="{{ $item->nama }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Logo</label>
                            <input class="form-control" type="file" name="logo">
                            <img src="{{ url('storage/'.$item->logo) }}" alt="" width="200">
                        </div>

                        {!! xButton('','tambah') !!}
                    </form>
              </div>
            </div>
	    </div>

      </div>

@endsection
