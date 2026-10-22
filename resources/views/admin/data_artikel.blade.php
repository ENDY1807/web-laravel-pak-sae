<?php
require_once resource_path('config/connect.php');

if (!function_exists('endyEscapeHtml')) {
    function endyEscapeHtml($value)
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

if (isset($_GET['hapus'])) {
    $id = filter_input(INPUT_GET, 'hapus', FILTER_VALIDATE_INT);
    if ($id !== false && $id !== null) {
        $hapus = mysqli_prepare($connect, 'DELETE FROM artikel WHERE Id = ?');
        mysqli_stmt_bind_param($hapus, 'i', $id);
        mysqli_stmt_execute($hapus);
        mysqli_stmt_close($hapus);
    }
    header('Location: /admin/data-artikel');
    exit;
}

if (isset($_POST['tambah'])) {
    $id = filter_input(INPUT_POST, 'Id', FILTER_VALIDATE_INT);
    $judul = trim($_POST['Judul'] ?? '');
    $isi = trim($_POST['Isi'] ?? '');
    $tanggal = $_POST['Tanggal'] ?? '';
    $image = trim($_POST['Image'] ?? '');
    $link = trim($_POST['Link'] ?? '');

    if ($id !== false && $id !== null && $judul !== '' && $isi !== '' &&
        DateTime::createFromFormat('Y-m-d', $tanggal) !== false &&
        filter_var($link, FILTER_VALIDATE_URL)) {
        $tambah = mysqli_prepare($connect, 'INSERT INTO artikel (Id, Judul, Isi, Tanggal, Image, link) VALUES (?, ?, ?, ?, ?, ?)');
        mysqli_stmt_bind_param($tambah, 'isssss', $id, $judul, $isi, $tanggal, $image, $link);
        mysqli_stmt_execute($tambah);
        mysqli_stmt_close($tambah);
    }
    header('Location: /admin/data-artikel');
    exit;
}

if (isset($_POST['edit'])) {
    $id = filter_input(INPUT_POST, 'Id', FILTER_VALIDATE_INT);
    $judul = trim($_POST['Judul'] ?? '');
    $isi = trim($_POST['Isi'] ?? '');
    $tanggal = $_POST['Tanggal'] ?? '';
    $link = trim($_POST['Link'] ?? '');
    $image = trim($_POST['Image'] ?? '');

    $tanggalObj = DateTime::createFromFormat('!Y-m-d', $tanggal);
    $tanggalValid = $tanggalObj &&
    $tanggalObj->format('Y-m-d') === $tanggal;

    if (
        $id !== false && $id !== null && $id > 0 && $judul !== '' && $isi !== '' && $tanggalValid && filter_var($link, FILTER_VALIDATE_URL)
    ) {
        $edit = mysqli_prepare( $connect, 'UPDATE artikel  SET Judul = ?, Isi = ?, Tanggal = ?, Image = ?, Link = ? WHERE Id = ?'
        );

        mysqli_stmt_bind_param(
            $edit, 'sssssi', $judul, $isi, $tanggal, $image, $link, $id
        );

        mysqli_stmt_execute($edit);
        mysqli_stmt_close($edit);
    }

    header('Location: /admin/data-artikel');
    exit;
}


$result = mysqli_query($connect, 'SELECT Id, Judul, Isi, Tanggal, Image, link FROM artikel ORDER BY Tanggal DESC');
$artikel = $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Data Artikel - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('admin-assets/css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous">
    </script>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="index.php">
            Start Bootstrap
        </a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"> <i class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"> <i class="fas fa-search"></i></button>
            </div>
        </form>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="{{ route('welcome') }}">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="{{ route('admin') }}">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">
                            Interface
                        </div>
                        <a class="nav-link collapsed" href="{{ route('layout_static') }}" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-columns"></i>
                            </div>
                            Layouts
                            <div class="sb-sidenav-collapse-arrow">
                                <i class="fas fa-angle-down"></i>
                            </div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('layout_static') }}"> Static Navigation</a>
                                <a class="nav-link" href="{{ route('layout_sidenav_light') }}"> Light Sidenav</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-book-open"></i>
                            </div>
                            Pages
                            <div class="sb-sidenav-collapse-arrow">
                                <i class="fas fa-angle-down"></i>
                            </div>
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">Authentication
                                    <div class="sb-sidenav-collapse-arrow">
                                        <i class="fas fa-angle-down"></i>
                                    </div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="#" alt="Ini Page Login"> Login</a>
                                        <a class="nav-link" href="#"> Register</a>
                                        <a class="nav-link" href="#"> Forgot Password</a>
                                    </nav>
                                </div>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">Error
                                    <div class="sb-sidenav-collapse-arrow">
                                        <i class="fas fa-angle-down"></i>
                                    </div>
                                </a>
                                <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="{{ route('401') }}">401 Page</a>
                                        <a class="nav-link" href="{{ route('404') }}">404 Page</a>
                                        <a class="nav-link" href="{{ route('500') }}">500 Page</a>
                                    </nav>
                                </div>
                            </nav>
                        </div>
                        <div class="sb-sidenav-menu-heading">
                            Addons
                        </div>
                        <a class="nav-link" href="{{ route('charts') }}">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-chart-area"></i>
                            </div>
                            Charts
                        </a>
                        <a class="nav-link" href="{{ route('data_artikel') }}">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-table"></i>
                            </div>
                            Data artikel
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Start Bootstrap
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="mt-4">Artikel</h1>
                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Data Artikel</li>
                            </ol>
                        </div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahArtikel"><i class="fas fa-plus"></i>Tambah Artikel</button>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>Data Artikel
                        </div>
                    <div class="table-responsive">
                        <table id="datatablesSimple" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Isi</th>
                                    <th>Tanggal</th>
                                    <th>Link</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($artikel as $data) { ?>
                                    <tr>
                                        <td><?php echo endyEscapeHtml($data['Judul']); ?></td>
                                        <td><?php echo endyEscapeHtml($data['Isi']); ?></td>
                                        <td><?php echo endyEscapeHtml($data['Tanggal']); ?></td>
                                        <td><a href="<?php echo endyEscapeHtml($data['link']); ?>" target="_blank" rel="noopener noreferrer">  <?php echo endyEscapeHtml($data['Judul']); ?></a></td>
                                        <td><a href="?edit=<?php echo (int) $data['Id']; ?>" title="Edit">  <i class="fa-solid fa-pencil" style="color: #ffc107;"></i></a><a href="?hapus=<?php echo (int) $data['Id']; ?>" title="Hapus" onclick="return confirm('Yakin ingin menghapus artikel ini?')">  <i class="fa-solid fa-trash" style="color: red;"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">
                            Copyright &copy; Your Website 2026
                        </div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <div class="modal fade" id="modalTambahArtikel" tabindex="-1" aria-labelledby="modalTambahArtikelLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahArtikelLabel"><i class="fas fa-plus"></i>Tambah Artikel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id" class="form-label">Id Artikel</label>
                            <input type="number" class="form-control" id="id" name="id" placeholder="Masukkan Id Artikel" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image Artikel</label>
                            <input type="file" class="form-control" id="image" name="image" placeholder="Masukkan URL Image Artikel" required>
                        </div>
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Artikel</label>
                            <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan judul artikel" required>
                        </div>
                        <div class="mb-3">
                            <label for="isi" class="form-label">Isi Artikel</label>
                            <textarea class="form-control" id="isi" name="isi" rows="6" placeholder="Masukkan isi artikel" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>
                        <div class="mb-3">
                            <label for="link" class="form-label">Link Artikel</label>
                            <input type="url" class="form-control" id="link" name="link" placeholder="Masukan Link Artikel" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="edit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('admin-assets/js/scripts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('admin-assets/js/datatables-simple-demo.js') }}"></script>
</body>

</html>