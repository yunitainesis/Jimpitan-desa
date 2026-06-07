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

<!-- Sisa Saldo Kas Aktif Kumulatif (Hingga Saat Ini) -->
<div style="background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%); border-radius: 20px; padding: 1.5rem 2rem; margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1.5rem; box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.4); position: relative; overflow: hidden; animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;">
    <!-- Elemen dekoratif -->
    <div style="position: absolute; top: -50px; right: -20px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
    <div style="position: absolute; bottom: -30px; right: 80px; width: 80px; height: 80px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
    
    <div style="display: flex; align-items: center; gap: 1.25rem; z-index: 1;">
        <div style="width: 55px; height: 55px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); color: white; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; border: 1px solid rgba(255,255,255,0.4);">
            <i class="fas fa-wallet"></i>
        </div>
        <div>
            <h2 style="font-size: 0.85rem; font-weight: 700; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.1rem; text-transform: uppercase; letter-spacing: 1px;">Saldo Kas Aktif Saat Ini (Kumulatif)</h2>
            <div style="font-size: 2.2rem; font-weight: 800; color: white; line-height: 1.1; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                Rp {{ number_format($saldoKasAllTime, 0, ',', '.') }}
            </div>
        </div>
    </div>
    
    <div style="display: flex; gap: 1rem; z-index: 1; color: white; font-size: 0.85rem; font-weight: 600; flex-wrap: wrap;">
        <div style="background: rgba(255,255,255,0.1); padding: 0.5rem 1rem; border-radius: 10px; border: 1px solid rgba(255,255,255,0.15); min-width: 140px;">
            <div style="color: rgba(255,255,255,0.7); text-transform: uppercase; font-size: 0.65rem; margin-bottom: 2px; letter-spacing: 0.5px;">Total Pemasukan</div>
            <span style="font-size: 0.95rem; font-weight: 800;">Rp {{ number_format($totalCollectedAllTime, 0, ',', '.') }}</span>
        </div>
        <div style="background: rgba(255,255,255,0.1); padding: 0.5rem 1rem; border-radius: 10px; border: 1px solid rgba(255,255,255,0.15); min-width: 140px;">
            <div style="color: rgba(255,255,255,0.7); text-transform: uppercase; font-size: 0.65rem; margin-bottom: 2px; letter-spacing: 0.5px;">Total Pengeluaran</div>
            <span style="font-size: 0.95rem; font-weight: 800;">Rp {{ number_format($totalExpensesAllTime, 0, ',', '.') }}</span>
        </div>
    </div>
</div>

<!-- Grid Laporan Bulanan -->
<div class="dashboard-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
    <!-- Pemasukan Periode Ini -->
    <div class="card" style="border-top: 6px solid var(--primary); display: flex; flex-direction: column; justify-content: space-between;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
            <div>
                <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Pemasukan Periode Ini</div>
                <div style="font-size: 1.8rem; font-weight: 800; color: var(--text-main); margin: 0.5rem 0;">
                    Rp {{ number_format($totalCollected, 0, ',', '.') }}
                </div>
            </div>
            <div style="width: 45px; height: 45px; background: rgba(16, 185, 129, 0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary-dark); font-size: 1.1rem;">
                <i class="fas fa-arrow-down"></i>
            </div>
        </div>
        <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 500;">
            Periode {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $year }}
        </div>
    </div>

    <!-- Pengeluaran Periode Ini -->
    <div class="card" style="border-top: 6px solid #FDA4AF; display: flex; flex-direction: column; justify-content: space-between;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
            <div>
                <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Pengeluaran Periode Ini</div>
                <div style="font-size: 1.8rem; font-weight: 800; color: #E11D48; margin: 0.5rem 0;">
                    Rp {{ number_format($totalExpenses, 0, ',', '.') }}
                </div>
            </div>
            <div style="width: 45px; height: 45px; background: rgba(225, 29, 72, 0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #E11D48; font-size: 1.1rem;">
                <i class="fas fa-arrow-up"></i>
            </div>
        </div>
        <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 500;">
            Periode {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $year }}
        </div>
    </div>

    <!-- Sisa Saldo Periode Ini -->
    <div class="card" style="border-top: 6px solid var(--accent); display: flex; flex-direction: column; justify-content: space-between;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
            <div>
                <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Sisa Kas Periode Ini</div>
                <div style="font-size: 1.8rem; font-weight: 800; color: var(--accent); margin: 0.5rem 0;">
                    Rp {{ number_format($saldoPeriode, 0, ',', '.') }}
                </div>
            </div>
            <div style="width: 45px; height: 45px; background: rgba(245, 158, 11, 0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--accent); font-size: 1.1rem;">
                <i class="fas fa-scale-balanced"></i>
            </div>
        </div>
        <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 500;">
            Periode {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $year }}
        </div>
    </div>
