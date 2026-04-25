<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background:#1e2a3a;">
                <div class="p-6">

                    {{-- Header --}}
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-100">Category List</h3>
                            <p class="text-sm text-gray-400">Manage your category</p>
                        </div>
                        <button onclick="document.getElementById('addModal').classList.remove('hidden')"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-md">
                            + Add Category
                        </button>
                    </div>

                    {{-- Alert --}}
                    @if(session('success'))
                        <div class="mb-4 px-4 py-3 bg-green-800 text-green-200 rounded-md text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Table --}}
                    <div class="overflow-x-auto rounded-lg" style="border: 1px solid #2d3f55;">
                        <table class="min-w-full divide-y" style="border-color:#2d3f55;">
                            <thead style="background:#2d3f55;">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider w-10">#</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Name</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Total Product</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody style="background:#1e2a3a;">
                                @forelse($categories as $index => $category)
                                <tr style="border-top: 1px solid #2d3f55;">
                                    <td class="px-4 py-3 text-sm text-gray-400">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-200">{{ $category->name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-400">{{ $category->products_count }}</td>
                                    <td class="px-4 py-3 text-sm flex items-center gap-3">
                                        <button
                                            onclick="openEdit({{ $category->id }}, '{{ addslashes($category->name) }}')"
                                            class="text-indigo-400 hover:text-indigo-300 text-sm font-medium">
                                            Edit
                                        </button>
                                        <form action="{{ route('category.destroy', $category->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin hapus category ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-400 hover:text-red-300 text-sm font-medium">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-sm text-gray-500">
                                        Belum ada category.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Modal Add --}}
    <div id="addModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60">
        <div class="rounded-lg shadow-lg w-full max-w-md p-6" style="background:#16213e; border:1px solid #2d3f55;">
            <div class="flex items-center gap-2 mb-5">
                <button onclick="document.getElementById('addModal').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-200 text-lg">&#8592;</button>
                <h3 class="text-base font-semibold text-gray-100">Add Category</h3>
            </div>
            <form action="{{ route('category.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-400 mb-1">Category</label>
                    <input type="text" name="name"
                        class="w-full rounded-md px-3 py-2 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        style="background:#0f1e3c; border:1px solid #2d3f55;"
                        placeholder="Electronic..." required autofocus>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button"
                        onclick="document.getElementById('addModal').classList.add('hidden')"
                        class="px-4 py-2 text-sm rounded-md text-gray-400 hover:text-gray-200"
                        style="border:1px solid #2d3f55;">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm rounded-md bg-indigo-600 hover:bg-indigo-700 text-white font-medium">
                        Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div id="editModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60">
        <div class="rounded-lg shadow-lg w-full max-w-md p-6" style="background:#16213e; border:1px solid #2d3f55;">
            <div class="flex items-center gap-2 mb-5">
                <button onclick="document.getElementById('editModal').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-200 text-lg">&#8592;</button>
                <h3 class="text-base font-semibold text-gray-100">Edit Category</h3>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-400 mb-1">Category</label>
                    <input type="text" name="name" id="editName"
                        class="w-full rounded-md px-3 py-2 text-sm text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        style="background:#0f1e3c; border:1px solid #2d3f55;"
                        required>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button"
                        onclick="document.getElementById('editModal').classList.add('hidden')"
                        class="px-4 py-2 text-sm rounded-md text-gray-400 hover:text-gray-200"
                        style="border:1px solid #2d3f55;">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm rounded-md bg-indigo-600 hover:bg-indigo-700 text-white font-medium">
                        Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEdit(id, name) {
            document.getElementById('editName').value = name;
            document.getElementById('editForm').action = '/category/' + id;
            document.getElementById('editModal').classList.remove('hidden');
        }
    </script>

</x-app-layout>