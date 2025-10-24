<!-- <!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Xác minh email</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="min-height:100vh">
  <div class="container">
    <div class="mx-auto card shadow-sm" style="max-width:520px">
      <div class="card-body p-4">
        <h1 class="h4 mb-3">Xác minh email của bạn</h1>
        <p>Chúng tôi đã gửi một liên kết xác minh đến địa chỉ email của bạn.</p>

        @if (session('message')) <div class="alert alert-success">{{ session('message') }}</div> @endif
        @if (session('status'))  <div class="alert alert-success">{{ session('status') }}</div>  @endif
        @if ($errors->any())     <div class="alert alert-danger">{{ $errors->first() }}</div>   @endif

        <form method="POST" action="{{ route('verification.send') }}" class="d-grid gap-2">
          @csrf
          <button class="btn btn-primary" type="submit">Gửi lại email xác minh</button>
        </form>

        <hr class="my-3">

        <form method="POST" action="{{ route('logout') }}" class="d-grid gap-2">
          @csrf
          <button class="btn btn-outline-secondary" type="submit">Đăng xuất</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html> -->
