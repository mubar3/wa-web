<!DOCTYPE html>
<html>
  <head>
    <title>{{ $page_title }}</title>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="{{ asset('/img/favicon.png') }}" rel="shortcut icon">
    <link href="{{ asset('/css/login.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
  </head>

  <body class="sidebar-dark">
	<div class="main-wrapper">
		<div class="page-wrapper full-page" style="background: linear-gradient(32grad, rgb(5, 60, 225) 28%, rgb(0, 255, 76) 100%);">
			<div class="page-content d-flex align-items-center justify-content-center">
				<div class="row w-100 mx-0 auth-page">
					<div class="col-md-8 col-xl-6 mx-auto">
						<div class="card" style="border: none !important; border-radius:.7rem !important; overflow:hidden;">
							<div class="row">
                                <div class="col-md-4 pr-md-0">
                                    <div class="auth-left-wrapper">

                                    </div>
                                </div>
                                <div class="col-md-8 pl-md-0">
                                    <div class="auth-form-wrapper px-4 py-5">
                                        @if (session()->has('pesan'))
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12">
                                                {!! session('pesan') !!}
                                            </div>
                                        </div>
                                        @endif

                                        <img alt="" src="{{ url('storage/'.$logo) }}" width="60%">
                                        <hr>
                                        {{-- <a href="#" class="noble-ui-logo d-block mb-2">{{ $page_title }}</a> --}}
                                        <form action="{{ url('/login') }}" method="POST" id="my-form">
                                        @csrf
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Username</label>
                                            <input type="text" name="username" class="form-control" id="exampleInputEmail1" placeholder="Username" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" autocomplete="off">
                                        </div>
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-primary btn-sm"> Ya! Login</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="text-align: center; color:white !important">
                            <br>
                            <small >Copyright &copy; @php echo date('Y') @endphp PT Geo Given Visi Mandiri - {{ $page_title }}</small>
                        </div>
                    </div>
				</div>

			</div>
		</div>
	</div>
</body>
</html>

<!-- Laravel Javascript Validation -->
<script src="{{ asset('/js/login.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! $validator->selector('#my-form') !!}
