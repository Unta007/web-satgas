<div class="mb-3">
    <label for="quote" class="form-label">Isi Testimoni</label>
    <textarea class="form-control @error('quote') is-invalid @enderror" id="quote" name="quote" rows="4" required>{{ old('quote', $testimonial->quote ?? '') }}</textarea>
    @error('quote')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-check form-switch mb-3">
    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1"
        {{ old('is_active', $testimonial->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Aktifkan Testimoni (Tampilkan di Halaman Utama)</label>
</div>

<div class="d-flex justify-content-between align-items-right">
    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">Batal</a>
    <button type="submit" class="btn btn-primary">{{ $buttonText ?? 'Simpan' }}</button>
</div>
