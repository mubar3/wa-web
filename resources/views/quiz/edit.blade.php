@extends('master.master')

@section('quizActive','active')
@section('Collapse','show active')
@section('page_title',$title)

@section('konten')

      <div class="row">
        <div class="col-sm-6">
          <div class="card">
            <h6 class="card-header">
              {{ $title }}
            </h6>
            <div class="card-body box_filter">
                <form action="{{ url('/quiz',['pkmodule'=>$pkmodule->idpk_module]) }}" method="POST" id="my-form">
                    @csrf
                    @method('PATCH')

                    <input type="hidden" name="idpk_module" class="form-control" value="{{ $pkmodule['idpk_module'] }}">

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="">Nama Quiz</label>
                            <input class="form-control" type="text" name="module_name" required="required" value="{{ $pkmodule['module_name'] }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Kategori</label>
                        <select name="kategori" class="form-control select2" id="kategori">
                            <option value="Basic Nutrition Test" {{ $pkmodule['kategori'] == 'Basic Nutrition Test' ? 'selected' : '' }}>Basic Nutrition Test</option>
                            <option value="Product Knowledge Test" {{ $pkmodule['kategori'] == 'Product Knowledge Test' ? 'selected' : '' }}>Product Knowledge Test</option>
                        </select>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="">Periode</label>
                            <input type="text" name="periode" class="form-control tPeriode" value="{{ $periode }}">
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <label for="">Durasi</label>
                            <input type="text" name="durasi_quiz" class="form-control tDurasiQuiz" value="{{ $duration }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 col-xs-12">
                            <label for="">Time Start</label>
                            <input type="text" name="time_start" class="form-control tDateshow" value="{{ $time_start }}">
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <label for="">Time End</label>
                            <input type="text" name="time_end" class="form-control tDateshow" value="{{ $time_end }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Jabatan</label>
                        <select name="jabatan[]" class="form-control select2" id="jabatan" multiple="multiple">
                            @foreach ($jabatan as $item)
                                @if (in_array($item->jabatan_id, $jabatan_id_arr))
                                    <option value="{{ $item->jabatan_id }}" selected="true">{{ $item->jabatan_kode }}</option>
                                @else
                                    <option value="{{ $item->jabatan_id }}">{{ $item->jabatan_kode }}</option>
                                @endif
                            @endforeach
                        </select>
                        <small>Untuk semua jabatan biarkan kosong</small>
                    </div>

                  <hr>

                  <div class="form-buttons-w">
                    {!! xButton('', 'edit') !!}
                    {!! xButton('/quiz') !!}
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

{{-- flatpicker --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
{{-- plugin month select --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/style.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/index.js"></script>
{{-- end flatpicker --}}

<script>
   // Tanggal Flat
   flatpickr('.tPeriode',{
        plugins: [
            new monthSelectPlugin({
            shorthand: true, //defaults to false
            dateFormat: "Y-m", //defaults to "F Y"
            altFormat: "F Y", //defaults to "F Y"
            theme: "light" // defaults to "light"
            })
        ]
    });

    flatpickr('.tDateshow',{
        enableTime: true,
        time_24hr: true,
        // timeFormat: "H:i",
        dateFormat: "Y-m-d H:i",
        monthSelectorType: 'static',
        minDate: "today"
    });

    flatpickr('.tDurasiQuiz',{
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        minTime: "00:30"
    });

    function updatetAkhir(tgl){
        var date = new Date(tgl);
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        var tanggal = formatDate(lastDay);
        $('.tAkhir').val(tanggal);
        $('.tAkhir').flatpickr(function(){
            defaultDate : ''+tanggal+''
        });
    }

    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }
</script>
@endsection
