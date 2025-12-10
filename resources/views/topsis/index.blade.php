@extends('layouts.app')

@section('title', 'TOPSIS - Hasil Perhitungan')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">TOPSIS - Hasil Perhitungan</h1>
        <form action="{{ route('topsis.calculate') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-success btn-sm shadow-sm">
                <i class="fas fa-calculator fa-sm text-white-50"></i> Hitung TOPSIS
            </button>
        </form>
    </div>

    @if($lastRun)
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> 
        Perhitungan terakhir: {{ $lastRun->run_at->format('d M Y H:i:s') }}
        @if($lastRun->note)
            - {{ $lastRun->note }}
        @endif
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Hasil Perangkingan</h6>
        </div>
        <div class="card-body">
            @if($results->isEmpty())
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> 
                    Belum ada hasil perhitungan. Silakan klik tombol "Hitung TOPSIS" untuk memulai.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Peringkat</th>
                                <th>Kode</th>
                                <th>Nama Universitas</th>
                                <th>Skor Preferensi</th>
                                <th>D+</th>
                                <th>D-</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $result)
                            <tr class="{{ $result->rank <= 3 ? 'table-success' : '' }}">
                                <td class="text-center font-weight-bold">
                                    @if($result->rank == 1)
                                        <i class="fas fa-trophy text-warning"></i>
                                    @elseif($result->rank == 2)
                                        <i class="fas fa-medal text-secondary"></i>
                                    @elseif($result->rank == 3)
                                        <i class="fas fa-medal text-danger"></i>
                                    @endif
                                    {{ $result->rank }}
                                </td>
                                <td>{{ $result->alternative->Code }}</td>
                                <td>{{ $result->alternative->Name }}</td>
                                <td class="font-weight-bold text-primary">
                                    {{ number_format($result->score, 6) }}
                                </td>
                                <td>{{ number_format($result->d_plus ?? 0, 6) }}</td>
                                <td>{{ number_format($result->d_minus ?? 0, 6) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <h5>Interpretasi Hasil:</h5>
                    <ul>
                        <li>Skor Preferensi mendekati 1 menunjukkan alternatif yang lebih baik</li>
                        <li>D+ adalah jarak ke solusi ideal positif (semakin kecil semakin baik)</li>
                        <li>D- adalah jarak ke solusi ideal negatif (semakin besar semakin baik)</li>
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bobot Kriteria yang Digunakan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Kriteria</th>
                            <th>Tipe</th>
                            <th>Bobot</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\Criteria::where('is_active', true)->get() as $criterion)
                        <tr>
                            <td>{{ $criterion->Code }}</td>
                            <td>{{ $criterion->Name }}</td>
                            <td>
                                <span class="badge badge-{{ $criterion->Type == 'benefit' ? 'success' : 'warning' }}">
                                    {{ ucfirst($criterion->Type) }}
                                </span>
                            </td>
                            <td>{{ number_format($criterion->Weight ?? 0, 4) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection