<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusOS - Manage Clubs & Events</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function addField() {
            let container = document.getElementById('custom-fields-container');
            let div = document.createElement('div');
            div.className = 'flex gap-2 mb-2';
            div.innerHTML = '<input type="text" name="custom_fields[]" placeholder="e.g. Transaction ID" class="border rounded px-3 py-1 w-full text-sm" required><button type="button" onclick="this.parentElement.remove()" class="bg-red-500 text-white px-2 py-1 rounded text-xs">X</button>';
            container.appendChild(div);
        }
    </script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <!-- Navbar -->
    <nav class="bg-indigo-700 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold">CampusOS | Events & Clubs Manager</h1>
            <a href="{{ route('admin.dashboard') }}" class="bg-indigo-800 px-3 py-1 rounded text-sm hover:bg-indigo-900 transition">Back to Dashboard</a>
        </div>
        
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-8 space-y-8">
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->any_error ?? $errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- SECTION 1: Add Category -->
            <div class="bg-white shadow rounded-lg p-6 h-fit">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Add Event Category</h2>
                <form action="{{ route('admin.category.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Category Name</label>
                        <input type="text" name="name" placeholder="e.g. Tech Club, Cultural" required class="mt-1 block w-full rounded-md border-gray-300 border px-3 py-2 text-sm">
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 text-sm transition">Add Category</button>
                </form>
            </div>

            <!-- SECTION 2: Create Event -->
            <div class="bg-white shadow rounded-lg p-6 md:col-span-2">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Create New Event (Auto WebP Optimization)</h2>
                <form action="{{ route('admin.event.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Event Title</label>
                        <input type="text" name="title" required class="mt-1 block w-full rounded-md border-gray-300 border px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Category</label>
                        <select name="event_category_id" required class="mt-1 block w-full rounded-md border-gray-300 border px-3 py-2 text-sm">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Banner Image (Will convert to WebP)</label>
                        <input type="file" name="banner" accept="image/*" required class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date & Time</label>
                        <input type="datetime-local" name="date_time" required class="mt-1 block w-full rounded-md border-gray-300 border px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" name="location" placeholder="e.g. Auditorium Hall" required class="mt-1 block w-full rounded-md border-gray-300 border px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tags (comma separated)</label>
                        <input type="text" name="tags" placeholder="e.g. coding, workshop, free" class="mt-1 block w-full rounded-md border-gray-300 border px-3 py-2 text-sm">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 border px-3 py-2 text-sm"></textarea>
                    </div>

                    <!-- Dynamic Extra Fields for Users to Fill -->
                    <div class="md:col-span-2 border-t pt-4">
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-sm font-medium text-gray-700">Extra Required Fields for Attendees (e.g. Payment Method, TrxID)</label>
                            <button type="button" onclick="addField()" class="bg-gray-200 text-gray-800 px-3 py-1 rounded text-xs hover:bg-gray-300">+ Add Input Field</button>
                        </div>
                        <div id="custom-fields-container"></div>
                    </div>

                    <div class="md:col-span-2 flex justify-end">
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 text-sm transition">Publish Event</button>
                    </div>
                </form>
            </div>

        </div>

       <!-- SECTION 3: View Existing Events -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Published Events</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($events as $event)
                <div class="border rounded-lg overflow-hidden shadow-sm flex flex-col justify-between bg-white">
                    <div>
                        @if($event->banner)
                            <img src="{{ asset('storage/' . $event->banner) }}" alt="Banner" class="w-full h-40 object-cover">
                        @endif
                        <div class="p-4 space-y-2">
                            <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-0.5 rounded font-semibold">
                                {{ $event->category->name ?? 'General' }}
                            </span>
                            <h3 class="font-bold text-gray-900 text-lg">{{ $event->title }}</h3>
                            <p class="text-xs text-gray-500">📍 {{ $event->location }} | ⏰ {{ $event->date_time }}</p>
                            <p class="text-sm text-gray-600 line-clamp-2">{{ $event->description }}</p>
                            
                            @if(!empty($event->custom_fields))
                                <div class="text-xs text-amber-700 bg-amber-50 p-2 rounded">
                                    <strong>Required User Inputs:</strong> {{ implode(', ', $event->custom_fields) }}
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Registration Link inside the loop where $event is active -->
                    <div class="bg-gray-50 px-4 py-2 border-t text-xs text-gray-500 flex justify-between items-center">
                        <span>Registrations: {{ $event->registrations()->count() }}</span>
                        <a href="{{ route('admin.event.registrations', $event->id) }}" class="text-indigo-600 hover:underline font-medium">View Registrations</a>
                    </div>
                </div>
                @empty
                    <p class="text-gray-500 text-sm md:col-span-3">No events created yet.</p>
                @endforelse
            </div>
        </div>
    </main>
</body>
</html>