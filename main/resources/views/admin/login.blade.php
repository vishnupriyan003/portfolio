<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login | Portfolio</title>
  <style>
    * { box-sizing: border-box; }
    body { margin: 0; min-height: 100vh; display: grid; place-items: center; font-family: Arial, Helvetica, sans-serif; background: #071014; color: #102027; }
    .login-card { width: min(420px, calc(100% - 32px)); padding: 32px; border-radius: 8px; background: #fff; box-shadow: 0 22px 60px rgba(0, 0, 0, .34); }
    h1 { margin: 0 0 8px; font-size: 30px; }
    p { margin: 0 0 24px; color: #5a6870; }
    label { display: block; margin-bottom: 8px; font-weight: 700; }
    input { width: 100%; min-height: 46px; margin-bottom: 16px; padding: 0 12px; border: 1px solid #ccd6d8; border-radius: 7px; font: inherit; }
    button, a { display: inline-flex; min-height: 46px; align-items: center; justify-content: center; padding: 0 18px; border-radius: 7px; font-weight: 800; text-decoration: none; }
    button { width: 100%; border: 0; color: #fff; background: #1f8a70; cursor: pointer; }
    a { margin-top: 14px; width: 100%; color: #166555; background: #dff4ee; }
    .error { margin-bottom: 16px; padding: 12px; border-radius: 7px; color: #7f1d1d; background: #fee2e2; }
  </style>
</head>
<body>
  <main class="login-card">
    <h1>Admin Login</h1>
    <p>Manage your portfolio content and admin password.</p>

    @if ($errors->any())
      <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.authenticate') }}">
      @csrf
      <label for="username">Username</label>
      <input id="username" name="username" value="{{ old('username') }}" autocomplete="username" required autofocus>

      <label for="password">Password</label>
      <input id="password" name="password" type="password" autocomplete="current-password" required>

      <button type="submit">Login</button>
    </form>

    <a href="{{ route('portfolio') }}">Back to portfolio</a>
  </main>
</body>
</html>
