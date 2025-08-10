<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng Nhập</title>
    <link rel="icon" type="image/png" href="{{ asset('dist/img/caothang.png') }}" style="width: 64px" />
  <style>
    :root {
      --lg-bg-color: rgba(255, 255, 255, 0.18);
      --lg-highlight: rgba(255, 255, 255, 0.75);
      --lg-text: #ffffff;
      --lg-hover-glow: rgba(255, 255, 255, 0.4);
      --lg-red: #fb4268;
      --lg-grey: #cfcfcf;
      --glass-padding: 1rem 1.5rem;
      --glass-radius: 1.5rem;
      --container-gap: 1.25rem;
    }

    /* ========== BASE LAYOUT ========== */
    * { box-sizing: border-box; }
    html,body { height: 100%; }

    @keyframes bg-move {
      from { background-position: center center; }
      to { background-position: center top; }
    }

    /* ========== CONTAINER ========== */
    .container {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: var(--container-gap);
      width: 95%;
      max-width: 980px;
      padding: 1rem;
    }

    .container--inline {
      flex-direction: row;
    }

    /* ========== GLASS CONTAINER ========== */
    .glass-container {
      position: relative;
      display: flex;
      font-weight: 600;
      color: var(--lg-text);
      background: transparent;
      border-radius: var(--glass-radius);
      overflow: hidden;
      box-shadow: 0 12px 30px rgba(0,0,0,0.45), 0 0 40px rgba(0,0,0,0.2);
      transition: transform 0.45s cubic-bezier(.2,.9,.25,1), box-shadow 0.3s;
      backdrop-filter: blur(6px);
    }

    .glass-container:hover { transform: translateY(-6px); }

    .glass-container--large { min-width: 520px; max-width: 720px; width: 100%; }
    .glass-container--small { min-width: 360px; max-width: 420px; width: 100%; }

    /* ========== GLASS LAYERS ========== */
    .glass-filter { position: absolute; inset: 0; z-index: 0; filter: url(#lg-dist); isolation:isolate; }
    .glass-overlay { position:absolute; inset:0; z-index:1; background: linear-gradient(135deg, rgba(255,255,255,0.06), rgba(255,255,255,0.02)); }
    .glass-specular { position:absolute; inset:0; z-index:2; border-radius:inherit; overflow:hidden; box-shadow: inset 1px 1px 0 var(--lg-highlight), inset 0 0 8px rgba(255,255,255,0.03); }

    .glass-content {
      position: relative;
      z-index: 3;
      display: flex;
      align-items: center;
      gap: 20px;
      padding: var(--glass-padding);
      width: 100%;
    }

    .glass-content--inline { padding: 0.75rem 1.25rem; }

    /* ========== LOGIN FORM SIDE (right) ========== */
    .login {
      display:flex;
      flex-direction:column;
      gap:12px;
      width: 360px;
      max-width: calc(100% - 40px);
    }

    .brand {
      font-size: 1.05rem;
      font-weight: 800;
      letter-spacing: -0.02em;
      color: #fff;
      display:flex;
      align-items:center;
      gap:8px;
    }

    .brand .logo {
      width: 36px;
      height: 36px;
      border-radius: 0.5rem;
      background: linear-gradient(90deg,var(--lg-red), #ff7a6b);
      display:inline-flex;
      align-items:center;
      justify-content:center;
      font-weight:700;
      box-shadow: 0 6px 18px rgba(251,66,104,0.25);
    }

    form .field { display:flex; flex-direction:column; gap:6px; }
    label { font-size:0.82rem; color:var(--lg-grey); font-weight:600; }
    input[type="text"], input[type="password"] {
      appearance:none;
      padding: 0.7rem 0.75rem;
      border-radius: 0.75rem;
      border: 1px solid rgba(255,255,255,0.08);
      background: rgba(255,255,255,0.04);
      color: #fff;
      outline: none;
      font-size: 0.95rem;
      transition: box-shadow .18s, border-color .18s, transform .05s;
      width:100%;
    }
    input:focus {
      box-shadow: 0 6px 18px rgba(0,0,0,0.5), 0 0 20px rgba(255,255,255,0.04);
      border-color: rgba(255,255,255,0.16);
      transform: translateY(-1px);
    }

    .input-row { display:flex; gap:8px; align-items:center; }
    .show-pass {
      background: transparent;
      border: none;
      color: #fff;
      font-weight:700;
      padding: 0.5rem;
      border-radius: 0.6rem;
      cursor:pointer;
      opacity:0.9;
    }

    .actions {
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:8px;
      margin-top:6px;
    }

    .btn {
      padding: 0.72rem 0.95rem;
      border-radius: 0.8rem;
      border: none;
      cursor: pointer;
      font-weight: 800;
      letter-spacing: 0.01em;
      background: linear-gradient(90deg, rgba(255,255,255,0.06), rgba(255,255,255,0.02));
      color: #fff;
      transition: transform .15s, box-shadow .15s, opacity .12s;
      box-shadow: 0 6px 20px rgba(0,0,0,0.35);
    }
    .btn:active { transform: translateY(1px); }
    .btn--primary {
      background: linear-gradient(90deg, var(--lg-red), #ff7a6b);
      box-shadow: 0 12px 30px rgba(251,66,104,0.22);
      color: white;
    }

    .helper {
      font-size: 0.82rem;
      color: var(--lg-grey);
    }

    .error {
      color: #ffd6dc;
      background: rgba(255,50,80,0.07);
      padding: 0.5rem 0.65rem;
      border-radius: 0.6rem;
      font-size: 0.88rem;
    }

    .success {
      color: #d7ffd7;
      background: rgba(30,200,100,0.07);
      padding: 0.5rem 0.65rem;
      border-radius: 0.6rem;
      font-size: 0.88rem;
    }

    .meta {
      display:flex;
      gap:12px;
      align-items:center;
      justify-content:flex-start;
      font-size:0.85rem;
      color:var(--lg-grey);
    }

    .remember {
      display:flex;
      align-items:center;
      gap:8px;
    }

    .spinner {
      width:16px;
      height:16px;
      border-radius:50%;
      border:2px solid rgba(255,255,255,0.18);
      border-top-color: rgba(255,255,255,0.9);
      animation: spin 0.9s linear infinite;
      display:inline-block;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* smaller screens */
    @media (max-width: 860px) {
      .container { gap: 18px; }
      .container--inline { flex-direction: column; align-items: stretch; }
      .glass-container--large, .glass-container--small { max-width: 95%; }
      .login { width: 100%; }
      .player__img { width: 56px; height:56px; }
    }
  </style>
    <!-- Google Font: Source Sans Pro -->
    <!-- <link rel="stylesheet"
        href="{{ asset('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback') }}"> -->
    <link rel="stylesheet" href="{{ asset('dist/css/fontgoogle.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>
<!-- style="background-image: url('{{ asset('dist/img/caothang.png') }}');" -->
<body style="
  margin: 0;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: Inter, ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
  background: url('https://images.unsplash.com/photo-1551384963-cccb0b7ed94b?q=80&w=3247&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') center/cover fixed;
  animation: bg-move 6s ease-in-out infinite alternate;
  color: white;
">
<main class="container container--inline" role="main" aria-labelledby="page-title">
    <!-- RIGHT: login form -->
    <aside class="glass-container glass-container--small" aria-label="Login panel">
      <div class="glass-filter"></div>
      <div class="glass-overlay"></div>
      <div class="glass-specular"></div>

      <div class="glass-content" style="justify-content:center;">
        <div class="login" role="form" aria-labelledby="page-title">
          <div style="display:flex;align-items:center;justify-content:space-between;">
            <div class="brand">
              <div class="logo">G</div>
              <div>
                <div style="font-size:0.95rem">Đăng Nhập</div>
              </div>
            </div>
          </div>

          <h2 id="page-title" style="margin:0;font-size:1.15rem;color:#fff;">Xin Chào</h2>
          <p class="helper" style="margin:0 0 6px 0;">Đăng nhập bằng text và mật khẩu của bạn.</p>

          <div id="feedback" aria-live="polite"></div>
                     @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
          <form id="loginForm"  action="{{ url('admin/dangnhap') }}" method="post">
                   {{ csrf_field() }}
            <div class="field">
              <label for="text">Tài Khoản</label>
              <input id="tai_khoan"  name="tai_khoan" type="text" placeholder="Email" required>
            </div>

            <div class="field">
              <label for="password">Mật Khẩu</label>
              <div class="input-row" style="align-items:center;">
                <input type="password" name="mat_khau" id="mat_khau" autocomplete="current-password" placeholder="••••••••" required>
                <button type="button" class="show-pass" id="togglePass" aria-label="Hiện mật khẩu">Show</button>
              </div>
            </div>

            <div class="actions" style="
                    display: flex;
            justify-content: center;
                ">
              <div style="display:flex;gap:8px;align-items:center;">
                <button type="submit" class="btn btn--primary" id="submitBtn" aria-live="polite">
                  <span id="btnText">Đăng Nhập</span>
                </button>
              </div>
            </div>
          </form>

        </div>
      </div>

      <!-- SVG FILTER DEFINITION -->
      <svg style="display: none">
        <filter id="lg-dist" x="0%" y="0%" width="100%" height="100%">
          <feTurbulence type="fractalNoise" baseFrequency="0.008 0.008" numOctaves="2" seed="92" result="noise" />
          <feGaussianBlur in="noise" stdDeviation="2" result="blurred" />
          <feDisplacementMap in="SourceGraphic" in2="blurred" scale="70" xChannelSelector="R" yChannelSelector="G" />
        </filter>
      </svg>
    </aside>
  </main>
    <!-- /.login-box -->
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    </body>
</html>