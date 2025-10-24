<!doctype html>
<html lang="vi">

<head>
  <meta charset="utf-8">
  <title>Xác thực thanh toán</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    * {
      box-sizing: border-box
    }

    body {
      margin: 0;
      background: #f8fafc;
      color: #0f172a;
      font: 16px/1.5 system-ui, -apple-system, Segoe UI, Roboto, Arial
    }

    .wrap {
      max-width: 680px;
      margin: 36px auto;
      padding: 0 16px
    }

    .card {
      background: #fff;
      border-radius: 14px;
      padding: 18px;
      box-shadow: 0 10px 20px rgba(2, 6, 23, .06)
    }

    .ok {
      color: #16a34a;
      font-weight: 600
    }

    .bad {
      color: #dc2626;
      font-weight: 600
    }

    .muted {
      color: #475569
    }

    .row {
      margin-top: 8px
    }

    a.link {
      display: inline-block;
      margin-top: 14px;
      text-decoration: underline;
      color: #0f172a
    }
  </style>
</head>

<body>
  <div class="wrap">
    <h1 style="margin:0 0 14px;font-weight:800">Xác thực thanh toán</h1>

    <div class="card">
      @if(isset($status) && $status === 'success')
      <div class="ok">Thanh toán thành công</div>
      <div class="row muted">
        Số tiền: <strong>{{ number_format($amount ?? 0, 0, ',', '.') }} đ</strong> • {{ $provider }}
        @if($paid_at) • {{ $paid_at }} @endif
      </div>
      @if(isset($order_id))
      @endif
      @elseif(isset($status) && $status === 'fail')
      <div class="bad">Thanh toán không thành công</div>
      <div class="row muted">{{ $message ?? 'Đã xảy ra lỗi.' }}</div>
      <a class="link" href="{{ url('/cart') }}">Thử lại</a>
      @else
      <div class="muted">Không có dữ liệu kết quả.</div>
      @endif
    </div>

    <a href="{{ url('/') }}" class="link">Về trang chủ</a>
  </div>
</body>

</html>