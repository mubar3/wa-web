@extends('master.master')

{{-- @section('pengaturanActive','active') --}}
@section('page_title',$title)

@section('konten')

      <div class="row">
        <div class="col-sm-4">
          <div class="card">
            <h6 class="card-header">
              {{ $title }}
            </h6>
            @foreach ($roles as $item)
                <div class="card-body">
                    <a href="{{ url('/roles/pilih',$item->id) }}" class="btn btn-primary">{{ $item->nama }}</a>
                </div>
            @endforeach
          </div>
        </div>

      </div>

@endsection
