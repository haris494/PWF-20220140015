<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('product.index', compact('products'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('product.create', compact('users'));
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();

        try {
            Product::create($validated);

            return redirect()
                ->route('product.index')
                ->with('success', 'Product created successfully.');

        } catch (QueryException $e) {
            Log::error('Product store database error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Database error while creating product.');

        } catch (\Throwable $e) {
            Log::error('Product store unexpected error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Unexpected error occurred.');
        }
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product.view', compact('product'));
    }

    public function edit(Product $product)
    {
        Gate::authorize('update', $product);

        $users = User::orderBy('name')->get();
        return view('product.edit', compact('product', 'users'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        Gate::authorize('update', $product);

        $validated = $request->validated();

        try {
            $product->update($validated);

            return redirect()
                ->route('product.index')
                ->with('success', 'Product updated successfully.');

        } catch (QueryException $e) {
            Log::error('Product update database error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Database error while updating product.');

        } catch (\Throwable $e) {
            Log::error('Product update unexpected error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Unexpected error occurred.');
        }
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        Gate::authorize('delete', $product);

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product berhasil dihapus.');
    }

    public function export()
    {
        // Placeholder untuk fitur export
        return redirect()->route('product.index')->with('success', 'Export feature coming soon.');
    }
}
