<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>@yield('title', 'HPP Average Demo')</title>
  <meta name="description" content="Demo HPP Average - Laravel">

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous"
  >
  <script>
    window.tailwind = {
      config: {
        prefix: 'tw-',
        theme: {
          extend: {
            container: { center: true, padding: '1rem' }
          }
        }
      }
    }
  </script>
  <script src="https://cdn.tailwindcss.com"></script>

  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, sans-serif; }
    body { padding-top: 4.25rem; }
    .glass {
      backdrop-filter: saturate(160%) blur(6px);
      background: rgba(255,255,255,0.6);
    }
  </style>
</head>
<body class="tw-bg-gradient-to-b tw-from-slate-50 tw-to-white tw-text-gray-900">

  <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="{{ url('/') }}">HPP<span class="text-primary">Average</span></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navb">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="navb" class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="{{ url('/ui') }}">UI</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/api/transactions') }}" target="_blank">API List</a></li>
          <li class="nav-item"><a class="nav-link" href="https://http.cat/200" target="_blank">Docs</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <section class="tw-pt-10 tw-pb-8">
    <div class="container">
      <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-2 tw-gap-8 tw-items-center">
        <div class="tw-space-y-4">
          <h1 class="tw-text-3xl md:tw-text-5xl tw-font-extrabold tw-leading-tight">
            @yield('hero_title', 'Perhitungan HPP Average')
          </h1>
          <p class="tw-text-gray-600 tw-text-base md:tw-text-lg">
            @yield('hero_subtitle', 'API CRUD + Recalc kronologis + siap menampung “sisipan” transaksi.')
          </p>
          <div class="tw-flex tw-flex-wrap tw-gap-3">
            <a class="btn btn-primary btn-lg" href="{{ url('/api/transactions') }}" target="_blank">Coba API</a>
            <a class="btn btn-outline-secondary btn-lg" href="{{ url('/ui') }}">Lihat UI</a>
          </div>
        </div>
        <div class="tw-mt-6 lg:tw-mt-0">
          <div class="tw-rounded-3xl tw-shadow-lg glass tw-p-6">
            <div class="tw-grid tw-grid-cols-2 tw-gap-4">
              <div class="tw-bg-white tw-rounded-2xl tw-shadow tw-p-4">
                <div class="tw-text-sm tw-text-gray-500">Saldo Qty</div>
                <div class="tw-text-2xl tw-font-bold">@yield('metric_qty', '—')</div>
              </div>
              <div class="tw-bg-white tw-rounded-2xl tw-shadow tw-p-4">
                <div class="tw-text-sm tw-text-gray-500">Saldo Nilai</div>
                <div class="tw-text-2xl tw-font-bold">@yield('metric_value', '—')</div>
              </div>
              <div class="tw-bg-white tw-rounded-2xl tw-shadow tw-p-4">
                <div class="tw-text-sm tw-text-gray-500">HPP</div>
                <div class="tw-text-2xl tw-font-bold">@yield('metric_hpp', '—')</div>
              </div>
              <div class="tw-bg-white tw-rounded-2xl tw-shadow tw-p-4">
                <div class="tw-text-sm tw-text-gray-500">Transaksi</div>
                <div class="tw-text-2xl tw-font-bold">@yield('metric_tx', '—')</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <main class="tw-pb-12">
    <div class="container">
      @yield('content')
      <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-3 tw-gap-6">
        <div class="tw-bg-white tw-rounded-2xl tw-shadow tw-p-6">
          <h3 class="tw-font-semibold tw-mb-2">CRUD API</h3>
          <p class="tw-text-gray-600">Tambah, ubah, hapus, dan daftar transaksi via endpoint REST.</p>
        </div>
        <div class="tw-bg-white tw-rounded-2xl tw-shadow tw-p-6">
          <h3 class="tw-font-semibold tw-mb-2">Average HPP</h3>
          <p class="tw-text-gray-600">Perhitungan rata-rata bergerak sesuai catatan dan contohmu.</p>
        </div>
        <div class="tw-bg-white tw-rounded-2xl tw-shadow tw-p-6">
          <h3 class="tw-font-semibold tw-mb-2">Anti Minus</h3>
          <p class="tw-text-gray-600">(Siap ditambah) validasi stok tidak boleh minus saat insert/remove.</p>
        </div>
      </div>
    </div>
  </main>

  <footer class="tw-border-t tw-py-8">
    <div class="container tw-flex tw-flex-col md:tw-flex-row tw-justify-between tw-items-center tw-gap-3">
      <p class="tw-text-gray-500 tw-text-sm mb-0">&copy; {{ date('Y') }} HPP Average Demo.</p>
      <div class="tw-flex tw-gap-3">
        <a class="tw-text-gray-500 tw-text-sm hover:tw-text-gray-700" href="#">Ketentuan</a>
        <a class="tw-text-gray-500 tw-text-sm hover:tw-text-gray-700" href="#">Privasi</a>
      </div>
    </div>
  </footer>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"
  ></script>
</body>
</html>
