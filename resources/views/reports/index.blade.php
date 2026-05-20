@extends('layouts.app')

@section('title', 'Laporan Iuran')
@section('subtitle', 'Rekapitulasi iuran jimpitan bulanan')

@section('content')
<div class="card" style="margin-bottom: 2rem;">
    <form action="{{ route('reports.index') }}" method="GET" style="display: flex; gap: 1rem; align-items: flex-end;">
        <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Bulan</label>
            <select name="month" class="form-control" style="padding: 0.6rem; border-radius: 10px; border: 1px solid var(--primary-light); width: 100%;">
                @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Tahun</label>
            <select name="year" class="form-control" style="padding: 0.6rem; border-radius: 10px; border: 1px solid var(--primary-light); width: 100%;">
                @foreach(range(now()->year - 2, now()->year) as $y)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Tampilkan</button>
    </form>
</div>

<div class="dashboard-grid" style="display: grid; grid-template-columns: 1fr; gap: 1.5rem; margin-bottom: 2rem;">
    <div class="card" style="text-align: center; border-bottom: 5px solid var(--primary-pastel);">
        <div style="font-size: 1rem; color: #636E72;">Total Dana Terkumpul</div>
        <div style="font-size: 2.5rem; font-weight: 800; color: var(--primary-dark); margin: 0.5rem 0;">
            Rp {{ number_format($totalCollected, 0, ',', '.') }}
        </div>
        <div style="color: #636E72;">Periode {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $year }}</div>
    </div>
</div>

<div class="card">
    <h3 style="font-weight: 700; margin-bottom: 1.5rem;">Detail Per Rumah</h3>
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; border-bottom: 1px solid var(--primary-light);">
                <th style="padding: 1rem;">No. Rumah</th>
                <th style="padding: 1rem;">Pemilik</th>
                <th style="padding: 1rem; text-align: center;">Jumlah Bayar (Minggu)</th>
                <th style="padding: 1rem; text-align: right;">Total Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($monthlyReport as $report)
            <tr style="border-bottom: 1px solid var(--primary-very-light);">
                <td style="padding: 1rem; font-weight: 600;">{{ $report->house->house_number }}</td>
                <td style="padding: 1rem;">{{ $report->house->owner_name }}</td>
                <td style="padding: 1rem; text-align: center;">{{ $report->total_payments }} kali</td>
                <td style="padding: 1rem; text-align: right; font-weight: 700;">
                    Rp {{ number_format($report->total_amount, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
            @if($monthlyReport->isEmpty())
            <tr>
                <td colspan="4" style="padding: 3rem; text-align: center; color: #B2BEC3;">Tidak ada data pembayaran untuk periode ini.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
