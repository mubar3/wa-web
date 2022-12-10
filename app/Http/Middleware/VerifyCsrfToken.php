<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'save_contact',
        'edit_aksi_contact',
        'ajax_data_contact',
        'save_api_wa',
        'edit_aksi_api_wa',
        'ajax_data_api_wa',
        'sent_wa_cek',
        'download_excel',
        'search_history',
        'download_excel'
        //
    ];
}
