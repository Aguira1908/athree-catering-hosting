<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Menampilkan halaman keranjang
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['subtotal'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * Menampilkan form checkout
     */
    public function checkoutForm()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Keranjang belanja kosong');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['subtotal'];
        }

        return view('cart.checkout', compact('cart', 'total'));
    }

    /**
     * Proses checkout (menyimpan pesanan ke database) - VERSI LENGKAP DENGAN PEMBAYARAN
     */
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Keranjang belanja kosong');
        }

        $request->validate([
            'alamat_kirim' => 'required|string',
            'tanggal_kirim' => 'required|date',
            'catatan' => 'nullable|string',
            'metode_bayar' => 'required|in:transfer,qris'
        ]);

        DB::beginTransaction();

        try {
            // Hitung total
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['subtotal'];
            }

            // Ambil ID pesanan baru
            $maxId = DB::table('catering_pesanan')->max('id_pesanan');
            $id_pesanan = ($maxId ?? 0) + 1;

            // Insert pesanan
            DB::table('catering_pesanan')->insert([
                'id_pesanan' => $id_pesanan,
                'id_customer' => Auth::guard('customer')->user()->id_customer,
                'tanggal_pesan' => now(),
                'tanggal_kirim' => $request->tanggal_kirim,
                'alamat_kirim' => $request->alamat_kirim,
                'total_harga' => $total,
                'status_pesanan' => 'pending',
                'status_bayar' => 'pending',
                'catatan' => $request->catatan
            ]);

            // Insert detail pesanan
            foreach ($cart as $item) {
                DB::table('detail_pesanan')->insert([
                    'id_pesanan' => $id_pesanan,
                    'id_menu' => $item['id_menu'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga'],
                    'subtotal' => $item['subtotal']
                ]);
            }

            // Insert tracking
            DB::table('tracking_pesanan')->insert([
                'id_pesanan' => $id_pesanan,
                'status' => 'pending',
                'deskripsi' => 'Pesanan dibuat, menunggu pembayaran via ' . ($request->metode_bayar == 'transfer' ? 'Transfer Bank' : 'QRIS'),
                'waktu' => now()
            ]);

            // Insert pembayaran
            DB::table('pembayaran')->insert([
                'id_pesanan' => $id_pesanan,
                'metode_pembayaran' => $request->metode_bayar,
                'jumlah_bayar' => $total,
                'status_verifikasi' => 'pending',
                'tanggal_bayar' => null
            ]);

            DB::commit();

            // Hapus keranjang
            session()->forget('cart');

            // Redirect ke halaman detail dengan pesan sukses
            return redirect()->route('customer.order.detail', $id_pesanan)
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran dan konfirmasi via WhatsApp.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Menambahkan item ke keranjang (via AJAX)
     */
    public function add(Request $request)
    {
        $request->validate([
            'id_menu' => 'required|integer',
            'jumlah' => 'required|integer|min:1'
        ]);

        $menu = DB::table('catering_menu')->where('id_menu', $request->id_menu)->first();

        if (!$menu) {
            return response()->json(['error' => 'Menu tidak ditemukan'], 404);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$request->id_menu])) {
            $cart[$request->id_menu]['jumlah'] += $request->jumlah;
            $cart[$request->id_menu]['subtotal'] = $cart[$request->id_menu]['jumlah'] * $menu->harga;
        } else {
            $cart[$request->id_menu] = [
                'id_menu' => $menu->id_menu,
                'nama_menu' => $menu->nama_menu,
                'kategori' => $menu->kategori,
                'harga' => $menu->harga,
                'jumlah' => $request->jumlah,
                'subtotal' => $request->jumlah * $menu->harga,
                'foto' => $menu->foto ?? null
            ];
        }

        session()->put('cart', $cart);

        $totalItems = 0;
        foreach ($cart as $item) {
            $totalItems += $item['jumlah'];
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil ditambahkan ke keranjang!',
                'cart_count' => $totalItems
            ]);
        }

        return redirect()->route('cart')->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }

    /**
     * Menambahkan item ke keranjang (via form biasa)
     */
    public function directAdd(Request $request)
    {
        $request->validate([
            'id_menu' => 'required|integer',
            'jumlah' => 'required|integer|min:1'
        ]);

        $menu = DB::table('catering_menu')->where('id_menu', $request->id_menu)->first();

        if (!$menu) {
            return redirect()->back()->with('error', 'Menu tidak ditemukan');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$request->id_menu])) {
            $cart[$request->id_menu]['jumlah'] += $request->jumlah;
            $cart[$request->id_menu]['subtotal'] = $cart[$request->id_menu]['jumlah'] * $menu->harga;
        } else {
            $cart[$request->id_menu] = [
                'id_menu' => $menu->id_menu,
                'nama_menu' => $menu->nama_menu,
                'kategori' => $menu->kategori,
                'harga' => $menu->harga,
                'jumlah' => $request->jumlah,
                'subtotal' => $request->jumlah * $menu->harga,
                'foto' => $menu->foto ?? null
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart')->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }

    /**
     * Menghapus item dari keranjang
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart')->with('success', 'Item dihapus dari keranjang');
    }

    /**
     * Update jumlah item di keranjang
     */
    public function update(Request $request)
    {
        $request->validate([
            'id_menu' => 'required|integer',
            'jumlah' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->id_menu])) {
            $cart[$request->id_menu]['jumlah'] = $request->jumlah;
            $cart[$request->id_menu]['subtotal'] = $cart[$request->id_menu]['harga'] * $request->jumlah;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart')->with('success', 'Keranjang berhasil diupdate');
    }

    /**
     * Kosongkan keranjang
     */
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart')->with('success', 'Keranjang berhasil dikosongkan');
    }

    /**
     * Mendapatkan jumlah item di keranjang (untuk AJAX)
     */
    public function count()
    {
        $cart = session()->get('cart', []);
        $count = 0;

        foreach ($cart as $item) {
            $count += $item['jumlah'];
        }

        return response()->json(['count' => $count]);
    }
}
