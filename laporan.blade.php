<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ringkasan Laporan - Stock Gudang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="min-h-screen bg-slate-100 font-sans text-slate-800">
    <div class="flex min-h-screen flex-col md:flex-row">
        @include('components.sidebar')

        <main class="min-w-0 flex-1">
            <header class="border-b border-slate-200 bg-white px-4 py-5 md:px-8">
                <h1 class="text-2xl font-black">Ringkasan Laporan Gudang</h1>
                <p class="mt-1 text-sm text-slate-500">Gambaran saldo persediaan dan kondisi stok seluruh material.</p>
            </header>

            <div class="mx-auto max-w-7xl space-y-6 p-4 md:p-8">
                <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    @foreach ([
                        ['Total jenis material', $materials->count(), 'fa-boxes-stacked', 'blue'],
                        ['Total saldo stok', number_format((float) $totalStok, 2), 'fa-box', 'indigo'],
                        ['Stok rendah/kritis', $stokKritis, 'fa-triangle-exclamation', 'rose'],
                        ['Stok normal', $optimal, 'fa-circle-check', 'emerald'],
                    ] as [$label, $value, $icon, $color])
                        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">{{ $label }}</p>
                                    <p class="mt-2 text-3xl font-black">{{ $value }}</p>
                                </div>
                                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-{{ $color }}-50 text-{{ $color }}-600">
                                    <i class="fa-solid {{ $icon }} text-xl"></i>
                                </span>
                            </div>
                        </div>
                    @endforeach
                </section>

                <section class="flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="font-extrabold">Laporan terperinci</h2>
                        <p class="mt-1 text-sm text-slate-500">Buka riwayat transaksi atau saldo akhir per periode.</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('laporan-material') }}" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-blue-700">
                            <i class="fa-solid fa-arrow-right-arrow-left mr-1"></i>Transaksi material
                        </a>
                        <a href="{{ route('laporan-stok') }}" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50">
                            <i class="fa-solid fa-clipboard-list mr-1"></i>Saldo stok bulanan
                        </a>
                    </div>
                </section>

                <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 px-5 py-4">
                        <h2 class="font-extrabold">Ringkasan kondisi material</h2>
                        <p class="mt-1 text-xs text-slate-500">Status dihitung dari stok akhir dan batas minimum setiap material.</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                                <tr>
                                    <th class="px-4 py-3">Kode barang</th>
                                    <th class="px-4 py-3">Nama material</th>
                                    <th class="px-4 py-3 text-right">Stok akhir</th>
                                    <th class="px-4 py-3 text-right">Minimum</th>
                                    <th class="px-4 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($materials as $material)
                                    @php
                                        $statusColor = $material->status === 'KRITIS'
                                            ? 'rose'
                                            : ($material->status === 'RENDAH' ? 'amber' : 'emerald');
                                    @endphp
                                    <tr class="border-t border-slate-100">
                                        <td class="whitespace-nowrap px-4 py-3 font-mono text-xs font-bold">{{ $material->kode_barang }}</td>
                                        <td class="px-4 py-3 font-semibold">{{ $material->nama_material }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-right">{{ number_format((float) $material->stok_akhir, 2) }} {{ $material->satuan }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-right">{{ number_format((float) ($material->min_stok ?? 10), 2) }} {{ $material->satuan }}</td>
                                        <td class="px-4 py-3">
                                            <span class="rounded-full bg-{{ $statusColor }}-100 px-2.5 py-1 text-xs font-bold text-{{ $statusColor }}-700">{{ $material->status ?? 'NORMAL' }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-4 py-10 text-center text-slate-500">Belum ada material untuk dilaporkan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </main>
    </div>
</body>
</html>
