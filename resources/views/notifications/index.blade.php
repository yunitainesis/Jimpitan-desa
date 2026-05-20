@extends('layouts.app')

@section('title', 'Log Notifikasi WhatsApp')
@section('subtitle', 'Riwayat pengiriman pesan pengingat iuran')

@section('content')
<div class="dashboard-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="card" style="border-left: 5px solid var(--primary-pastel);">
        <div style="font-size: 0.9rem; color: #636E72;">Terkirim</div>
        <div style="font-size: 1.8rem; font-weight: 700;">{{ $stats['sent'] }}</div>
    </div>
    <div class="card" style="border-left: 5px solid #FF8A65;">
        <div style="font-size: 0.9rem; color: #636E72;">Gagal</div>
        <div style="font-size: 1.8rem; font-weight: 700;">{{ $stats['failed'] }}</div>
    </div>
    <div class="card" style="border-left: 5px solid #FFD54F;">
        <div style="font-size: 0.9rem; color: #636E72;">Pending</div>
        <div style="font-size: 1.8rem; font-weight: 700;">{{ $stats['pending'] }}</div>
    </div>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3 style="font-weight: 700;">Riwayat Pesan Minggu Ke-{{ $week }}</h3>
        <form action="{{ route('notifications.blast') }}" method="POST" onsubmit="return confirm('Kirim blast ulang?')">
            @csrf
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> Blast Sekarang
            </button>
        </form>
    </div>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; border-bottom: 1px solid var(--primary-light);">
                <th style="padding: 1rem;">Rumah</th>
                <th style="padding: 1rem;">Nomor HP</th>
                <th style="padding: 1rem;">Status</th>
                <th style="padding: 1rem;">Waktu Kirim</th>
                <th style="padding: 1rem;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notifications as $notif)
            <tr style="border-bottom: 1px solid var(--primary-very-light);">
                <td style="padding: 1rem;">
                    <div style="font-weight: 600;">{{ $notif->house->owner_name }}</div>
                    <div style="font-size: 0.8rem; color: #636E72;">{{ $notif->house->house_number }}</div>
                </td>
                <td style="padding: 1rem;">{{ $notif->phone_number }}</td>
                <td style="padding: 1rem;">
                    @if($notif->status === 'sent')
                        <span class="badge badge-success">Terkirim</span>
                    @elseif($notif->status === 'failed')
                        <span class="badge badge-danger">Gagal</span>
                    @else
                        <span class="badge" style="background-color: #FFF9C4; color: #F57F17;">Pending</span>
                    @endif
                </td>
                <td style="padding: 1rem;">{{ $notif->sent_at ? $notif->sent_at->format('d M H:i') : '-' }}</td>
                <td style="padding: 1rem; font-size: 0.85rem; color: #636E72;">
                    {{ $notif->error_message ?? 'Sukses' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 1.5rem;">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
