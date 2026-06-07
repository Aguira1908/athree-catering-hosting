<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalOrders = DB::table('catering_pesanan')->count();
        $totalCustomers = DB::table('customer')->count();
        $totalMenus = DB::table('catering_menu')->count();
        $pendingOrders = DB::table('catering_pesanan')->where('status_pesanan', 'pending')->count();

        $recentOrders = DB::table('catering_pesanan')
            ->leftJoin('customer', 'catering_pesanan.id_customer', '=', 'customer.id_customer')
            ->select('catering_pesanan.*', 'customer.nama as customer_name')
            ->orderBy('catering_pesanan.id_pesanan', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('totalOrders', 'totalCustomers', 'totalMenus', 'pendingOrders', 'recentOrders'));
    }

    public function orders()
    {
        $orders = DB::table('catering_pesanan')
            ->leftJoin('customer', 'catering_pesanan.id_customer', '=', 'customer.id_customer')
            ->select('catering_pesanan.*', 'customer.nama as customer_name')
            ->orderBy('catering_pesanan.id_pesanan', 'desc')
            ->get();

        return view('admin.orders', compact('orders'));
    }

    public function orderDetail($id)
    {
        $order = DB::table('catering_pesanan')
            ->leftJoin('customer', 'catering_pesanan.id_customer', '=', 'customer.id_customer')
            ->where('catering_pesanan.id_pesanan', $id)
            ->select('catering_pesanan.*', 'customer.nama as customer_name', 'customer.email', 'customer.no_hp')
            ->first();

        if (!$order) {
            abort(404, 'Pesanan tidak ditemukan');
        }

        $orderItems = DB::table('detail_pesanan')
            ->leftJoin('catering_menu', 'detail_pesanan.id_menu', '=', 'catering_menu.id_menu')
            ->where('detail_pesanan.id_pesanan', $id)
            ->select('detail_pesanan.*', 'catering_menu.nama_menu')
            ->get();

        $tracking = DB::table('tracking_pesanan')
            ->where('id_pesanan', $id)
            ->orderBy('waktu', 'asc')
            ->get();

        return view('admin.order-detail', compact('order', 'orderItems', 'tracking'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pesanan' => 'required|in:pending,proses,siap_kirim,dikirim,selesai,batal',
            'catatan' => 'nullable|string'
        ]);

        $oldStatus = DB::table('catering_pesanan')->where('id_pesanan', $id)->value('status_pesanan');

        DB::table('catering_pesanan')
            ->where('id_pesanan', $id)
            ->update(['status_pesanan' => $request->status_pesanan]);

        $statusLabels = [
            'pending' => 'Menunggu Verifikasi',
            'proses' => 'Sedang Diproses',
            'siap_kirim' => 'Siap Diambil/Dikirim',
            'dikirim' => 'Sedang Dikirim',
            'selesai' => 'Pesanan Selesai',
            'batal' => 'Pesanan Dibatalkan'
        ];

        $deskripsi = 'Status pesanan berubah dari "' . ($statusLabels[$oldStatus] ?? $oldStatus) . '" menjadi "' . ($statusLabels[$request->status_pesanan] ?? $request->status_pesanan) . '"';

        if ($request->catatan) {
            $deskripsi .= '. Catatan: ' . $request->catatan;
        }

        DB::table('tracking_pesanan')->insert([
            'id_pesanan' => $id,
            'status' => $request->status_pesanan,
            'deskripsi' => $deskripsi,
            'waktu' => now()
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diupdate');
    }

    public function verifyPayment(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected'
        ]);

        $payment = DB::table('pembayaran')->where('id_pembayaran', $id)->first();

        if (!$payment) {
            return redirect()->back()->with('error', 'Pembayaran tidak ditemukan');
        }

        DB::table('pembayaran')
            ->where('id_pembayaran', $id)
            ->update([
                'status_verifikasi' => $request->status,
                'tanggal_bayar' => $request->status == 'verified' ? now() : null
            ]);

        $statusBayar = $request->status == 'verified' ? 'lunas' : 'gagal';
        DB::table('catering_pesanan')
            ->where('id_pesanan', $payment->id_pesanan)
            ->update(['status_bayar' => $statusBayar]);

        $deskripsi = $request->status == 'verified'
            ? 'Pembayaran telah diverifikasi. Pesanan akan segera diproses.'
            : 'Pembayaran ditolak. Silakan upload ulang bukti bayar.';

        DB::table('tracking_pesanan')->insert([
            'id_pesanan' => $payment->id_pesanan,
            'status' => $request->status == 'verified' ? 'proses' : 'pending',
            'deskripsi' => $deskripsi,
            'waktu' => now()
        ]);

        if ($request->status == 'verified') {
            DB::table('catering_pesanan')
                ->where('id_pesanan', $payment->id_pesanan)
                ->update(['status_pesanan' => 'proses']);
        }

        return redirect()->back()->with('success', 'Status pembayaran berhasil diupdate');
    }

    public function manageMenu()
    {
        $menus = DB::table('catering_menu')->get();
        return view('admin.menu', compact('menus'));
    }

    public function customers()
    {
        $customers = DB::table('customer')->orderBy('id_customer', 'desc')->get();
        return view('admin.customers', compact('customers'));
    }

    public function payments()
    {
        $payments = DB::table('pembayaran')
            ->leftJoin('catering_pesanan', 'pembayaran.id_pesanan', '=', 'catering_pesanan.id_pesanan')
            ->leftJoin('customer', 'catering_pesanan.id_customer', '=', 'customer.id_customer')
            ->select('pembayaran.*', 'catering_pesanan.total_harga', 'customer.nama as customer_name')
            ->orderBy('pembayaran.id_pembayaran', 'desc')
            ->get();

        return view('admin.payments', compact('payments'));
    }

    public function reports()
    {
        $monthlyOrders = DB::table('catering_pesanan')
            ->selectRaw("TO_CHAR(tanggal_pesan, 'YYYY-MM') as month, COUNT(*) as total, SUM(total_harga) as revenue")
            ->groupByRaw("TO_CHAR(tanggal_pesan, 'YYYY-MM')")
            ->orderBy('month', 'desc')
            ->get();

        return view('admin.reports', compact('monthlyOrders'));
    }

    public function createMenu()
    {
        return view('admin.menu-create');
    }

    public function storeMenu(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:200',
            'kategori' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'stok' => 'nullable|integer|min:0',
            'status' => 'nullable|string',
        ]);

        $data = [
            'nama_menu' => $request->nama_menu,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'stok' => $request->stok ?? 0,
            'status' => $request->status ?? 'aktif'
        ];

        DB::table('catering_menu')->insert($data);

        return redirect()->route('admin.menu.manage')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function editMenu($id)
    {
        $menu = DB::table('catering_menu')->where('id_menu', $id)->first();

        if (!$menu) {
            return redirect()->route('admin.menu.manage')->with('error', 'Menu tidak ditemukan');
        }

        return view('admin.menu-edit', compact('menu'));
    }

    public function updateMenu(Request $request, $id)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:200',
            'kategori' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'stok' => 'nullable|integer|min:0',
            'status' => 'nullable|string',
        ]);

        $updateData = [
            'nama_menu' => $request->nama_menu,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'stok' => $request->stok ?? 0,
            'status' => $request->status ?? 'aktif'
        ];

        DB::table('catering_menu')->where('id_menu', $id)->update($updateData);

        return redirect()->route('admin.menu.manage')->with('success', 'Menu berhasil diupdate!');
    }

    public function destroyMenu($id)
    {
        $usedInOrders = DB::table('detail_pesanan')->where('id_menu', $id)->exists();

        if ($usedInOrders) {
            return redirect()->back()->with('error', 'Menu tidak bisa dihapus karena sudah pernah dipesan!');
        }

        DB::table('catering_menu')->where('id_menu', $id)->delete();

        return redirect()->route('admin.menu.manage')->with('success', 'Menu berhasil dihapus!');
    }
}
