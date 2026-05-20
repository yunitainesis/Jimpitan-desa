@extends('layouts.app')

@section('title', 'Riwayat Pembayaran')
@section('subtitle', 'Semua transaksi jimpitan yang tercatat')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <form action="{{ route('payments.history') }}" method="GET" style="display: flex; gap: 10px; align-items: center;">
            <select name="week" class="form-control" style="padding: 0.6rem; border-radius: 10px; border: 1px solid var(--primary-light);">
                @foreach(range(1, 52) as $w)
                    <option value="{{ $w }}" {{ $week == $w ? 'selected' : '' }}>Minggu {{ $w }}</option>
                @endforeach
            </select>
            <select name="year" class="form-control" style="padding: 0.6rem; border-radius: 10px; border: 1px solid var(--primary-light);">
                @foreach(range(now()->year - 1, now()->year) as $y)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-secondary">Filter</button>
        </form>
        <div style="font-weight: 700; color: var(--primary-dark);">
            Total: {{ $payments->total() }} Transaksi
        </div>
    </div>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; border-bottom: 1px solid var(--primary-light);">
                <th style="padding: 1rem;">Waktu</th>
                <th style="padding: 1rem;">Rumah</th>
                <th style="padding: 1rem;">Pemilik</th>
                <th style="padding: 1rem;">Minggu</th>
                <th style="padding: 1rem;">Nominal</th>
                <th style="padding: 1rem; text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr style="border-bottom: 1px solid var(--primary-very-light);">
                <td style="padding: 1rem; font-size: 0.85rem;">{{ $payment->paid_at->format('d/m/Y H:i') }}</td>
                <td style="padding: 1rem; font-weight: 700;">{{ $payment->house->house_number }}</td>
                <td style="padding: 1rem;">{{ $payment->house->owner_name }}</td>
                <td style="padding: 1rem;">Ke-{{ $payment->week_number }}</td>
                <td style="padding: 1rem;">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                <td style="padding: 1rem; text-align: right;">
                    <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" onsubmit="return confirm('Hapus data pembayaran ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none; color: #E74C3C; cursor: pointer;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 1.5rem;">
        {{ $payments->links() }}
    </div>
</div>
@endsection
