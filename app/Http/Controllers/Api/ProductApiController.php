<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function index()
    {
        try {
            $products = Product::with('category')->get();

            return response()->json([
                'message' => 'Data produk berhasil diambil',
                'data' => $products,
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data produk', [
                'message' => $e->getMessage(),
            ]);

            return response()->json(['message' => 'Terjadi kesalahan server'], 500);
        }
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['user_id'] = Auth::id();

            $product = Product::create($validated);

            Log::info('Menambah data produk', ['list' => $product]);

            return response()->json([
                'message' => 'Produk berhasil ditambahkan!!',
                'data' => $product,
            ], 201);
        } catch (\Throwable $e) {
            Log::error('Error saat menambah product', [
                'message' => $e->getMessage(),
            ]);

            return response()->json(['message' => 'Terjadi kesalahan server'], 500);
        }
    }

    public function show(int $id)
    {
        try {
            $product = Product::with('category')->find($id);

            if (!$product) {
                return response()->json([
                    'message' => 'Product tidak ditemukan',
                ], 404);
            }

            return response()->json([
                'message' => 'Product retrieved successfully',
                'data' => $product,
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data produk', [
                'message' => $e->getMessage(),
            ]);

            return response()->json(['message' => 'Terjadi kesalahan server'], 500);
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'message' => 'Product tidak ditemukan',
                ], 404);
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|integer|exists:category,id',
                'quantity' => 'required|integer',
                'price' => 'required|numeric',
            ]);

            $product->update($validated);

            Log::info('Update data produk', ['data' => $product]);

            return response()->json([
                'message' => 'Produk berhasil diupdate',
                'data' => $product,
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Error saat update product', [
                'message' => $e->getMessage(),
            ]);

            return response()->json(['message' => 'Terjadi kesalahan server'], 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'message' => 'Product tidak ditemukan',
                ], 404);
            }

            $product->delete();

            Log::info('Hapus data produk', ['id' => $id]);

            return response()->json([
                'message' => 'Produk berhasil dihapus',
            ], 204);
        } catch (\Throwable $e) {
            Log::error('Error saat hapus product', [
                'message' => $e->getMessage(),
            ]);

            return response()->json(['message' => 'Terjadi kesalahan server'], 500);
        }
    }
}