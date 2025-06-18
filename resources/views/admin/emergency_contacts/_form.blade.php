<div class="row">
    <div class="col-md-6 mb-3">
        <label for="name" class="form-label">Nama Kontak</label>
        <input type="text" class="form-control" id="name" name="name"
            value="{{ old('name', $contact->name ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="type" class="form-label">Tipe Kontak</label>
        <select class="form-select" id="type" name="type" required>
            @php $types = ['Bantuan Internal', 'Lembaga Eksternal']; @endphp
            @foreach ($types as $type)
                <option value="{{ $type }}" @selected(old('type', $contact->type ?? '') == $type)>{{ $type }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="mb-3">
    <label for="contact_info" class="form-label">Info Kontak (Nomor Telepon / Link WhatsApp)</label>
    <input type="text" class="form-control" id="contact_info" name="contact_info"
        value="{{ old('contact_info', $contact->contact_info ?? '') }}"
        placeholder="Contoh: 08123456789 atau https://wa.me/628123456789"required>
</div>
<div class="mb-3">
    <label for="description" class="form-label">Deskripsi Singkat</label>
    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $contact->description ?? '') }}</textarea>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="icon" class="form-label">Ikon (contoh: bi-telephone-fill)</label>
        <input type="text" class="form-control" id="icon" name="icon"
            value="{{ old('icon', $contact->icon ?? 'bi-telephone-fill') }}" readonly>
    </div>
    <div class="col-md-6 mb-3">
        <label for="order" class="form-label">Urutan Tampil</label>
        <input type="number" class="form-control" id="order" name="order"
            value="{{ old('order', $contact->order ?? 0) }}" required>
    </div>
</div>
<div class="form-check form-switch mb-4">
    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1"
        @checked(old('is_active', $contact->is_active ?? true))>
    <label class="form-check-label" for="is_active">Aktifkan Kontak</label>
</div>
<div class="d-flex justify-content-between align-items-right">
    <a href="{{ route('admin.emergency-contacts.index') }}" class="btn btn-secondary">Batal</a>
    <button type="submit" class="btn btn-primary">{{ $buttonText ?? 'Simpan' }}</button>
</div>
