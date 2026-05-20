@extends('layouts.app')

@section('title', 'Dashboard')
@section('subtitle', 'Ringkasan iuran jimpitan minggu ini')

@section('content')
@php
    $rt = \App\Models\Setting::get('rt_name', 'RT/RW Belum Diatur');
    $desa = \App\Models\Setting::get('desa');
    $kelurahan = \App\Models\Setting::get('kelurahan');
    $kecamatan = \App\Models\Setting::get('kecamatan');
    $kabupaten = \App\Models\Setting::get('kabupaten');
    
    $alamatParts = [];
    if ($kelurahan) $alamatParts[] = "Kel. $kelurahan";
    if ($kecamatan) $alamatParts[] = "Kec. $kecamatan";
    if ($kabupaten) $alamatParts[] = $kabupaten;
    
    $alamatLengkap = count($alamatParts) > 0 ? implode(', ', $alamatParts) : 'Alamat belum dilengkapi di menu pengaturan';
    $titleDukuh = $desa ? "Dukuh " . $desa : "Lingkungan";
@endphp

<div style="background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%); border-radius: 20px; padding: 1.5rem 2rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 1.5rem; box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.4); position: relative; overflow: hidden;">
    <!-- Elemen dekoratif -->
    <div style="position: absolute; top: -50px; right: -20px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
    <div style="position: absolute; bottom: -30px; right: 80px; width: 80px; height: 80px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
    
    <div style="width: 60px; height: 60px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); color: white; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; border: 1px solid rgba(255,255,255,0.4); z-index: 1;">
        <i class="fas fa-map-marked-alt"></i>
    </div>
    <div style="z-index: 1;">
        <h2 style="font-size: 1.4rem; font-weight: 800; color: white; margin-bottom: 0.2rem; letter-spacing: -0.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">{{ $titleDukuh }} {{ $rt }}</h2>
        <p style="font-size: 0.95rem; color: rgba(255, 255, 255, 0.9); font-weight: 500;">
            {{ $alamatLengkap }}
        </p>
    </div>
</div>

