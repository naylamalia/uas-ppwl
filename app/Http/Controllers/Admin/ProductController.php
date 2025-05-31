<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductController extends Controller
{
    // Tampilkan semua produk dengan filter dan pagination
    public function index(Request $request)
    {
        $query = Product::query();

        // Pencarian berdasarkan nama produk
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter berdasarkan rentang harga
        if ($request->filled('price')) {
            switch ($request->price) {
                case '1':
                    $query->whereBetween('price', [1000000, 5000000]);
                    break;
                case '2':
                    $query->whereBetween('price', [6000000, 10000000]);
                    break;
                case '3':
                    $query->whereBetween('price', [11000000, 15000000]);
                    break;
                case '4':
                    $query->where('price', '>', 15000000);
                    break;
            }
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        $categories = Product::CATEGORIES;

        return view('admin.products.index', compact('products', 'categories'));
    }

    // Export data produk ke PDF
    public function exportPdf()
    {
        $products = Product::latest()->get();
        $pdf = Pdf::loadView('admin.products.report', compact('products'));
        return $pdf->download('laporan-produk.pdf');
    }

    // Tampilkan form tambah produk
    public function create()
    {
        $categories = Product::CATEGORIES;
        return view('admin.products.create', compact('categories'));
    }

    // Simpan produk baru dengan validasi manual dan upload gambar
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:' . implode(',', Product::CATEGORIES),
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0', // tambahkan validasi stock
            'description' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only(['name', 'category', 'price', 'stock', 'description']); // tambahkan 'stock'

        // Buat kode produk otomatis
        $data['code'] = 'PRD-' . strtoupper(Str::random(6));

        // Upload gambar jika ada
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    // Tampilkan detail produk
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    // Tampilkan form edit produk
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Product::CATEGORIES;
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Update produk dengan validasi manual dan upload gambar baru
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:' . implode(',', Product::CATEGORIES),
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0', // tambahkan validasi stock
            'description' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only(['name', 'category', 'price', 'stock', 'description']); // tambahkan 'stock'

        // Upload gambar baru dan hapus gambar lama jika ada
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($product->image) {
                \Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    // Hapus produk dan file gambarnya jika ada
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    //function stock
    public function stock()
    {
    $products = Product::orderBy('name')->paginate(10);
    return view('admin.stock.index', compact('products'));
    }

    public function addStock(Request $request, $id)
    {
    $request->validate([
        'jumlah_stok' => 'required|integer|min:1',
    ]);
    $product = Product::findOrFail($id);
    $product->increment('stock', $request->jumlah_stok);

    return back()->with('success', 'Stok produk berhasil ditambah.');
    }

    // Tampilkan form tambah stok untuk produk tertentu
    public function showAddStockForm($id)
    {
    $product = Product::findOrFail($id);
    return view('admin.stock.add', compact('product'));
    }

}