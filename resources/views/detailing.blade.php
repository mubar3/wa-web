<div class="bg-white pt-4 px-3 pb-3 border-right border-left border-bottom">
    <div class="row mb-4 ml-2">
        <div class="col-sm-2">
            <input type="text" name="tmulai" class="form-control tMulai" value="{{ $tMulai }}">
        </div>
        <div class="col-sm-2">
            <input type="text" name="takhir" class="form-control tAkhir" value="{{ $tAkhir }}">
        </div>
        <div class="col-sm-3">
            <a href="#" class="btn btn-sm btn-warning periodecek">GO</a>
            <a href="#" class="btn btn-sm btn-default" onclick="reset()"><i class="feather-rotate-ccw"></i></a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12 col-sm-12 mb-3">
            <div class="card">
                <h6 class="card-header">
                    <div class="row">
                        <div class="col-md-2">
                            DETAILING by PAGE
                            <div class="week-range"></div>
                        </div>
                        <div class="col-md-4 text-muted" style="font-size: 12px">
                            <p>Total Durasi <span style="margin-left:5px">:</span> <b class="total_durasi"></b></p>
                            <p>Total View <span style="margin-left:15px">:</span> <b class="total_view"></b></p>
                        </div>
                        <div class="col-md-3">
                            <select name="backgroundNa" class="form-control selectBackgroundNa" style="margin-top: 10px" size="1" id="backgroundNa">
                                <option value="">--Semua Background--</option>
                                <option value="Ex BP">Ex BP</option>
                                <option value="New Hire">New Hire</option>
                            </select>

                        </div>
                        <div class="col-md-3">
                            <div class="detailing_page_radio">
                                <div class="form-check form-check-inline mr-4">
                                    <input class="form-check-input" type="radio" name="pageTipeRadio" id="pageInlineRadio1" value="durasi" checked>
                                    <label class="form-check-label" for="pageInlineRadio1" style="margin-left: -1px">Avg Durasi</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pageTipeRadio" id="pageInlineRadio2" value="view">
                                    <label class="form-check-label" for="pageInlineRadio2" style="margin-left: -1px">View</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </h6>
                <div class="card-body">
                    <div id="box_detailing_page"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 mb-3">
            <div class="card">
                <h6 class="card-header">
                    <div class="row">
                        <div class="col-md-9">
                            DETAILING by REGION by 5 TOP PAGE <span class="judultoppage"></span>
                            <div class="week-range"></div>
                        </div>
                        <div class="col-md-3">
                            <div class="detailing_region5_radio">
                                <div class="form-check form-check-inline mr-4">
                                    <input class="form-check-input" type="radio" name="region5TipeRadio" id="region5InlineRadio1" value="durasi" checked>
                                    <label class="form-check-label" for="region5InlineRadio1" style="margin-left: -1px">Avg Durasi</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="region5TipeRadio" id="region5InlineRadio2" value="view">
                                    <label class="form-check-label" for="region5InlineRadio2" style="margin-left: -1px">View</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </h6>
                <div class="card-body">
                    <div id="box_detailing_region_top"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 mb-3">
            <div class="card">
                <h6 class="card-header">
                    DETAILING by TANGGAL
                    <div class="week-range"></div>
                </h6>
                <div class="card-body">
                    <div id="box_detailing_tanggal"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 mb-3">
            <div class="card">
                <h6 class="card-header">
                    DETAILING by WAKTU
                    <div class="week-range"></div>
                </h6>
                <div class="card-body">
                    <div id="box_detailing_waktu"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 mb-3">
            <div class="card">
                <h6 class="card-header">
                    DETAILING by REGION
                    <div class="week-range"></div>
                </h6>
                <div class="card-body">
                    <div id="box_detailing_area"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 mb-3">
            <div class="card">
                <h6 class="card-header">
                    DETAILING by KOTA
                    <div class="week-range"></div>
                </h6>
                <div class="card-body">
                    <div id="box_detailing_kota"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 mb-3 wrap_detailing_perkota" id="detailing_perkota" style="display: none;">
            <div class="card">
                <h6 class="card-header">
                    <div class="row">
                        <div class="col-md-9">
                            <span class="juduldetailingperkota">DETAILING by KOTA by PAGE</span>
                            <div class="week-range"></div>
                        </div>
                        <div class="col-md-3">
                            <div style="display: none;" class="detailing_perkota_radio">
                                <div class="form-check form-check-inline mr-4">
                                    <input class="form-check-input" type="radio" name="tipeRadio" id="inlineRadio1" value="durasi" checked>
                                    <label class="form-check-label" for="inlineRadio1" style="margin-left: -1px">Avg Durasi</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipeRadio" id="inlineRadio2" value="view">
                                    <label class="form-check-label" for="inlineRadio2" style="margin-left: -1px">View</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </h6>
                <div class="card-body">
                    <div id="box_detailing_perkota"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 mb-3 wrap_detailing_outlet" id="detailing_outlet" style="display: none;">
            <div class="card" style="margin-top: 10px;">
                <h6 class="card-header">
                    <span class="juduldetailingoutlet">DETAILING by KOTA by PAGE by OUTLET</span>
                    <div class="week-range"></div>
                </h6>
                <div class="card-body">
                    <div id="box_detailing_outlet"></div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- <div class="scroll_sos_brand"></div> --}}
</div>