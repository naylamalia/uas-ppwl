<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductController extends Controller
{
    // Tampilkan semua produk
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

        // Ambil produk yang sudah difilter dan urutkan terbaru
        $products = $query->latest()->paginate(10)->withQueryString();
        $categories = Product::CATEGORIES;

        return view('admin.products.index', compact('products', 'categories'));
    }

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

    // Simpan produk baru
    public function store(StoreProductRequest $request)
    {
    $data = $request->validated();

    // Buat kode produk otomatis
    $data['code'] = 'PRD-' . strtoupper(Str::random(6));

    // Simpan gambar jika ada
    if ($request->hasFile('image') && $request->file('image')->isValid()) {
        $data['image'] = $request->file('image')->store('products', 'public');
    }

    // Pastikan tidak ada key image jika kosong/null
    if (empty($data['image'] ?? null)) {
        unset($data['image']);
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

    // Update data produk
    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $data = $request->validated();

        // Ganti gambar jika ada gambar baru
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diupdate.');
    }

    // Hapus produk
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus gambar jika ada
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
