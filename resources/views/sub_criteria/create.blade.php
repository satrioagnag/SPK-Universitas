@extends('layouts.app')

@section('title', 'Tambah Sub-Kriteria')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Sub-Kriteria</h1>
        <a href="{{ route('criteria.sub_criteria.index', $criterion->id) }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Sub-Kriteria untuk: {{ $criterion->Name }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('criteria.sub_criteria.store', $criterion->id) }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="label">Label Sub-Kriteria</label>
                    <input type="text" class="form-control @error('label') is-invalid @enderror" 
                           id="label" name="label" value="{{ old('label') }}" 
                           placeholder="Contoh: Sangat Baik" required>
                    @error('label')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="score">Nilai/Skor</label>
                    <input type="number" step="0.01" class="form-control @error('score') is-invalid @enderror" 
                           id="score" name="score" value="{{ old('score') }}" 
                           placeholder="Contoh: 5" required>
                    @error('score')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('criteria.sub_criteria.index', $criterion->id) }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </form>
        </div>
    </div>
</div>
@endsection