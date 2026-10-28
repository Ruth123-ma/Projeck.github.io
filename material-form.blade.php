<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $material->exists ? 'Edit Material' : 'Tambah Material' }} - Stock Gudang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="min-h-screen bg-slate-100 font-sans text-slate-800">
    <div class="flex min-h-screen flex-col md:flex-row">
        @include('components.sidebar')

        <main class="min-w-0 flex-1">
            <header class="border-b border-slate-200 bg-white px-4 py-5 md:px-8">
                <h1 class="text-2xl font-black">{{ $material->exists ? 'Edit Material' : 'Tambah Material' }}</h1>
                <p class="mt-1 text-sm text-slate-500">Kelola informasi master dan batas minimum persediaan.</p>
            </header>

            <div class="mx-auto max-w-3xl space-y-5 p-4 md:p-8">
                @if ($errors->any())
                    <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700" role="alert">
                        <p class="font-bold">Periksa kembali data yang dimasukkan.</p>
                        <ul class="mt-2 list-inside list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST"
                    action="{{ $material->exists ? route('material.update', $material) : route('material.store') }}"
                    class="space-y-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm md:p-7">
                    @csrf
                    @if ($material->exists)
                        @method('PUT')
                    @endif

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="kode_barang" class="mb-1.5 block text-sm font-semibold">Kode barang</label>
                            <input id="kode_barang" name="kode_barang" value="{{ old('kode_barang', $material->kode_barang) }}" maxlength="50" required
                                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            @error('kode_barang')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="satuan" class="mb-1.5 block text-sm font-semibold">Satuan</label>
                            <input id="satuan" name="satuan" value="{{ old('satuan', $material->satuan) }}" maxlength="20" placeholder="Contoh: KG, L, PCS" required
                                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            @error('satuan')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="nama_material" class="mb-1.5 block text-sm font-semibold">Nama material</label>
                            <input id="nama_material" name="nama_material" value="{{ old('nama_material', $material->nama_material) }}" maxlength="255" required
                                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            @error('nama_material')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="min_stok" class="mb-1.5 block text-sm font-semibold">Batas minimum stok</label>
                            <input id="min_stok" name="min_stok" type="number" min="0" step="0.01" value="{{ old('min_stok', $material->min_stok ?? 10) }}" required
                                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            @error('min_stok')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>

                        @if ($material->exists)
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold">Stok saat ini</label>
                                <div class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm font-bold">
                                    {{ number_format((float) $material->stok_akhir, 2) }} {{ $material->satuan }}
                                </div>
                                <p class="mt-1 text-xs text-slate-500">Perubahan stok dicatat melalui menu Input atau Output.</p>
                            </div>
                        @else
                            <div>
                                <label for="stok_awal" class="mb-1.5 block text-sm font-semibold">Stok awal</label>
                                <input id="stok_awal" name="stok_awal" type="number" min="0" step="0.01" value="{{ old('stok_awal', '0') }}" required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                @error('stok_awal')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                        <a href="{{ route('daftar-stok') }}" class="rounded-lg border border-slate-300 px-5 py-2.5 text-center text-sm font-bold text-slate-700 transition hover:bg-slate-50">Batal</a>
                        <button type="submit" class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-blue-700">
                            <i class="fa-solid fa-floppy-disk mr-2"></i>Simpan Material
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
