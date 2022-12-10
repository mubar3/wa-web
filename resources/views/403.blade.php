<!DOCTYPE html>
<html>
  <head>
    <title>403</title>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="{{ asset('img/favicon.png') }}" rel="shortcut icon">
	<link rel="stylesheet" href="{{ asset('/css/admin.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">

  </head>
  <body class="sidebar-dark">
    <div class="main-wrapper">
        <div class="page-wrapper full-page">
			<div class="page-content d-flex align-items-center justify-content-center">

				<div class="row w-100 mx-0 auth-page">
					<div class="col-md-8 col-xl-6 mx-auto d-flex flex-column align-items-center">
						<h1 class="font-weight-bold mb-22 mt-2 tx-80 text-muted">403</h1>
						<h4 class="mb-2">Ooopss</h4>
						<h6 class="text-muted mb-3 text-center">Anda dilarang mengakses halaman ini. Segera hubungi Administrator Anda</h6>

						<a href="{{ route('home') }}" class="btn btn-primary">Kembali</a>
					</div>
				</div>

			</div>
		</div>
    </div>

  </body>
</html>
