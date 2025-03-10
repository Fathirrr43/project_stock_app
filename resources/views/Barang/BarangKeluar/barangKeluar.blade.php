@extends('main')

@section('title')
    Barang Keluar
@endsection

@section('content')
    <div class="container-fluid">
        <h3 class="mt-2 mb-3">Barang Keluar</h3>
        <nav aria-label="breadcrumb" class="mb-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Barang Keluar</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div class="pt-1 w-100">
                                <strong>Barang Keluar</strong>
                            </div>
                            <div class="w-100 text-end">
                                <a href="{{ url('/barang-keluar') }}" class="btn btn-outline-primary btn-sm">
                                    Refresh Data
                                    <i class="bi bi-arrow-clockwise"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mt-3 mb-4 container-fluid">
                            <div class="row">
                                <!-- Form inputs dan tombol print dalam satu baris -->
                                <div class="col-md-8">
                                    <form action="" method="get">
                                        <div class="row">
                                            <div class="col">
                                                <input type="date" value="{{ old('tanggal_awal') }}" name="tanggal_awal"
                                                    id="tanggal_awal" class="form-control" />
                                                <sub><strong>Tanggal Awal</strong></sub>
                                            </div>
                                            <div class="col">
                                                <input type="date" value="{{ old('tanggal_akhir') }}"
                                                    name="tanggal_akhir" id="tanggal_akhir" class="form-control" />
                                                <sub><strong>Tanggal Akhir</strong></sub>
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" name="search"
                                                    placeholder="Cari Nama Pelanggan..." />
                                                <sub><strong>Nama Pelanggan</strong></sub>
                                            </div>
                                            <div class="col-2">
                                                <button type="submit" class="btn btn-primary">Cari <i
                                                        class="bi bi-search"></i></button>
                                            </div>
                                            <div class="col-2">
                                                <button type="button" class="btn btn-success">Print <i
                                                        class="bi bi-printer"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- Total Pendapatan -->
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h3>Total Pendapatan</h3>
                                            <h4>{{ 'Rp' . number_format($getTotalPendapatan, 0, ',', '.') }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (Session::has('message'))
                        <div class="col-6">
                            <div class="alert alert-success" id="flash-message">
                                <strong>{{ Session::get('message') }}</strong>
                            </div>
                            <script>
                                setTimeout(function() {
                                    document.getElementById('flash-message').style.display = 'none';
                                    location.reload();
                                }, {{ session('timeout', 5000) }});
                            </script>
                        </div>
                    @endif
                    <div class="row">
                        <div class="mt-4 col">
                            <a href="{{ url('/barang-keluar/add') }}" class="btn btn-primary btn-md rounded-5">
                                <i class="bi bi-plus"></i> Tambah Barang Keluar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <table class="table">
            <thead>
                <th class="text-center">No</th>
                <th class="text-center">Tanggal Faktur</th>
                <th width="300px">Nama Barang</th>
                <th class="">Harga Jual</th>
                <th class="text-center">Jumlah</th>
                <th class="text-center">Sub Total</th>
                <th class="text-center">Admin</th>
                <th class="text-center">Tanggal Buat</th>
                <th class="text-center">Cabang</th>
                <th class="text-center">Aksi</th>
            </thead>
            <tbody>
                @foreach ($getBarangKeluar as $item)
                    <tr>
                        <td class="text-center">
                            {{ ($getBarangKeluar->currentPage() - 1) * $getBarangKeluar->perPage() + $loop->iteration }}
                        </td>
                        <td class="text-center" width="128px">
                            {{ Carbon\Carbon::parse($item->tgl_faktur)->format('d/m/Y') }}</td>
                        <td>{{ $item->getStok->nama_barang }}</td>
                        <td>{{ 'Rp ' . number_format($item->harga_jual, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $item->jumlah_beli }}</td>
                        <td>{{ 'Rp ' . number_format($item->sub_total, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $item->getUser->name }}</td>
                        <td class="text-center" width="128px">
                            {{ Carbon\Carbon::parse($item->tgl_buat)->format('d/m/Y') }}</td>
                        <td class="text-center">{{ $item->getStok->cabang }}</td>
                        <td class="text-center">
                            <a href="#" class="btn btn-success btn-sm print-nota"
                                data-url="{{ url('/barang-keluar/print') }}/{{ $item->id }}" title="Cetak Nota">
                                <i class="bi bi-printer"></i>
                            </a>

                            <a href="{{ url('/barang-keluar') }}/{{ $item->id }}" class="btn btn-danger btn-sm"
                                title="hapus" onclick="return confirm('Yakin Hapus Data ???');">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $getBarangKeluar->links() }}

    </div>
    </div>
    </div>
    </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const printButtons = document.querySelectorAll('.print-nota');

            printButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = this.getAttribute('data-url');
                    const printWindow = window.open(url, '_blank');
                    printWindow.addEventListener('load', function() {
                        printWindow.print();
                    });
                });
            });
        });
    </script>
@endsection


{{-- <div class="card-body">
    <form action="" method="get">
        <div class="row">
            <div class="col">
                <input type="text" class="form-control" name="search" placeholder="Cari Nama Pelanggan/Nomor Telepon..." value="{{ request()->input('search') }}">
            </div>
            <div class="col-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Search
                </button>
            </div>
        </div>
    </form>

    <!-- Tampilkan Hasil Pencarian -->
    @if($pelanggans->isNotEmpty())
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Nomor Telepon</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Kota</th>
                    <th>Provinsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pelanggans as $index => $pelanggan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $pelanggan->nama_pelanggan }}</td>
                        <td>{{ $pelanggan->telp }}</td>
                        <td>{{ $pelanggan->jenis_kelamin }}</td>
                        <td>{{ $pelanggan->alamat }}</td>
                        <td>{{ $pelanggan->kota }}</td>
                        <td>{{ $pelanggan->provinsi }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="mt-3">Tidak ada pelanggan yang ditemukan.</p>
    @endif
</div> --}}
