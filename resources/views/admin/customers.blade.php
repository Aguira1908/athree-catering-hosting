@extends('layouts.main')

@section('title', 'Kelola Customer - Admin')

@section('content')
<section class="py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8">Data Customer</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left py-3 px-4">ID</th>
                            <th class="text-left py-3 px-4">Nama</th>
                            <th class="text-left py-3 px-4">Email</th>
                            <th class="text-left py-3 px-4">No. HP</th>
                            <th class="text-left py-3 px-4">Alamat</th>
                            <th class="text-left py-3 px-4">Terdaftar</th>
                            <th class="text-center py-3 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $customer->id_customer }}</td>
                            <td class="py-3 px-4 font-medium">{{ $customer->nama }}</td>
                            <td class="py-3 px-4">{{ $customer->email }}</td>
                            <td class="py-3 px-4">{{ $customer->no_hp ?? '-' }}</td>
                            <td class="py-3 px-4">{{ Str::limit($customer->alamat ?? '-', 50) }}</td>
                            <td class="py-3 px-4">{{ isset($customer->created_at) ? \Carbon\Carbon::parse($customer->created_at)->format('d/m/Y') : '-' }}</td>
                            <td class="py-3 px-4 text-center">
                                <a href="#" class="text-blue-600 hover:text-blue-800 mr-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="text-red-600 hover:text-red-800" onclick="return confirm('Yakin hapus customer ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-gray-500">Belum ada data customer</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
