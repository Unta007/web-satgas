@extends('layout.app')

@section('title', 'Tentang Kami')

@section('content')
<div class="container py-5"> {{-- py-5 untuk padding atas dan bawah --}}

    {{-- BAGIAN HEADER TENTANG KAMI --}}
    <div class="row mb-5 align-items-center">
        <div class="col-md-4 text-md-start text-center"> {{-- text-center untuk mobile, text-md-start untuk desktop --}}
            <h1 class="display-4 fw-bold" style="color: maroon;">TENTANG KAMI</h1>
        </div>
        <div class="col-md-8">
            <p class="lead text-muted">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
            </p>
        </div>
    </div>

    {{-- BAGIAN VISI --}}
    <div class="mb-4 p-4 p-md-5 text-white rounded shadow-sm" style="background-color: maroon;">
        <div class="d-flex align-items-center mb-3">
            <div style="width: 6px; height: 40px; background-color: white; margin-right: 20px;  border-radius: 3px;"></div>
            <h2 class="display-5 fw-bold mb-0">Visi</h2>
        </div>
        <p style="font-size: 1.1rem;">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus tincidunt, enim quis rutrum pulvinar, nisi eros consequat orci, a efficitur eros mauris ac augue. Vivamus vestibulum erat id risus tempor, at congue lectus finibus. Quisque euismod dui nulla, vel pellentesque mauris euismod sed.
        </p>
    </div>

    {{-- BAGIAN MISI --}}
    <div class="mb-5 p-4 p-md-5 text-white rounded shadow-sm" style="background-color: maroon;">
        <div class="d-flex align-items-center mb-3">
            <div style="width: 6px; height: 40px; background-color: white; margin-right: 20px; border-radius: 3px;"></div>
            <h2 class="display-5 fw-bold mb-0">Misi</h2>
        </div>
        <p style="font-size: 1.1rem;">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus tincidunt, enim quis rutrum pulvinar, nisi eros consequat orci, a efficitur eros mauris ac augue. Vivamus vestibulum erat id risus tempor, at congue lectus finibus. Quisque euismod dui nulla, vel pellentesque mauris euismod sed.
        </p>
    </div>

    {{-- BAGIAN TUJUAN KAMI --}}
    <div class="mb-5">
        <h2 class="display-5 fw-bold mb-3">Tujuan Kami</h2>
        <p>
            Sesuai dengan Peraturan Menteri Pendidikan, Kebudayaan, Riset, Dan Teknologi Nomor 30 Tahun 2021 Tentang Pencegahan Dan Penanganan Kekerasan Seksual Di Lingkungan Perguruan Tinggi, adapun tujuan kami adalah sebagai berikut:
        </p>
        <ul class="list-unstyled ps-3">
            <li class="mb-2">
                <i class="bi bi-check-circle-fill me-2" style="color: maroon;"></i> {{-- Menggunakan Bootstrap Icon --}}
                Sebagai pedoman bagi perguruan tinggi untuk menyusun kebijakan dan mengambil tindakan pencegahan dan penanganan kekerasan seksual yang terkait dengan pelaksanaan tridharma di dalam atau di luar kampus; dan
            </li>
            <li>
                <i class="bi bi-check-circle-fill me-2" style="color: maroon;"></i> {{-- Menggunakan Bootstrap Icon --}}
                Untuk menumbuhkan kehidupan kampus yang manusiawi, bermartabat, setara, inklusif, kolaboratif, serta tanpa kekerasan di antara mahasiswa, pendidik, tenaga kependidikan, dan warga kampus di perguruan tinggi.
            </li>
        </ul>
    </div>

</div>
@endsection
