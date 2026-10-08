<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusOS - Super Admin Dashboard</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <!-- Navbar -->
    <nav class="bg-indigo-700 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold">CampusOS | Admin Panel</h1>
            <div class="flex items-center gap-4">
                <!-- Link to Events Management Page -->
                <a href="{{ route('admin.events') }}" class="bg-indigo-600 hover:bg-indigo-800 px-3 py-1 rounded text-sm transition border border-indigo-500 font-medium">Manage Events & Clubs</a>
                
                <span>Welcome, <strong>{{ Auth::user()->name }}</strong> (Super Admin)</span>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-sm transition">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        
        <!-- Success Alert Message -->
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Manage Users & Batch CRs</h2>
                <span class="text-sm text-gray-500">Total Users: {{ $users->count() }}</span>
            </div>

            <!-- Users Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User Info</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dept & Batch</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Role</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $u)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $u->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $u->email }} | {{ $u->mobile_number }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $u->student_id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $u->department }} <span class="bg-blue-100 text-blue-800 text-xs px-2 py-0.5 rounded font-semibold">Batch {{ $u->batch_no }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($u->role === 'super_admin')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Super Admin</span>
                                @elseif($u->role === 'cr')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">CR (Batch {{ $u->batch_no }})</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Normal User</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                @if($u->role !== 'super_admin')
                                    @if($u->role === 'cr')
                                        <form action="{{ route('admin.remove.cr', $u->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded transition">Remove CR</button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.make.cr', $u->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded transition">Make CR</button>
                                        </form>
                                    @endif
                                @else
                                    <span class="text-gray-400 italic">Protected</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add User / CR Form Section -->
        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Create New User or CR</h2>

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Mobile Number</label>
                    <input type="text" name="mobile_number" value="{{ old('mobile_number') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Student ID</label>
                    <input type="text" name="student_id" value="{{ old('student_id') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Department</label>
                    <input type="text" name="department" value="{{ old('department') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Batch No</label>
                    <input type="text" name="batch_no" value="{{ old('batch_no') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Assign Role</label>
                    <select name="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border px-3 py-2">
                        <option value="user">Normal Student</option>
                        <option value="cr">Class Representative (CR)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Profile Picture (Optional)</label>
                    <input type="file" name="profile_pic" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>

                <div class="md:col-span-3 flex justify-end mt-2">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition">Create Account</button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>