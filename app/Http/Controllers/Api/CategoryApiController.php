<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryApiController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::all();

            return response()->json([
                'message' => 'Data category berhasil diambil',
                'data' => $categories,
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data category', [
                'message' => $e->getMessage(),
            ]);

            return response()->json(['message' => 'Terjadi kesalahan server'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $category = Category::create($validated);

            Log::info('Menambah data category', ['data' => $category]);

            return response()->json([
                'message' => 'Category berhasil ditambahkan',
                'data' => $category,
            ], 201);
        } catch (\Throwable $e) {
            Log::error('Error saat menambah category', [
                'message' => $e->getMessage(),
            ]);

            return response()->json(['message' => 'Terjadi kesalahan server'], 500);
        }
    }

    public function show(int $id)
    {
        try {
            $category = Category::find($id);

            if (!$category) {
                return response()->json([
                    'message' => 'Category tidak ditemukan',
                ], 404);
            }

            return response()->json([
                'message' => 'Category berhasil diambil',
                'data' => $category,
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data category', [
                'message' => $e->getMessage(),
            ]);

            return response()->json(['message' => 'Terjadi kesalahan server'], 500);
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            $category = Category::find($id);

            if (!$category) {
                return response()->json([
                    'message' => 'Category tidak ditemukan',
                ], 404);
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $category->update($validated);

            Log::info('Update data category', ['data' => $category]);

            return response()->json([
                'message' => 'Category berhasil diupdate',
                'data' => $category,
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Error saat update category', [
                'message' => $e->getMessage(),
            ]);

            return response()->json(['message' => 'Terjadi kesalahan server'], 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $category = Category::find($id);

            if (!$category) {
                return response()->json([
                    'message' => 'Category tidak ditemukan',
                ], 404);
            }

            $category->delete();

            Log::info('Hapus data category', ['id' => $id]);

            return response()->json([
                'message' => 'Category berhasil dihapus',
            ], 204);
        } catch (\Throwable $e) {
            Log::error('Error saat hapus category', [
                'message' => $e->getMessage(),
            ]);

            return response()->json(['message' => 'Terjadi kesalahan server'], 500);
        }
    }
}