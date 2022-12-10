@extends('master.master')

@section('pengaturanActive','active')
@section('page_title',$title)

@section('konten')

      <div class="row">
        <div class="col-sm-6">
          <div class="card">
            <h6 class="card-header">
              {{ $title }}
            </h6>
            <div class="card-body">
                <form action="{{ url('/roles',['role'=>$roles->id]) }}" method="POST" id="my-form">
                    @csrf
                    @method('PATCH')
                  <div class="form-group">
                    <label for="">Nama Roles</label>
                    <input class="form-control" type="name" name="nama" value="{{ $roles->nama }}">
                  </div>
                  <hr>
                  <div class="form-group">
                    <label for="">Roles Item</label>

                    <div class="float-right">
                        <input type="checkbox" id="checkAll" >
                        <label for="checkAll">Pilih semua</label>
                    </div>

                    <div style="width: 100%; height:300px; overflow-y:scroll;">
                        <table class="table table-striped">
                            <thead style="background: white !important">
                                <tr style="background: white !important">
                                    <th style="position: sticky !important; top:0; background-color: white;">Role Item</th>
                                    <th style="position: sticky !important; top:0; background-color: white;">Create</th>
                                    <th style="position: sticky !important; top:0; background-color: white;">Read</th>
                                    <th style="position: sticky !important; top:0; background-color: white;">Update</th>
                                    <th style="position: sticky !important; top:0; background-color: white;">Delete</th>
                                    <th style="position: sticky !important; top:0; background-color: white;">Print</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rolesitem as $item)
                                <tr>
                                    <td>
                                        {{ $item->nama }}
                                        <input type="hidden" name="role_items_id[]" value="{{ $item->id }}">
                                    </td>
                                    <td><input type="checkbox" name="create[{{ $item->id }}][]" {{ $item->create == 1 ? 'checked' : '' }}></td>
                                    <td><input type="checkbox" name="read[{{ $item->id }}][]" {{ $item->read == 1 ? 'checked' : '' }}></td>
                                    <td><input type="checkbox" name="update[{{ $item->id }}][]" {{ $item->update == 1 ? 'checked' : '' }}></td>
                                    <td><input type="checkbox" name="delete[{{ $item->id }}][]" {{ $item->delete == 1 ? 'checked' : '' }}></td>
                                    <td><input type="checkbox" name="print[{{ $item->id }}][]" {{ $item->print == 1 ? 'checked' : '' }}></td>
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
                  <div class="form-buttons-w">
                    {!! xButton('','edit') !!}
                    {!! xButton('/roles') !!}
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
    <script>
        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@endsection
