<!DOCTYPE html> 
<html>
<head>
	<meta charset="utf-8">
	<title>Login Admin</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600&display=swap" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="{{ asset('assets/cssLogin/style.css') }}">
</head>
<body>
	<div class="col-10 col-md-5 pl-5 pr-5 pt-3 pb-3 box">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-white">Silahkan Login</h2>
            </div>
        </div>
		<form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="font-weight-bold text-white-50 mt-3">Email address:</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
                    @error('email')
                        <div class="alert alert-danger mt-1">
                            {{ $message }}
                        </div>    
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold  text-white-50">Password:</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                        <div class="alert alert-danger mt-1">
                            {{ $message }}
                        </div>    
                    @enderror
                </div>
                <div class="row justify-content-center pl-3 pr-3 mt-5">
                    <button type="submit" class="btn btn-block btn-primary font-weight-bold mt-3 mb-2">LOGIN</button>
                </div>
            </form>
	</div>


 <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>