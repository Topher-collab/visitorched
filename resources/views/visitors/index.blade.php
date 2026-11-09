<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visitor Management - CHED</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] flex flex-col min-h-screen p-6 lg:p-8">

    <header class="w-full max-w-6xl mx-auto mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">CHED Visitor Management</h1>
            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] mt-1">Track and manage visitor records efficiently.</p>
        </div>
    </header>

    <main class="w-full max-w-6xl mx-auto flex-1 grid grid-cols-1 lg:grid-cols-3 gap-6">

        @if(session('success'))
            <div class="col-span-1 lg:col-span-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-md text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Add New Visitor Form -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-[#161615] rounded-lg shadow-sm border border-[#e3e3e0] dark:border-[#3E3E3A] p-6 sticky top-6">
                <h2 class="text-lg font-semibold mb-4">Add New Visitor</h2>
                <form action="{{ route('visitors.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium mb-1">Full Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full px-3 py-2 bg-[#FDFDFC] dark:bg-[#0a0a0a] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="position" class="block text-sm font-medium mb-1">Position / Purpose</label>
                        <input type="text" name="position" id="position" value="{{ old('position') }}" required
                            class="w-full px-3 py-2 bg-[#FDFDFC] dark:bg-[#0a0a0a] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('position')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-medium mb-1">Address</label>
                        <textarea name="address" id="address" rows="3" required
                            class="w-full px-3 py-2 bg-[#FDFDFC] dark:bg-[#0a0a0a] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('address') }}</textarea>
                        @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="w-full bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] font-medium py-2 px-4 rounded-md hover:bg-black dark:hover:bg-white transition-colors text-sm">
                        Save Visitor
                    </button>
                </form>
            </div>
        </div>

        <!-- Visitor List -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-[#161615] rounded-lg shadow-sm border border-[#e3e3e0] dark:border-[#3E3E3A] overflow-hidden">
                <div class="px-6 py-4 border-b border-[#e3e3e0] dark:border-[#3E3E3A] flex items-center justify-between">
                    <h2 class="text-lg font-semibold">Registered Visitors</h2>
                    <span class="text-xs font-medium px-2.5 py-0.5 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200">
                        {{ $visitors->count() }} Total
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-800/50 text-[#706f6c] dark:text-[#A1A09A]">
                            <tr>
                                <th class="px-6 py-3 font-medium">Name</th>
                                <th class="px-6 py-3 font-medium">Position</th>
                                <th class="px-6 py-3 font-medium">Address</th>
                                <th class="px-6 py-3 font-medium text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#e3e3e0] dark:divide-[#3E3E3A]">
                            @forelse ($visitors as $visitor)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                                    <td class="px-6 py-4 font-medium">{{ $visitor->name }}</td>
                                    <td class="px-6 py-4 text-[#706f6c] dark:text-[#A1A09A]">{{ $visitor->position }}</td>
                                    <td class="px-6 py-4 text-[#706f6c] dark:text-[#A1A09A] max-w-xs truncate" title="{{ $visitor->address }}">{{ $visitor->address }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-3" x-data="{ open: false }">
                                            <form action="{{ route('visitors.update', $visitor->id) }}" method="POST" class="flex items-center gap-2" x-show="open" @click.outside="open = false">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" name="name" value="{{ $visitor->name }}" class="w-24 px-2 py-1 text-xs border rounded dark:bg-[#0a0a0a] dark:border-[#3E3E3A] focus:outline-none focus:ring-1 focus:ring-blue-500">
                                                <input type="text" name="position" value="{{ $visitor->position }}" class="w-24 px-2 py-1 text-xs border rounded dark:bg-[#0a0a0a] dark:border-[#3E3E3A] focus:outline-none focus:ring-1 focus:ring-blue-500">
                                                <button type="submit" class="text-green-600 dark:text-green-400 hover:underline text-xs font-medium">Save</button>
                                                <button type="button" @click="open = false" class="text-gray-500 hover:underline text-xs">Cancel</button>
                                            </form>
                                            <div x-show="!open" class="flex items-center gap-3">
                                                <button type="button" @click="open = true" class="text-blue-600 dark:text-blue-400 hover:underline text-xs font-medium">Edit</button>
                                                <form action="{{ route('visitors.destroy', $visitor->id) }}" method="POST" onsubmit="return confirm('Delete this visitor?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:underline text-xs font-medium">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-[#706f6c] dark:text-[#A1A09A]">
                                        <p class="mb-2">No visitors found in the system.</p>
                                        <p class="text-xs">Use the form on the left to add your first visitor.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <footer class="w-full max-w-6xl mx-auto mt-8 pt-6 border-t border-[#e3e3e0] dark:border-[#3E3E3A] text-center text-xs text-[#706f6c] dark:text-[#A1A09A]">
        <p>&copy; {{ date('Y') }} CHED Visitor Management System. Built with Laravel {{ app()->version() }}.</p>
    </footer>

    <script>
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.classList.add('dark');
        }
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
            if (event.matches) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        });
    </script>
</body>
</html>