<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    /**
     * Menampilkan daftar semua menu
     */
    public function index()
    {
        // Ambil semua data dari tabel catering_menu
        $menus = DB::table('catering_menu')->get();

        // Kirim data ke view
        return view('menu.index', compact('menus'));
    }

    /**
     * Menampilkan detail satu menu
     */
    public function show($id)
    {
        // Ambil data menu berdasarkan ID
        $menu = DB::table('catering_menu')->where('id_menu', $id)->first();

        // Jika menu tidak ditemukan, kembali ke halaman sebelumnya
        if (!$menu) {
            return redirect()->back()->with('error', 'Menu tidak ditemukan');
        }

        return view('menu.show', compact('menu'));
    }

    /**
     * Filter menu berdasarkan kategori
     */
    public function filter(Request $request)
    {
        $kategori = $request->get('kategori');

        if ($kategori && $kategori != 'all') {
            $menus = DB::table('catering_menu')
                       ->where('kategori', $kategori)
                       ->get();
        } else {
            $menus = DB::table('catering_menu')->get();
        }

        if ($request->ajax()) {
            return view('menu.partials.menu_list', compact('menus'))->render();
        }

        return view('menu.index', compact('menus'));
    }
}
