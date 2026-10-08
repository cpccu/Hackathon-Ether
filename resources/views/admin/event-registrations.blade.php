<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusOS - Event Registrations</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <nav class="bg-indigo-700 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold">Registrations for: {{ $event->title }}</h1>
            <a href="{{ route('admin.events') }}" class="bg-indigo-800 px-3 py-1 rounded text-sm hover:bg-indigo-900 transition">Back to Events</a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Total Registered Students: {{ $event->registrations->count() }}</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student Info</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student ID & Dept</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Batch</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submitted Custom Info</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($event->registrations as $reg)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="font-medium text-gray-900">{{ $reg->user->name }}</div>
                                <div class="text-gray-500">{{ $reg->user->email }} | {{ $reg->user->mobile_number }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div>{{ $reg->user->student_id }}</div>
                                <div class="text-gray-500">{{ $reg->user->department }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                Batch {{ $reg->user->batch_no }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                @if(!empty($reg->responses))
                                    <ul class="list-disc list-inside bg-gray-50 p-2 rounded text-xs space-y-1">
                                        @foreach($reg->responses as $key => $value)
                                            <li><strong>{{ $key }}:</strong> {{ $value }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-gray-400 italic">No extra info required</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No registrations found for this event yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>