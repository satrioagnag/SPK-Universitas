@extends('layouts.app')

@section('title', 'AHP - Perbandingan Berpasangan')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">AHP - Perbandingan Berpasangan Kriteria</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Matriks Perbandingan</h6>
            <form action="{{ route('ahp.calculate') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fas fa-calculator"></i> Hitung Bobot AHP
                </button>
            </form>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <strong>Petunjuk:</strong> Masukkan nilai perbandingan kriteria baris terhadap kriteria kolom.<br>
                Skala: 1 = Sama penting, 3 = Sedikit lebih penting, 5 = Lebih penting, 7 = Sangat lebih penting, 9 = Mutlak lebih penting
            </div>

            <form action="{{ route('ahp.storeComparisons') }}" method="POST">
                @csrf
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Kriteria</th>
                                @foreach($criteria as $col)
                                    <th class="text-center">{{ $col->Code }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($criteria as $row)
                            <tr>
                                <td class="font-weight-bold">{{ $row->Code }} - {{ $row->Name }}</td>
                                @foreach($criteria as $col)
                                    <td>
                                        @if($row->id === $col->id)
                                            <input type="text" class="form-control text-center" value="1" readonly>
                                        @else
                                            @php
                                                $key = $row->id . '_' . $col->id;
                                                $value = $pairs->get($key)->value ?? '';
                                            @endphp
                                            <input type="number" 
                                                   step="0.01" 
                                                   class="form-control" 
                                                   name="pair_{{ $row->id }}_{{ $col->id }}"
                                                   value="{{ $value }}"
                                                   placeholder="1-9">
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perbandingan
                </button>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bobot Kriteria</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Kriteria</th>
                            <th>Bobot</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($criteria as $criterion)
                        <tr>
                            <td>{{ $criterion->Code }}</td>
                            <td>{{ $criterion->Name }}</td>
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