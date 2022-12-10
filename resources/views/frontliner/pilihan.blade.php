@extends('master.master')

{{-- @section('pengaturanActive','active') --}}
@section('page_title',$title)

@section('konten')
<div class="content-i">
    <div class="content-box">
      <div class="row">
        <div class="col-sm-4">
          <div class="element-wrapper">
            <h6 class="element-header">
              {{ $title }}
            </h6>
            @foreach ($roles as $item)
                <div class="element-box el-tablo">
                    <a href="{{ url('/roles/pilih',$item->id) }}" class="btn btn-primary">{{ $item->nama }}</a>
                </div>
            @endforeach
          </div>
        </div>

      </div>
    </div>
</div>
@endsection
