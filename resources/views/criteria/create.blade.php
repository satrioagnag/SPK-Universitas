@extends('layouts.app')

@section('title', 'Tambah Kriteria')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Kriteria</h1>
        <a href="{{ route('criteria.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Kriteria Baru</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('criteria.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="code">Kode Kriteria</label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror" 
                           id="code" name="code" value="{{ old('code') }}" 
                           placeholder="Contoh: C1" required>
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Nama Kriteria</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" 
                           placeholder="Contoh: Akreditasi" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="type">Tipe Kriteria</label>
                    <select class="form-control @error('type') is-invalid @enderror" 
                            id="type" name="type" required>
                        <option value="">-- Pilih Tipe --</option>
                        <option value="benefit" {{ old('type') == 'benefit' ? 'selected' : '' }}>Benefit (Semakin besar semakin baik)</option>
                        <option value="cost" {{ old('type') == 'cost' ? 'selected' : '' }}>Cost (Semakin kecil semakin baik)</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="weight">Bobot Awal</label>
                    <input type="number" step="0.0001" class="form-control @error('weight') is-invalid @enderror" 
                           id="weight" name="weight" value="{{ old('weight', 0) }}" required>
                    <small class="form-text text-muted">Bobot akan dihitung ulang menggunakan AHP</small>
                    @error('weight')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('criteria.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
