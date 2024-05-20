<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Web Absensi SDN 88 Bengkulu Tengah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .navbar-custom {
            background-color: #0d6efd;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="/">Absensi SDN 88 Bengkulu Tengah</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="login" class="btn btn-primary">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container col-lg-4 py-5">
        {{-- Scanner --}}
        <div class="card bg-white shadow rounded-3 p-3 border-0">
            {{-- Pesan --}}
            @if (session()->has('gagal'))
                <div class="alert alert-danger">
                    {{ session('gagal') }}
                </div>
            @endif
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <video id="preview"></video>

            {{-- Form --}}
            <form action="{{ route('home.store') }}" method="POST" id="form">
                @csrf
                <input type="hidden" name="id_pegawai" id="id_pegawai">
                <input type="hidden" name="jam_masuk" id="jam_masuk"
                    value="{{ \Carbon\Carbon::now()->format('H:i') }}">
            </form>
        </div>
        {{-- Scanner --}}

        <div class="table-responsive mt-3">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (App\PresensiGuru::with('pegawai')->whereDate('tanggal', \Carbon\Carbon::today())->get() as $presensi)
                        <tr>
                            <td>{{ $presensi->pegawai->Nama }}</td>
                            <td>{{ $presensi->tanggal }}</td>
                            <td>{{ $presensi->jam_masuk }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script type="text/javascript">
        let scanner = new Instascan.Scanner({
            video: document.getElementById('preview')
        });

        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);

                scanner.addListener('scan', function(content) {
                    console.log(content);
                    document.getElementById('id_pegawai').value = content;
                    document.getElementById('form').submit();
                });
            } else {
                console.error('No cameras found.');
            }


        }).catch(function(e) {
            console.error(e);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
