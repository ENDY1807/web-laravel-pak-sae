<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="Header">
            <h1 class="text-center my-4">My Profile</h1>
        </div>
        <div class="Navbar">
            <nav class="navbar navbar-expand-lg bg-body-tertiary rounded-3 shadow-sm px-3">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">
                                    Home
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    Profile
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    Portofolio
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="text-end">
                        <a class="nav-link" href="{{ route('admin') }}">
                            Login
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div class="Content mt-5">
            <div class="row g-4 align-items-start">
                <div class="col-lg-8">
                    <div class="row row-cols-1 row-cols-md-2 g-4">
                        @forelse ($artikel as $data)
                            <div class="col">
                                <div class="card h-100 shadow-sm border-0">
                                    @if (!empty($data->Image ?? $data['Image']))
                                        <img src="{{ asset('storage/images/' . ($data->Image ?? $data['Image'])) }}" alt="{{ $data->Judul ?? $data['Judul'] }}" class="card-img-top bg-dark" style="height: 180px; object-fit: cover;">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a href="{{ $data->Link ?? $data['Link'] }}" target="_blank" rel="noopener noreferrer" class="text-decoration-none">
                                                {{ $data->Judul ?? $data['Judul'] }}
                                            </a>
                                        </h5>
                                        <p class="card-text text-muted">{{ $data->Isi ?? $data['Isi'] }}</p>
                                    </div>
                                    <div class="card-footer bg-transparent border-0">
                                        <small class="text-body-secondary"><i class="far fa-calendar-alt me-1"></i> {{ $data->Tanggal ?? $data['Tanggal'] }}</small>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info">Belum ada artikel yang ditambahkan.</div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm border-0">
                        <ul class="list-group list-group-flush">
                            @forelse ($artikel as $data)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ $data->Link ?? $data['Link'] }}" target="_blank" class="text-decoration-none text-dark">
                                        {{ $data->Judul ?? $data['Judul'] }}
                                    </a>
                                </li>
                            @empty
                                <li class="list-group-item text-muted">Tidak ada artikel</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="Profile my-5">
            <div class="card shadow-sm border-0 p-4">
                <div class="d-flex flex-column flex-md-row align-items-center gap-4">
                    <div>
                        <img src="{{ asset('storage/images/profile.jpg') }}" style="width: 180px; height: 180px; border-radius: 15px; object-fit: cover;" alt="Profile" onerror="this.src='https://via.placeholder.com/180'">
                    </div>
                    <div>
                        <h3 class="fw-bold mb-3">
                            Profile
                        </h3>
                        <ul class="list-unstyled mb-0 fs-6">
                            <li class="py-1"><strong>Nama:</strong> Muhammad Nazril Putra Natrabu</li>
                            <li class="py-1"><strong>Usia:</strong> 17 tahun</li>
                            <li class="py-1"><strong>Tempat Tanggal Lahir:</strong> 24 Juli 2009</li>
                            <li class="py-1"><strong>Alamat:</strong> Rancaekek</li>
                            <li class="py-1"><strong>Email:</strong> endymahavira@gmail.com</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="Footer py-3 text-center text-muted">
            <small>&copy; {{ date('Y') }} Endy. All rights reserved.</small>
        </div>
    </div>
</body>

</html>