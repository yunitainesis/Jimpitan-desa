@extends('layouts.app')

@section('title', 'Pengaturan')
@section('subtitle', 'Konfigurasi aplikasi dan sistem WhatsApp')

@section('content')
<div style="max-width: 800px;">
    <form action="{{ route('settings.update') }}" method="POST">
        @csrf
        <div class="card">
            <h3 style="font-weight: 700; margin-bottom: 1.5rem; border-bottom: 1px solid var(--primary-light); padding-bottom: 1rem;">Data Wilayah & Lingkungan</h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">RT/RW</label>
                    <input type="text" name="rt_name" class="form-control" value="{{ $settings['rt_name'] ?? '' }}" placeholder="Contoh: RT 003" style="padding: 0.75rem; border-radius: 10px; border: 1px solid var(--primary-light); width: 100%;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Dusun / Dukuh</label>
                    <input type="text" name="desa" class="form-control" value="{{ $settings['desa'] ?? '' }}" placeholder="Contoh: Dadapan" style="padding: 0.75rem; border-radius: 10px; border: 1px solid var(--primary-light); width: 100%;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Kelurahan / Desa</label>
                    <input type="text" name="kelurahan" class="form-control" value="{{ $settings['kelurahan'] ?? '' }}" placeholder="Contoh: Padas" style="padding: 0.75rem; border-radius: 10px; border: 1px solid var(--primary-light); width: 100%;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Kecamatan</label>
                    <input type="text" name="kecamatan" class="form-control" value="{{ $settings['kecamatan'] ?? '' }}" placeholder="Contoh: Tanon" style="padding: 0.75rem; border-radius: 10px; border: 1px solid var(--primary-light); width: 100%;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Kabupaten/Kota</label>
                    <input type="text" name="kabupaten" class="form-control" value="{{ $settings['kabupaten'] ?? '' }}" placeholder="Contoh: Sragen" style="padding: 0.75rem; border-radius: 10px; border: 1px solid var(--primary-light); width: 100%;">
                </div>
            </div>

            <h3 style="font-weight: 700; margin-top: 2rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--primary-light); padding-bottom: 1rem;">Pengaturan Iuran</h3>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Besar Iuran Per Minggu (Rp)</label>
                <input type="number" name="amount_per_week" class="form-control" value="{{ $settings['amount_per_week'] ?? 1000 }}" style="padding: 0.75rem; border-radius: 10px; border: 1px solid var(--primary-light); width: 100%;">
            </div>

            <h3 style="font-weight: 700; margin-top: 2rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--primary-light); padding-bottom: 1rem;">WhatsApp (Fonnte)</h3>
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Fonnte API Token</label>
                <input type="password" name="fonnte_token" class="form-control" value="{{ $settings['fonnte_token'] ?? '' }}" placeholder="Masukkan token API Fonnte Anda" style="padding: 0.75rem; border-radius: 10px; border: 1px solid var(--primary-light); width: 100%;">
                <p style="font-size: 0.8rem; color: #636E72; margin-top: 0.5rem;">Dapatkan di dashboard.fonnte.com. Biarkan kosong untuk mode simulasi.</p>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Template Pesan WA</label>
                <textarea name="wa_message_template" rows="8" class="form-control" style="padding: 0.75rem; border-radius: 10px; border: 1px solid var(--primary-light); width: 100%; font-family: inherit;">{{ $settings['wa_message_template'] ?? '' }}</textarea>
                <div style="font-size: 0.8rem; color: #636E72; margin-top: 0.5rem;">
                    Variabel tersedia: <strong>{nama}</strong>, <strong>{minggu}</strong>, <strong>{tahun}</strong>, <strong>{nominal}</strong>, <strong>{rt}</strong>
                </div>
            </div>

            <div style="text-align: right; margin-top: 1rem;">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </form>
</div>
@endsection