</div>

<!-- Detail Pemasukan (Jimpitan) -->
<div class="card" style="margin-bottom: 2rem;">
    <h3 style="font-weight: 800; margin-bottom: 1.5rem; color: var(--text-main); font-size: 1.25rem;">Detail Pemasukan Per Rumah</h3>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: separate; border-spacing: 0 10px;">
            <thead>
                <tr style="text-align: left; color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">
                    <th style="padding: 0 1rem; font-weight: 700;">No. Rumah</th>
                    <th style="padding: 0 1rem; font-weight: 700;">Pemilik</th>
                    <th style="padding: 0 1rem; text-align: right; font-weight: 700;">Total Nominal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($monthlyReport as $report)
                <tr style="background: rgba(255, 255, 255, 0.6); border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.05);">
                    <td style="padding: 1.2rem 1rem; border-radius: 16px 0 0 16px;">
                        <span style="background: rgba(16, 185, 129, 0.1); padding: 0.4rem 0.8rem; border-radius: 10px; border: 1px solid rgba(16, 185, 129, 0.2); font-weight: 800; color: var(--text-main);">
                            {{ $report->house->house_number }}
                        </span>
                    </td>
                    <td style="padding: 1.2rem 1rem; font-weight: 600; color: var(--text-main);">{{ $report->house->owner_name }}</td>
                    <td style="padding: 1.2rem 1rem; text-align: right; font-weight: 800; color: var(--primary-dark); border-radius: 0 16px 16px 0;">
                        Rp {{ number_format($report->total_amount, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
                @if($monthlyReport->isEmpty())
                <tr>
                    <td colspan="3" style="padding: 3rem; text-align: center; color: var(--text-muted); background: rgba(255, 255, 255, 0.6); border-radius: 16px;">
                        Tidak ada data pembayaran untuk periode ini.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<!-- Detail Pengeluaran (Buku Pengeluaran) -->
<div class="card">
    <h3 style="font-weight: 800; margin-bottom: 1.5rem; color: var(--text-main); font-size: 1.25rem;">Detail Pengeluaran Kas</h3>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: separate; border-spacing: 0 10px;">
            <thead>
                <tr style="text-align: left; color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">
                    <th style="padding: 0 1rem; font-weight: 700; width: 160px;">Tanggal</th>
                    <th style="padding: 0 1rem; font-weight: 700;">Keterangan / Keperluan</th>
                    <th style="padding: 0 1rem; font-weight: 700; width: 180px;">Dicatat Oleh</th>
                    <th style="padding: 0 1rem; text-align: right; font-weight: 700; width: 180px;">Nominal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($monthlyExpenses as $expense)
                <tr style="background: rgba(255, 255, 255, 0.6); border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(225, 29, 72, 0.05);">
                    <td style="padding: 1.2rem 1rem; border-radius: 16px 0 0 16px;">
                        <span style="background: rgba(225, 29, 72, 0.08); padding: 0.4rem 0.8rem; border-radius: 10px; border: 1px solid rgba(225, 29, 72, 0.15); font-weight: 700; color: #E11D48;">
                            {{ $expense->date->format('d M Y') }}
                        </span>
                    </td>
                    <td style="padding: 1.2rem 1rem; font-weight: 600; color: var(--text-main);">{{ $expense->description }}</td>
                    <td style="padding: 1.2rem 1rem; color: var(--text-muted); font-weight: 500;">{{ $expense->recorder->name ?? 'Sistem' }}</td>
                    <td style="padding: 1.2rem 1rem; text-align: right; font-weight: 800; color: #E11D48; border-radius: 0 16px 16px 0;">
                        Rp {{ number_format($expense->amount, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
                @if($monthlyExpenses->isEmpty())
                <tr>
                    <td colspan="4" style="padding: 3rem; text-align: center; color: var(--text-muted); background: rgba(255, 255, 255, 0.6); border-radius: 16px;">
                        Tidak ada data pengeluaran untuk periode ini.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
