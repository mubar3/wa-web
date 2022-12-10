<div class="bg-white pt-4 px-3 pb-3 border-right border-left border-bottom">
    <div class="row mb-4 ml-2">
        <div class="col-sm-2">
            <input type="text" name="tmulai-newuser" class="form-control tmulai-newuser" value="{{ $tmulaiNewuser }}">
        </div>

        @if (session('ma_id') == null)
        <div class="col-sm-3">
            <select name="tc" id="tc" class="form-control select2">
                <option value="">-- Semua TC --</option>
                @foreach ($tc as $item)
                    <option value="{{ $item->userid }}">{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>
        @endif
        <div class="col-sm-3">
            <button class="btn btn-sm btn-warning" onclick="getNewUserALL()">GO</button>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-sm-5">
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <h6 class="card-header" style="text-align: center">
                       TOTAL NEW USER
                    </h6>
                    <div class="card-body">
                        <div id="box_newuser_total">
                            <h3 style="text-align:center; padding:0; margin:0;">0</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <h6 class="card-header" style="text-align: center">
                       TOTAL USER SUBMISSION
                    </h6>
                    <div class="card-body">
                        <div id="box_newuser_submition_total">
                            <h3 style="text-align:center; padding:0; margin:0;">0</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 mt-3">
                <div class="card">
                    <h6 class="card-header" style="text-align: center">
                       NEW USER BY TC
                    </h6>
                    <div class="card-body">
                        <div id="box_newuser_tc"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 mt-3">
                <div class="card">
                    <h6 class="card-header" style="text-align: center">
                       USER SUBMISSION BY TC
                    </h6>
                    <div class="card-body">
                        <div id="box_newuser_submition_tc"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="card">
            <h6 class="card-header">
               NEW USER BY REGION
            </h6>
            <div class="card-body">
                <div id="box_newuser_region"></div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-sm-7">
        <div class="card">
            <h6 class="card-header">
                NEW USER BY AREA
            </h6>
            <div class="card-body">
                <div id="box_newuser_area"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-5">
        <div class="card">
            <h6 class="card-header">
                NEW USER BY NA
                {{-- <button class="btn btn-sm btn-success float-right" onclick="exportNewUserNA()">Export</button> --}}
            </h6>
            <div class="card-body">
                <table class="table table-sm table-collapse table-newuser-na">
                    <thead>
                        <tr>
                            <th >TC</th>
                            <th>na</th>
                            <th class="text-center">User Registration</th>
                            <th>first SUBMISSION</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
