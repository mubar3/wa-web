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
                <form action="{{ url('/roles') }}" method="POST" id="my-form">
                    @csrf
                  <div class="form-group">
                    <label for="">Nama Roles</label>
                    <input class="form-control" type="name" name="nama" required="required">
                  </div>

                  <hr>
                  <div class="form-group">
                    <label for="">Roles Item</label>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Role Item</th>
                                <th>Create</th>
                                <th>Read</th>
                                <th>Update</th>
                                <th>Delete</th>
                                <th>Print</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rolesitem as $item)
                            <tr>
                                <td>
                                    {{ $item->nama }}
                                    <input type="hidden" name="role_items_id[]" value="{{ $item->id }}">
                                </td>
                                <td><input type="checkbox" name="create[{{ $item->id }}][]"></td>
                                <td><input type="checkbox" name="read[{{ $item->id }}][]"></td>
                                <td><input type="checkbox" name="update[{{ $item->id }}][]"></td>
                                <td><input type="checkbox" name="delete[{{ $item->id }}][]"></td>
                                <td><input type="checkbox" name="print[{{ $item->id }}][]"></td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Data tidak tersedia</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                  </div>

                  <div class="form-buttons-w">
                    {!! xButton('','tambah') !!}
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
@endsection
