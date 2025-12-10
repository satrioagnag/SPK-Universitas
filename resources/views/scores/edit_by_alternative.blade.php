@extends('layouts.app')

@section('title', 'Input Nilai Alternatif')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Input Nilai - {{ $alternative->Name }}</h1>
        <a href="{{ route('alternatives.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Penilaian Kriteria</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('alternatives.scores.update', $alternative->id) }}" method="POST">
                @csrf
                @method('PUT')

                @foreach($criteria as $criterion)
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <strong>{{ $criterion->Code }} - {{ $criterion->Name }}</strong>
                        <span class="badge badge-{{ $criterion->Type == 'benefit' ? 'success' : 'warning' }} float-right">
                            {{ ucfirst($criterion->Type) }}
                        </span>
                    </div>
                    <div class="card-body">
                        @php
                            $score = $scores->get($criterion->id);
                            $hasSub = $criterion->subCriteria->isNotEmpty();
                        @endphp

                        @if($hasSub)
                            <div class="form-group">
                                <label>Pilih Sub-Kriteria</label>
                                <select class="form-control" name="criteria[{{ $criterion->id }}][sub_criterion_id]">
                                    <option value="">-- Pilih --</option>
                                    @foreach($criterion->subCriteria as $sub)
                                        <option value="{{ $sub->id }}" 
                                                data-score="{{ $sub->Score }}"
                                                {{ $score && $score->sub_criterion_id == $sub->id ? 'selected' : '' }}>
                                            {{ $sub->label }} (Nilai: {{ $sub->Score }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" 
                                   name="criteria[{{ $criterion->id }}][value]" 
                                   value="{{ $score->Score ?? '' }}"
                                   class="auto-fill-value">
                        @else
                            <div class="form-group">
                                <label>Nilai</label>
                                <input type="number" 
                                       step="0.01" 
                                       class="form-control" 
                                       name="criteria[{{ $criterion->id }}][value]"
                                       value="{{ $score->Score ?? '' }}"
                                       placeholder="Masukkan nilai">
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Nilai
                </button>
                <a href="{{ route('alternatives.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('select').on('change', function() {
            var selectedOption = $(this).find(':selected');
            var score = selectedOption.data('score');
            var hiddenInput = $(this).closest('.card-body').find('.auto-fill-value');
            if (score !== undefined) {
                hiddenInput.val(score);
            }
        });
    });
</script>
@endpush
@endsection