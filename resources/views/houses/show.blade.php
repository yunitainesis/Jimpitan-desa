@extends('layouts.app')

@section('title', 'Detail Rumah')

@section('content')
<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem;">
    <div class="card">
        <div style="text-align: center; margin-bottom: 2rem;">
            <div style="margin-bottom: 1rem;">
                {!! QrCode::size(180)->generate($house->qr_token) !!}
            </div>
            <h2 style="font-weight: 800; font-size: 1.8rem; margin: 0;">{{ $house->house_number }}</h2>
            <p style="color: #636E72;">{{ $house->owner_name }}</p>
            
            <div style="margin-top: 1.5rem; display: flex; gap: 8px; justify-content: center;">
                <a href="{{ route('houses.print-qr', $house->id) }}" class="btn btn-primary">
                    <i class="fas fa-print"></i> Cetak QR
                </a>
                <a href="{{ route('houses.download-qr', $house->id) }}" class="btn btn-success">
                    <i class="fas fa-download"></i> Save QR
                </a>
                <form action="{{ route('houses.regenerate-qr', $house->id) }}" method="POST" onsubmit="return confirm('QR Code lama tidak akan bisa digunakan lagi. Lanjut?')">
                    @csrf
                    <button type="submit" class="btn btn-secondary">Regen</button>
                </form>
            </div>
        </div>

        <div style="border-top: 1px solid var(--primary-light); padding-top: 1.5rem;">
            <div style="margin-bottom: 1rem;">
                <span style="font-size: 0.8rem; color: #636E72; display: block;">WhatsApp</span>
                <span style="font-weight: 600;">{{ $house->phone_number ?? '-' }}</span>
            </div>
            <div style="margin-bottom: 1rem;">
                <span style="font-size: 0.8rem; color: #636E72; display: block;">Alamat</span>
                <span style="font-weight: 600;">{{ $house->address ?? '-' }}</span>
            </div>
            <div>
                <span style="font-size: 0.8rem; color: #636E72; display: block;">Status Minggu Ini</span>
                @if($house->hasPaidThisWeek())
                    <span class="badge badge-success">Sudah Bayar</span>
                @else
                    <span class="badge badge-danger">Belum Bayar</span>
                @endif
            </div>
        </div>
    </div>

    <div class="card">
        <h3 style="font-weight: 700; margin-bottom: 1.5rem;">Riwayat Pembayaran</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; border-bottom: 1px solid var(--primary-light);">
                    <th style="padding: 1rem;">Minggu/Tahun</th>
                    <th style="padding: 1rem;">Tanggal Bayar</th>
                    <th style="padding: 1rem;">Nominal</th>
                    <th style="padding: 1rem;">Pencatat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paymentHistory as $payment)
                <tr style="border-bottom: 1px solid var(--primary-very-light);">
                    <td style="padding: 1rem; font-weight: 600;">W-{{ $payment->week_number }} ({{ $payment->year }})</td>
                    <td style="padding: 1rem;">{{ $payment->paid_at->format('d M Y H:i') }}</td>
                    <td style="padding: 1rem;">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td style="padding: 1rem; font-size: 0.85rem; color: #636E72;">{{ $payment->recorder->name }}</td>
                </tr>
                @endforeach
                @if($paymentHistory->isEmpty())
                <tr>
                    <td colspan="4" style="padding: 3rem; text-align: center; color: #B2BEC3;">Belum ada riwayat pembayaran.</td>
                </tr>
                @endif
            </tbody>
        </table>
        <div style="margin-top: 1rem;">
            {{ $paymentHistory->links() }}
        </div>
    </div>
</div>
@endsection
