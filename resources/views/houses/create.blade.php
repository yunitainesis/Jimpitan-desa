@extends('layouts.app')

@section('title', 'Tambah Rumah')

@section('content')
<div style="max-width: 600px;">
    <div class="card">
        <form action="{{ route('houses.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Nomor Rumah</label>
                <input type="text" name="house_number" class="form-control" placeholder="Contoh: A-01" required style="padding: 0.75rem; border-radius: 10px; border: 1px solid var(--primary-light); width: 100%;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Nama Tuan Rumah</label>
                <input type="text" name="owner_name" class="form-control" placeholder="Nama Lengkap" required style="padding: 0.75rem; border-radius: 10px; border: 1px solid var(--primary-light); width: 100%;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Nomor WhatsApp</label>
                <input type="text" name="phone_number" class="form-control" placeholder="Contoh: 628123456789" style="padding: 0.75rem; border-radius: 10px; border: 1px solid var(--primary-light); width: 100%;">
                <small style="color: #636E72;">Gunakan format 628...</small>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Alamat Lengkap</label>
                <textarea name="address" rows="3" class="form-control" style="padding: 0.75rem; border-radius: 10px; border: 1px solid var(--primary-light); width: 100%;"></textarea>
            </div>

            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <a href="{{ route('houses.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Rumah</button>
            </div>
        </form>
    </div>
</div>
@endsection
