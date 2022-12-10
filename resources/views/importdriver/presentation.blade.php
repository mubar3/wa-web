<div class="bg-white pt-4 px-3 pb-3 border-right border-left border-bottom">
    <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <form action="{{ url('/import/export') }}" method="POST">
            @csrf

            <h6 class="card-header p-3">
              {{ $title }}

                @if (hakAksesMenu('import','create'))
                    {{-- <div class="col-sm-12"> --}}
                        <button type="button" class="btn btn-sm btn-outline-danger float-right" onclick="importModalPresentation()">
                            Import
                        </button>
                    {{-- </div> --}}
                @endif

                @if (hakAksesMenu('import','print'))
                    <a href="{{ url('/importdriver/templatepresentation') }}" class="float-right btn btn-sm btn-link"><i class="feather-file-text"></i> Template Presentation</a>
                @endif

            </h6>
            <div class="card-body">
                @if (session()->has('pesan'))
                    {!! session('pesan') !!}
                @endif

            </form>

                <div style="text-align: center; margin-bottom:30px; display:none;" class="loadingitt">Loading....</div>
                <table class="table table-hover table-sm data-list-presentation">
                    <thead>
                        <tr>
                            <th width="10">No.</th>
                            <th width="20">Region</th>
                            <th width="30">Area</th>
                            <th width="40">NIK</th>
                            <th width="50">NA</th>
                            <th width="50">TC</th>
                            <th width="50">Join Date</th>
                            <th width="30">Status</th>
                            <th width="20">Tahun</th>
                            <th width="10">Kuartal</th>
                            <th width="40">Nilai</th>
                        </tr>
                    </thead>
                </table>
            </div>
          </div>
        </div>

      </div>

    <!-- Modal -->
    <div class="modal fade" id="userVisit" tabindex="-1" aria-labelledby="userVisitLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userVisitLabel">Data yang sudah visit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger notifUserVisit"></div>
                <div id="userVisitBody"></div>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal Import -->
    <div class="modal fade" id="importPresentation" tabindex="-1" aria-labelledby="importPresentationLabel" aria-hidden="true">
        <div class="modal-dialog modal-xs modal-dialog-scrollable">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importPresentationLabel">Import Presentation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="notif-presentation"></div>
                <div class="form-group">
                    <label for="">File Excel</label>
                    <input type="file" name="file_excel_presentation" id="file_excel_presentation" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-unggah" onclick="prosesImportPresentation()">Unggah</button>
            </div>
            </div>
        </div>
    </div>

</div>