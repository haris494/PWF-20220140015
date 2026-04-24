<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Products') }}
            </h2>
            <div class="flex items-center gap-3">
                @can('manage-product')
                <x-add-product :url="route('product.create')" name="Product" />
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 px-4 py-3 bg-green-50 dark:bg-green-900/20 rounded-xl text-sm text-green-700 dark:text-green-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse table-fixed">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center w-12">#</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center w-1/4">Name</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center w-1/5">Quantity</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center w-1/5">Price</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center w-1/5">Owner</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center w-1/5">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($products as $product)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 text-center align-middle">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 text-center align-middle">
                                    <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $product->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center align-middle">
                                    <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $product->quantity > 0
                                            ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400'
                                            : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' }}">
                                        {{ $product->quantity }} {{ $product->quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-700 dark:text-gray-300 text-center align-middle">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 text-center align-middle">
                                    {{ $product->user->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-center align-middle">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('product.show', $product->id) }}" class="text-blue-500 hover:text-blue-700 dark:hover:text-blue-400 transition" title="View">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        @can('update', $product)
                                        <x-edit-button :url="route('product.edit', $product)" />
                                        @endcan
                                        @can('delete', $product)
                                        <x-delete-button :url="route('product.delete', $product->id)" />
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center align-middle">
                                    <div class="flex flex-col items-center">
                                        <p class="text-gray-500 dark:text-gray-400 font-medium">No products available yet.</p>
                                        <p class="text-sm text-gray-400 dark:text-gray-500">Start by adding your first product.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>