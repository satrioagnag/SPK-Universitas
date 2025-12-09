{{-- Sub-Criteria Index View --}}
{{-- File: resources/views/sub_criteria/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Sub-Kriteria')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Sub-Kriteria: {{ $criterion->Name }}</h1>
        <div>
            <a href="{{ route('criteria.index') }}" class="btn btn-secondary btn-sm shadow-sm mr-2">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
            <a href="{{ route('criteria.sub_criteria.create', $criterion->id) }}" class="btn btn-primary btn-sm shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Sub-Kriteria
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Sub-Kriteria</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Label</th>
                            <th>Nilai/Skor</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subCriteria as $index => $sub)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $sub->label }}</td>
                            <td>{{ number_format($sub->Score, 2) }}</td>
                            <td>
                                <a href="{{ route('sub_criteria.edit', $sub->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('sub_criteria.destroy', $sub->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada sub-kriteria</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Sub-Criteria Create View --}}
{{-- File: resources/views/sub_criteria/create.blade.php --}}
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

{{-- Sub-Criteria Edit View --}}
{{-- File: resources/views/sub_criteria/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Sub-Kriteria')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Sub-Kriteria</h1>
        <a href="{{ route('criteria.sub_criteria.index', $criterion->id) }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Sub-Kriteria</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('sub_criteria.update', $subCriterion->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="label">Label Sub-Kriteria</label>
                    <input type="text" class="form-control @error('label') is-invalid @enderror" 
                           id="label" name="label" value="{{ old('label', $subCriterion->label) }}" required>
                    @error('label')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="score">Nilai/Skor</label>
                    <input type="number" step="0.01" class="form-control @error('score') is-invalid @enderror" 
                           id="score" name="score" value="{{ old('score', $subCriterion->Score) }}" required>
                    @error('score')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('criteria.sub_criteria.index', $criterion->id) }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </form>
        </div>
    </div>
</div>
@endsection