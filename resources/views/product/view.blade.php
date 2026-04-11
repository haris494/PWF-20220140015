<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('product.index') }}" class="text-gray-400 hover:text-gray-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Product Detail
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto px-6 space-y-4">

            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">

                {{-- Product Header --}}
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">ID #{{ $product->id }}</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                        {{ $product->quantity > 0 ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' }}">
                        {{ $product->quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                    </span>
                </div>

                {{-- Details --}}
                <dl class="divide-y divide-gray-100 dark:divide-gray-700">
                    <div class="flex items-center px-6 py-4 gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 w-32 shrink-0">Quantity</dt>
                        <dd>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $product->quantity > 10 ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400' }}">
                                {{ $product->quantity }} {{ $product->quantity > 10 ? '' : '(low stock)' }}
                            </span>
                        </dd>
                    </div>

                    <div class="flex items-center px-6 py-4 gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 w-32 shrink-0">Price</dt>
                        <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </dd>
                    </div>

                    <div class="flex items-center px-6 py-4 gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 w-32 shrink-0">Owner</dt>
                        <dd class="text-sm text-gray-700 dark:text-gray-300">
                            <div class="flex items-center gap-2">
                                <div class="h-7 w-7 rounded-full bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase">
                                    {{ substr($product->user->name ?? '?', 0, 1) }}
                                </div>
                                {{ $product->user->name ?? '-' }}
                            </div>
                        </dd>
                    </div>

                    <div class="flex items-center px-6 py-4 gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 w-32 shrink-0">Created At</dt>
                        <dd class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $product->created_at->format('d M Y, H:i') }}
                        </dd>
                    </div>

                    <div class="flex items-center px-6 py-4 gap-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 w-32 shrink-0">Updated At</dt>
                        <dd class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $product->updated_at->format('d M Y, H:i') }}
                        </dd>
                    </div>
                </dl>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3">
                @can('update', $product)
                <a href="{{ route('product.edit', $product) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg shadow-sm transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Product
                </a>
                @endcan
                @can('delete', $product)
                <form action="{{ route('product.delete', $product->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg shadow-sm transition"
                        onclick="return confirm('Are you sure you want to delete this product?')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                    </button>
                </form>
                @endcan
            </div>

        </div>
    </div>
</x-app-layout>
