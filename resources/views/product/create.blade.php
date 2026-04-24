<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('product.index') }}" class="text-gray-400 hover:text-gray-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Add Product
            </h2>
        </div>
    </x-slot>

  <div class="py-12">
    <div class="max-w-lg mx-auto px-6">
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700">
            <div class="p-6">
                    <form action="{{ route('product.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Product Name <span class="text-red-600">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"  placeholder="e.g. MacBook Pro M3" 
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            @error('name')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

<!-- Quantity -->
<div>
    <label for="quantity" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
        Quantity <span class="text-red-600">*</span>
    </label>
    <input type="number" id="quantity" name="quantity"
        value="{{ old('quantity') }}"  placeholder="0" min="0"
        class="w-full mx-auto block px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
    @error('quantity')
        <p class="mt-2 text-xs text-red-600 text-center">{{ $message }}</p>
    @enderror
</div>

<!-- Price -->
<div>
    <label for="price" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
        Price (Rp) <span class="text-red-600">*</span>
    </label>
    <input type="number" id="price" name="price"
        value="{{ old('price') }}"  placeholder="0" min="0" step="1000"
        class="w-full mx-auto block px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
    @error('price')
        <p class="mt-2 text-xs text-red-600 text-center">{{ $message }}</p>
    @enderror
</div>

                        <!-- Owner -->
                        <div>
                            <label for="user_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Owner / Seller <span class="text-red-600">*</span>
                            </label>
                            <select id="user_id" name="user_id"  
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                <option value="" disabled {{ old('user_id') ? '' : 'selected' }}>-- Select Owner --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('product.index') }}" class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-lg shadow-sm transition-all active:scale-95">
                                Save Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>