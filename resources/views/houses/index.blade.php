@extends('layouts.app')

@section('title', 'Data Rumah')
@section('subtitle', 'Kelola data rumah warga dan QR code jimpitan')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <form action="{{ route('houses.index') }}" method="GET" style="display: flex; gap: 10px; flex: 1; max-width: 500px;">
            <input type="text" name="search" class="form-control" placeholder="Cari nomor rumah, nama..." value="{{ request('search') }}" style="padding: 0.6rem 1rem; border-radius: 10px; border: 1px solid var(--primary-light); width: 100%;">
            <button type="submit" class="btn btn-secondary">Cari</button>
        </form>
        <a href="{{ route('houses.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Rumah
        </a>
    </div>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; border-bottom: 1px solid var(--primary-light);">
                <th style="padding: 1rem;">No. Rumah</th>
                <th style="padding: 1rem;">Pemilik</th>
                <th style="padding: 1rem;">WA</th>
                <th style="padding: 1rem;">Status Minggu Ini</th>
                <th style="padding: 1rem; text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($houses as $house)
            <tr style="border-bottom: 1px solid var(--primary-very-light);">
                <td style="padding: 1rem; font-weight: 700;">{{ $house->house_number }}</td>
                <td style="padding: 1rem;">{{ $house->owner_name }}</td>
                <td style="padding: 1rem;">{{ $house->phone_number ?? '-' }}</td>
                <td style="padding: 1rem;">
                    @if($house->paid_this_week)
                        <span class="badge badge-success">Sudah Bayar</span>
                    @else
                        <span class="badge badge-danger">Belum Bayar</span>
                    @endif
                </td>
                <td style="padding: 1rem; text-align: right;">
                    <div style="display: flex; gap: 8px; justify-content: flex-end;">
                        <a href="{{ route('houses.print-qr', $house->id) }}" class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;" title="Print QR Code">
                            <i class="fas fa-print"></i>
                        </a>
                        <a href="{{ route('houses.download-qr', $house->id) }}" class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;" title="Save QR Code">
                            <i class="fas fa-download"></i>
                        </a>
                        <a href="{{ route('houses.show', $house->id) }}" class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('houses.edit', $house->id) }}" class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 1.5rem;">
        {{ $houses->links() }}
    </div>
</div>
@endsection
