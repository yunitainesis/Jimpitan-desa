<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class HouseController extends Controller
{
    public function index(Request $request)
    {
        $week = now()->weekOfYear;
        $year = now()->year;

        $query = House::withCount(['payments as paid_this_week' => function ($q) use ($week, $year) {
            $q->where('week_number', $week)->where('year', $year);
        }]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('house_number', 'like', "%{$search}%")
                  ->orWhere('owner_name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'paid') {
                $query->whereHas('payments', fn($q) => $q->where('week_number', $week)->where('year', $year));
            } elseif ($request->status === 'unpaid') {
                $query->whereDoesntHave('payments', fn($q) => $q->where('week_number', $week)->where('year', $year));
            }
        }

        $houses = $query->orderBy('house_number')->paginate(15)->withQueryString();

        return view('houses.index', compact('houses', 'week', 'year'));
    }

    public function create()
    {
        return view('houses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'house_number' => 'required|string|unique:houses',
            'owner_name'   => 'required|string|max:100',
            'address'      => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $validated['qr_token'] = Str::uuid()->toString();

        House::create($validated);

        return redirect()->route('houses.index')
            ->with('success', 'Rumah berhasil ditambahkan!');
    }

    public function show(House $house)
    {
        $week = now()->weekOfYear;
        $year = now()->year;

        $paymentHistory = $house->payments()
            ->with('recorder')
            ->orderByDesc('year')
            ->orderByDesc('week_number')
            ->paginate(12);

        return view('houses.show', compact('house', 'paymentHistory', 'week', 'year'));
    }

    public function edit(House $house)
    {
        return view('houses.edit', compact('house'));
    }

    public function update(Request $request, House $house)
    {
        $validated = $request->validate([
            'house_number' => 'required|string|unique:houses,house_number,' . $house->id,
            'owner_name'   => 'required|string|max:100',
            'address'      => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'is_active'    => 'boolean',
        ]);

        $house->update($validated);

        return redirect()->route('houses.index')
            ->with('success', 'Data rumah berhasil diperbarui!');
    }

    public function destroy(House $house)
    {
        $house->delete();
        return redirect()->route('houses.index')
            ->with('success', 'Data rumah berhasil dihapus!');
    }

    public function printQr(House $house)
    {
        return view('houses.print-qr', compact('house'));
    }

    public function regenerateQr(House $house)
    {
        $house->update(['qr_token' => Str::uuid()->toString()]);
        return back()->with('success', 'QR Code berhasil di-regenerasi!');
    }

    public function downloadQr(House $house)
    {
        // Get JPG QR Code from external API since simple-qrcode requires Imagick for image generation
        $url = 'https://api.qrserver.com/v1/create-qr-code/?size=500x500&format=jpeg&data=' . urlencode($house->qr_token);
        $image = file_get_contents($url);
        
        $fileName = 'QR_' . preg_replace('/[^A-Za-z0-9\-]/', '_', $house->house_number) . '.jpg';

        return response()->streamDownload(function () use ($image) {
            echo $image;
        }, $fileName, [
            'Content-Type' => 'image/jpeg',
        ]);
    }
}
