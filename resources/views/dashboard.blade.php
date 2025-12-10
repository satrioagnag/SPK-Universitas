@extends('layouts.app')

@section('title', 'Dashboard - Sistem Pendukung Keputusan')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Total Alternatif Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Alternatif
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $alternativeCount }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-university fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-0">
                <a href="{{ route('alternatives.index') }}" class="btn btn-primary btn-sm btn-block">
                    <i class="fas fa-arrow-right"></i> Lihat Data
                </a>
            </div>
        </div>
    </div>

    <!-- Total Kriteria Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Kriteria
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalCriteria }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-0">
                <a href="{{ route('criteria.index') }}" class="btn btn-success btn-sm btn-block">
                    <i class="fas fa-arrow-right"></i> Lihat Data
                </a>
            </div>
        </div>
    </div>

    <!-- Total Hasil TOPSIS Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Hasil Perhitungan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalTopsisResults }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calculator fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-0">
                <a href="{{ route('topsis.index') }}" class="btn btn-info btn-sm btn-block">
                    <i class="fas fa-arrow-right"></i> Lihat Hasil
                </a>
            </div>
        </div>
    </div>

    <!-- Rekomendasi Terbaik Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Rekomendasi Terbaik
                        </div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                            @if($lastresult)
                                {{ $lastresult->alternative->Name ?? 'N/A' }}
                            @else
                                Belum Ada Data
                            @endif
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-trophy fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
            @if($lastresult)
            <div class="card-footer bg-white border-0">
                <small class="text-muted">
                    Skor: {{ number_format($lastresult->score, 4) }}
                </small>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Workflow Guide -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Alur Penggunaan Sistem</h6>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item mb-3">
                        <div class="timeline-badge bg-primary">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div class="timeline-panel">
                            <h6 class="timeline-title">1. Input Data Kriteria</h6>
                            <p class="text-muted mb-0">Tambahkan kriteria penilaian yang akan digunakan</p>
                            <a href="{{ route('criteria.index') }}" class="btn btn-sm btn-outline-primary mt-2">
                                Kelola Kriteria
                            </a>
                        </div>
                    </div>

                    <div class="timeline-item mb-3">
                        <div class="timeline-badge bg-success">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <div class="timeline-panel">
                            <h6 class="timeline-title">2. Perbandingan AHP</h6>
                            <p class="text-muted mb-0">Lakukan perbandingan berpasangan untuk menghitung bobot kriteria</p>
                            <a href="{{ route('ahp.index') }}" class="btn btn-sm btn-outline-success mt-2">
                                Hitung Bobot AHP
                            </a>
                        </div>
                    </div>

                    <div class="timeline-item mb-3">
                        <div class="timeline-badge bg-info">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="timeline-panel">
                            <h6 class="timeline-title">3. Input Alternatif</h6>
                            <p class="text-muted mb-0">Tambahkan data universitas yang akan dievaluasi</p>
                            <a href="{{ route('alternatives.index') }}" class="btn btn-sm btn-outline-info mt-2">
                                Kelola Alternatif
                            </a>
                        </div>
                    </div>

                    <div class="timeline-item mb-3">
                        <div class="timeline-badge bg-warning">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="timeline-panel">
                            <h6 class="timeline-title">4. Input Nilai Penilaian</h6>
                            <p class="text-muted mb-0">Berikan nilai untuk setiap alternatif berdasarkan kriteria</p>
                            <a href="{{ route('alternatives.index') }}" class="btn btn-sm btn-outline-warning mt-2">
                                Input Nilai
                            </a>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-badge bg-danger">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <div class="timeline-panel">
                            <h6 class="timeline-title">5. Perhitungan TOPSIS</h6>
                            <p class="text-muted mb-0">Jalankan metode TOPSIS untuk mendapatkan peringkat</p>
                            <a href="{{ route('topsis.index') }}" class="btn btn-sm btn-outline-danger mt-2">
                                Hitung TOPSIS
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Results -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Hasil Perhitungan Terakhir</h6>
                <a href="{{ route('topsis.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($totalTopsisResults > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Universitas</th>
                                    <th>Skor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $topResults = App\Models\topsis_result::with('alternative')
                                        ->orderBy('rank')
                                        ->take(5)
                                        ->get();
                                @endphp
                                @forelse($topResults as $result)
                                <tr>
                                    <td class="font-weight-bold">
                                        @if($result->rank == 1)
                                            <i class="fas fa-trophy text-warning"></i>
                                        @endif
                                        {{ $result->rank }}
                                    </td>
                                    <td>{{ $result->alternative->Name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $result->rank <= 3 ? 'success' : 'secondary' }}">
                                            {{ number_format($result->score, 4) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        Belum ada hasil perhitungan
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-calculator fa-3x text-gray-300 mb-3"></i>
                        <p class="text-muted">Belum ada perhitungan TOPSIS</p>
                        <a href="{{ route('topsis.calculate') }}" class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('calc-form').submit();">
                            <i class="fas fa-play"></i> Mulai Perhitungan
                        </a>
                        <form id="calc-form" action="{{ route('topsis.calculate') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats Row -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Ringkasan Sistem</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="border-right">
                            <h5 class="font-weight-bold text-primary">{{ $alternativeCount }}</h5>
                            <p class="text-muted mb-0">Universitas</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border-right">
                            <h5 class="font-weight-bold text-success">{{ $totalCriteria }}</h5>
                            <p class="text-muted mb-0">Kriteria Penilaian</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border-right">
                            <h5 class="font-weight-bold text-info">
                                {{ App\Models\alternatives_score::count() }}
                            </h5>
                            <p class="text-muted mb-0">Data Penilaian</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h5 class="font-weight-bold text-warning">{{ $totalTopsisResults }}</h5>
                        <p class="text-muted mb-0">Hasil Perhitungan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 50px;
}

.timeline-item {
    position: relative;
}

.timeline-badge {
    position: absolute;
    left: -50px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
}

.timeline-panel {
    padding-left: 20px;
    border-left: 2px solid #e3e6f0;
    padding-bottom: 20px;
}

.timeline-item:last-child .timeline-panel {
    border-left: none;
}

.timeline-title {
    font-weight: 600;
    margin-bottom: 5px;
}
</style>
@endpush
@endsection