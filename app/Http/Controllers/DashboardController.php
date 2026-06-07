<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;  // ← TAMBAHKAN INI!

class DashboardController extends Controller
{
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        $customerId = $customer->id_customer;

        // Ambil semua pesanan customer
        $orders = DB::table('catering_pesanan')
            ->where('id_customer', $customerId)
            ->orderBy('tanggal_pesan', 'desc')
            ->get();

        // Hitung statistik
        $totalOrders = $orders->count();
        $processingOrders = DB::table('catering_pesanan')
            ->where('id_customer', $customerId)
            ->whereIn('status_pesanan', ['pending', 'proses'])
            ->count();
        $shippedOrders = DB::table('catering_pesanan')
            ->where('id_customer', $customerId)
            ->where('status_pesanan', 'dikirim')
            ->count();
        $completedOrders = DB::table('catering_pesanan')
            ->where('id_customer', $customerId)
            ->where('status_pesanan', 'selesai')
            ->count();

        return view('customer.dashboard', compact('customer', 'orders', 'totalOrders', 'processingOrders', 'shippedOrders', 'completedOrders'));
    }

    /**
     * Menampilkan detail pesanan customer
     */
    public function orderDetail($id)
    {
        $customerId = Auth::guard('customer')->user()->id_customer;

        // Ambil data pesanan
        $order = DB::table('catering_pesanan')
            ->where('id_pesanan', $id)
            ->where('id_customer', $customerId)
            ->first();

        if (!$order) {
            abort(404, 'Pesanan tidak ditemukan');
        }

        // Ambil detail item pesanan
        $orderItems = DB::table('detail_pesanan')
            ->leftJoin('catering_menu', 'detail_pesanan.id_menu', '=', 'catering_menu.id_menu')
            ->where('detail_pesanan.id_pesanan', $id)
            ->select('detail_pesanan.*', 'catering_menu.nama_menu', 'catering_menu.kategori')
            ->get();

        // Ambil riwayat tracking
        $tracking = DB::table('tracking_pesanan')
            ->where('id_pesanan', $id)
            ->orderBy('waktu', 'desc')  // Biar yang terbaru di atas
            ->get();

        return view('customer.order-detail', compact('order', 'orderItems', 'tracking'));
    }

    /**
     * Menampilkan profil customer
     */
    public function profile()
    {
        $customer = Auth::guard('customer')->user();
        return view('customer.profile', compact('customer'));
    }

    /**
     * Menampilkan semua pesanan customer
     */
    public function orders()
    {
        $customerId = Auth::guard('customer')->user()->id_customer;
        $orders = DB::table('catering_pesanan')
            ->where('id_customer', $customerId)
            ->orderBy('tanggal_pesan', 'desc')
            ->get();

        return view('customer.orders', compact('orders'));
    }

    /**
     * Update profil customer
     */
    public function updateProfile(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'nama' => 'required|string|max:100',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:500',
            'password' => 'nullable|min:6|confirmed'
        ]);

        $updateData = [
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        DB::table('customer')
            ->where('id_customer', $customer->id_customer)
            ->update($updateData);

        return redirect()->route('profile')->with('success', 'Profil berhasil diupdate!');
    }
}
