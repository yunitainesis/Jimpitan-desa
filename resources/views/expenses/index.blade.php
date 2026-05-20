@extends('layouts.app')

@section('title', 'Buku Pengeluaran')
@section('subtitle', 'Catat pengeluaran kas jimpitan seperti jenguk warga, perbaikan, dll')

@section('content')
<div style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem; align-items: start;">
    
    <!-- Daftar Pengeluaran -->
    <div>
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--text-main);">Daftar Pengeluaran</h2>
                
                <form action="{{ route('expenses.index') }}" method="GET" style="display: flex; gap: 10px;">
                    <select name="month" class="form-control" onchange="this.form.submit()" style="padding: 0.5rem; border-radius: 8px;">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $m, 10)) }}
                            </option>
                        @endforeach
                    </select>
                    <select name="year" class="form-control" onchange="this.form.submit()" style="padding: 0.5rem; border-radius: 8px;">
                        @foreach(range(date('Y')-2, date('Y')) as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            @if(session('success'))
                <div class="alert alert-success" style="background: rgba(16, 185, 129, 0.1); color: var(--primary-dark); border-color: rgba(16, 185, 129, 0.2);">
                    {{ session('success') }}
                </div>
            @endif

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: separate; border-spacing: 0 8px;">
                    <thead>
                        <tr style="text-align: left; color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">
                            <th style="padding: 0 1rem 1rem 1rem;">Tanggal</th>
                            <th style="padding: 0 1rem 1rem 1rem;">Keterangan</th>
                            <th style="padding: 0 1rem 1rem 1rem; text-align: right;">Nominal</th>
                            <th style="padding: 0 1rem 1rem 1rem; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $expense)
                        <tr style="background: rgba(255, 255, 255, 0.6); border-radius: 12px; transition: all 0.2s;">
                            <td style="padding: 1rem; color: var(--text-main); font-weight: 600; border-radius: 12px 0 0 12px;">
                                {{ $expense->date->format('d M Y') }}
                            </td>
                            <td style="padding: 1rem; color: var(--text-main);">
                                {{ $expense->description }}
                                <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 2px;">Oleh: {{ $expense->recorder->name ?? '-' }}</div>
                            </td>
                            <td style="padding: 1rem; text-align: right; font-weight: 800; color: #E74C3C;">
                                Rp {{ number_format($expense->amount, 0, ',', '.') }}
                            </td>
                            <td style="padding: 1rem; text-align: center; border-radius: 0 12px 12px 0;">
                                <form action="{{ route('expenses.destroy', $expense) }}" method="POST" onsubmit="return confirm('Hapus data pengeluaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: none; color: #E74C3C; cursor: pointer; padding: 0.5rem; border-radius: 8px; transition: background 0.2s;" onmouseover="this.style.background='rgba(231, 76, 60, 0.1)'" onmouseout="this.style.background='none'">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="padding: 3rem; text-align: center;">
                                <div style="font-size: 3rem; margin-bottom: 1rem; color: var(--text-muted); opacity: 0.5;">💸</div>
                                <h4 style="font-weight: 700; color: var(--text-main);">Belum ada pengeluaran</h4>
                                <p style="color: var(--text-muted);">Tidak ada catatan pengeluaran di bulan ini.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--card-border); display: flex; justify-content: space-between; align-items: center;">
                <span style="font-weight: 600; color: var(--text-muted);">Total Pengeluaran Bulan Ini:</span>
                <span style="font-size: 1.5rem; font-weight: 800; color: #E74C3C;">Rp {{ number_format($totalExpense, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Form Tambah -->
    <div>
        <div class="card" style="position: sticky; top: 2rem;">
            <div style="width: 48px; height: 48px; background: rgba(231, 76, 60, 0.1); color: #E74C3C; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1.5rem;">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
            <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--text-main); margin-bottom: 1.5rem;">Catat Pengeluaran</h2>
            
            <form action="{{ route('expenses.store') }}" method="POST">
                @csrf
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-main);">Tanggal</label>
                    <input type="date" name="date" class="form-control" required value="{{ date('Y-m-d') }}" style="width: 100%; padding: 0.75rem; border-radius: 10px;">
                </div>
                
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-main);">Nominal (Rp)</label>
                    <input type="number" name="amount" class="form-control" required min="1" placeholder="Contoh: 50000" style="width: 100%; padding: 0.75rem; border-radius: 10px;">
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-main);">Keterangan / Keperluan</label>
                    <textarea name="description" class="form-control" required rows="3" placeholder="Contoh: Menjenguk Pak Budi sakit" style="width: 100%; padding: 0.75rem; border-radius: 10px; resize: none;"></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 0.8rem; background: #E74C3C; border-color: #E74C3C;">
                    <i class="fas fa-save"></i> Simpan Pengeluaran
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