<div class="dashboard-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
    <div class="card stat-card" style="border-top: 6px solid var(--primary-light);">
        <div class="stat-content">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div style="font-size: 0.9rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">Warga Aktif</div>
                    <div style="font-size: 2.5rem; font-weight: 800; color: var(--text-main); margin: 0.5rem 0;">{{ $totalHouses }}</div>
                </div>
                <div style="width: 50px; height: 50px; background: rgba(16, 185, 129, 0.2); border-radius: 15px; display: flex; align-items: center; justify-content: center; color: var(--primary-light); font-size: 1.2rem;">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div style="font-size: 0.85rem; color: var(--primary-light); font-weight: 600;">
                <i class="fas fa-check-circle"></i> Terdaftar di Sistem
            </div>
        </div>
    </div>

    <div class="card stat-card" style="border-top: 6px solid var(--primary);">
        <div class="stat-content">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div style="font-size: 0.9rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">Sudah Setor</div>
                    <div style="font-size: 2.5rem; font-weight: 800; color: var(--text-main); margin: 0.5rem 0;">{{ $paidThisWeek }}</div>
                </div>
                <div style="width: 50px; height: 50px; background: rgba(16, 185, 129, 0.2); border-radius: 15px; display: flex; align-items: center; justify-content: center; color: var(--primary-light); font-size: 1.2rem;">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
            </div>
            <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">
                Minggu {{ $week }}, {{ $year }}
            </div>
        </div>
    </div>

    <div class="card stat-card" style="border-top: 6px solid #FDA4AF;">
        <div class="stat-content">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div style="font-size: 0.9rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">Belum Setor</div>
                    <div style="font-size: 2.5rem; font-weight: 800; color: #FDA4AF; margin: 0.5rem 0;">{{ $unpaidCount }}</div>
                </div>
                <div style="width: 50px; height: 50px; background: rgba(225, 29, 72, 0.2); border-radius: 15px; display: flex; align-items: center; justify-content: center; color: #FDA4AF; font-size: 1.2rem;">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <div style="font-size: 0.85rem; color: #FDA4AF; font-weight: 600;">
                <i class="fas fa-exclamation-triangle"></i> Perlu Pengingat
            </div>
        </div>
    </div>

    <div class="card stat-card" style="border-top: 6px solid #93C5FD;">
        <div class="stat-content">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div style="font-size: 0.9rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">Notif WA</div>
                    <div style="font-size: 2.5rem; font-weight: 800; color: #93C5FD; margin: 0.5rem 0;">{{ $totalNotifSent }}</div>
                </div>
                <div style="width: 50px; height: 50px; background: rgba(59, 130, 246, 0.2); border-radius: 15px; display: flex; align-items: center; justify-content: center; color: #93C5FD; font-size: 1.2rem;">
                    <i class="fab fa-whatsapp"></i>
                </div>
            </div>
            <div style="font-size: 0.85rem; color: #93C5FD; font-weight: 600;">
                Terkirim Minggu Ini
            </div>
        </div>
    </div>

    <div class="card stat-card" style="border-top: 6px solid var(--accent);">
        <div class="stat-content">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div style="font-size: 0.9rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">Saldo Kas</div>
                    <div style="font-size: 1.8rem; font-weight: 800; color: var(--accent); margin: 0.5rem 0;">Rp {{ number_format($saldoKas, 0, ',', '.') }}</div>
                </div>
                <div style="width: 50px; height: 50px; background: rgba(245, 158, 11, 0.2); border-radius: 15px; display: flex; align-items: center; justify-content: center; color: var(--accent); font-size: 1.2rem;">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
            <div style="font-size: 0.85rem; color: var(--accent); font-weight: 600;">
                Total Pemasukan - Pengeluaran
            </div>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1.6fr 1fr; gap: 2.5rem;">
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h3 style="font-size: 1.3rem; font-weight: 800; color: var(--accent); letter-spacing: -0.5px;">Daftar Belum Bayar</h3>
                <p style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500;">Rumah yang belum tercatat setor jimpitan</p>
            </div>
            <form action="{{ route('notifications.blast') }}" method="POST" onsubmit="return confirm('Kirim pengingat WA ke semua rumah yang belum bayar?')">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <i class="fab fa-whatsapp"></i> Blast Pengingat
                </button>
            </form>
        </div>
        
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: separate; border-spacing: 0 10px;">
                <thead>
                    <tr style="text-align: left; color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">
                        <th style="padding: 0 1rem;">No. Rumah</th>
                        <th style="padding: 0 1rem;">Tuan Rumah</th>
                        <th style="padding: 0 1rem; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($unpaidHouses as $house)
                    <tr style="background: rgba(255, 255, 255, 0.6); border-radius: 16px;">
                        <td style="padding: 1.2rem 1rem; font-weight: 800; color: var(--text-main); border-radius: 16px 0 0 16px;">
                            <span style="background: rgba(16, 185, 129, 0.1); padding: 0.4rem 0.8rem; border-radius: 10px; border: 1px solid rgba(16, 185, 129, 0.2);">{{ $house->house_number }}</span>
                        </td>
                        <td style="padding: 1.2rem 1rem; font-weight: 600; color: var(--text-main);">{{ $house->owner_name }}</td>
                        <td style="padding: 1.2rem 1rem; text-align: right; border-radius: 0 16px 16px 0;">
                            <form action="{{ route('notifications.send') }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="house_id" value="{{ $house->id }}">
                                <button type="submit" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.75rem;">
                                    <i class="fab fa-whatsapp"></i> Kirim
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="padding: 3rem; text-align: center;">
                            <div style="font-size: 3rem; margin-bottom: 1rem;">🎉</div>
                            <h4 style="font-weight: 800; color: var(--text-main);">Luar Biasa!</h4>
                            <p style="color: var(--text-muted);">Semua warga sudah membayar jimpitan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--text-main);">Aktivitas Terbaru</h3>
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            @forelse($recentPayments as $payment)
            <div style="display: flex; gap: 12px; align-items: flex-start; padding-bottom: 1rem; border-bottom: 1px solid rgba(16, 185, 129, 0.2);">
                <div style="width: 36px; height: 36px; background-color: rgba(16, 185, 129, 0.15); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--primary-dark);">
                    <i class="fas fa-check"></i>
                </div>
                <div>
                    <div style="font-weight: 600; font-size: 0.9rem; color: var(--text-main);">{{ $payment->house->owner_name }} ({{ $payment->house->house_number }})</div>
                    <div style="font-size: 0.8rem; color: var(--text-muted);">Bayar Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
                    <div style="font-size: 0.75rem; color: var(--primary-light); margin-top: 2px;">{{ $payment->paid_at->diffForHumans() }}</div>
                </div>
            </div>
            @empty
            <div style="text-align: center; color: var(--text-muted); padding: 2rem 0;">Belum ada data pembayaran.</div>
            @endforelse
        </div>
        <div style="margin-top: 1.5rem; text-align: center;">
            <a href="{{ route('payments.history') }}" style="color: var(--primary-dark); font-size: 0.85rem; font-weight: 600; text-decoration: none;">Lihat Semua Riwayat →</a>
        </div>
    </div>
</div>
@endsection
