<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <meta name="theme-color" content="#7F1D1D">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <title>Profile · CampusOS</title>

    <!-- Roboto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        milk: '#FFFDF8',
                        cream: '#F4EBDD',
                        creamDark: '#E9DDCA',
                        wine: '#7F1D1D',
                        wineDark: '#641616',
                        ink: '#292522',
                        muted: '#81776B'
                    },
                    fontFamily: {
                        roboto: ['Roboto', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <style>
        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: #FFFDF8;
            color: #292522;
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
        }

        button,
        input,
        textarea,
        select {
            font-family: inherit;
        }

        input,
        textarea,
        select {
            outline: none;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: #7F1D1D !important;
            box-shadow: 0 0 0 3px rgba(127, 29, 29, .08);
        }

        .glass {
            background: rgba(255, 255, 255, .88);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .safe-bottom {
            padding-bottom: env(safe-area-inset-bottom);
        }

        @media (max-width: 767px) {
            body {
                padding-bottom: 78px;
            }
        }

        @media (min-width: 768px) {
            .mobile-nav {
                display: none;
            }
        }
    </style>
</head>

<body>

@php
    $registeredCount = is_countable($registrations ?? null)
        ? count($registrations)
        : 0;

    $complaintCount = is_countable($complaints ?? null)
        ? count($complaints)
        : 0;

    $lostFoundCount = is_countable($lostFounds ?? null)
        ? count($lostFounds)
        : 0;

    $initial = strtoupper(substr($user->name ?? 'U', 0, 1));
@endphp


<!-- =========================================================
     DESKTOP / TABLET NAVBAR
========================================================= -->
<header class="sticky top-0 z-40 hidden md:block">

    <div class="bg-white/95 backdrop-blur border-b border-[#eadfce]">

        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="h-[72px] flex items-center justify-between">

                <!-- Logo -->
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3">

                    <div class="w-10 h-10 rounded-xl bg-wine text-white flex items-center justify-center font-bold shadow-sm">
                        C
                    </div>

                    <div>
                        <div class="font-bold text-lg text-ink leading-none">
                            CampusOS
                        </div>

                        <div class="text-[11px] text-muted mt-1">
                            Student Portal
                        </div>
                    </div>

                </a>


                <!-- Desktop navigation -->
                <nav class="flex items-center gap-2">

                    <a href="{{ route('dashboard') }}"
                       class="px-4 py-2.5 rounded-xl text-sm font-medium text-muted hover:bg-cream hover:text-wine transition">
                        Dashboard
                    </a>

                    <a href="{{ route('user.profile') }}"
                       class="px-4 py-2.5 rounded-xl text-sm font-semibold bg-cream text-wine">
                        Profile
                    </a>

                    <form method="POST"
                          action="{{ route('logout') }}"
                          class="ml-1">
                        @csrf

                        <button type="submit"
                                class="px-4 py-2.5 rounded-xl text-sm font-medium text-red-700 hover:bg-red-50 transition">
                            Logout
                        </button>
                    </form>

                </nav>

            </div>

        </div>

    </div>

</header>


<!-- =========================================================
     MAIN
========================================================= -->
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 sm:py-8 space-y-5 sm:space-y-7">


    <!-- =====================================================
         SUCCESS / ERROR MESSAGES
    ====================================================== -->

    @if(session('success'))

        <div class="flex items-start gap-3 bg-green-50 border border-green-200 text-green-800 rounded-2xl px-4 py-3.5">

            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                ✓
            </div>

            <div class="text-sm pt-1">
                {{ session('success') }}
            </div>

        </div>

    @endif


    @if ($errors->any())

        <div class="bg-red-50 border border-red-200 text-red-800 rounded-2xl px-4 py-3.5">

            <div class="font-semibold text-sm mb-2">
                Please check the following:
            </div>

            <ul class="list-disc list-inside text-xs space-y-1">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    <!-- =====================================================
         PAGE TITLE
    ====================================================== -->

    <div class="flex items-center justify-between gap-3">

        <div>
            <p class="text-xs font-semibold uppercase tracking-wider text-wine">
                Student Account
            </p>

            <h1 class="text-2xl sm:text-3xl font-bold text-ink mt-1">
                My Profile
            </h1>

            <p class="text-sm text-muted mt-1">
                Manage your account and view your campus activity.
            </p>
        </div>

    </div>


    <!-- =====================================================
         PROFILE HERO
    ====================================================== -->

    <section class="bg-white rounded-3xl border border-[#eadfce] shadow-sm overflow-visible">

        <!-- Banner -->
        <div class="relative h-28 sm:h-36 md:h-40 bg-gradient-to-r from-[#641616] via-[#7F1D1D] to-[#9b2929] rounded-t-3xl overflow-hidden">

            <!-- Decorative circles -->
            <div class="absolute -right-10 -top-16 w-48 h-48 rounded-full bg-white/10"></div>
            <div class="absolute right-20 -bottom-20 w-40 h-40 rounded-full bg-white/5"></div>

            <div class="absolute left-5 sm:left-8 top-5">

                <div class="text-white/70 text-xs font-medium">
                    CAMPUSOS
                </div>

                <div class="text-white font-semibold text-sm sm:text-base mt-1">
                    Student Profile
                </div>

            </div>

        </div>


        <!-- Profile information -->
        <div class="px-5 sm:px-7 lg:px-9 pb-6 sm:pb-7">

            <!-- Avatar -->
            <div class="-mt-14 sm:-mt-16 relative z-10 mb-4">

                @if($user->profile_pic)

                    <img
                        src="{{ asset('storage/' . $user->profile_pic) }}"
                        alt="{{ $user->name }}"
                        loading="eager"
                        class="w-28 h-28 sm:w-32 sm:h-32 rounded-full object-cover object-center border-4 border-white shadow-xl bg-white"
                    >

                @else

                    <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-full bg-wine text-white flex items-center justify-center text-3xl sm:text-4xl font-bold border-4 border-white shadow-xl">
                        {{ $initial }}
                    </div>

                @endif

            </div>


            <!-- Main profile info -->
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-5">

                <div class="min-w-0">

                    <h2 class="text-xl sm:text-2xl font-bold text-ink break-words">
                        {{ $user->name }}
                    </h2>

                    <p class="text-sm text-muted mt-1">
                        Student ID: {{ $user->student_id }}
                    </p>

                    <div class="flex flex-wrap gap-2 mt-3">

                        <span class="inline-flex items-center px-3 py-1.5 rounded-full bg-cream text-wine text-xs font-semibold">
                            {{ $user->department }}
                        </span>

                        <span class="inline-flex items-center px-3 py-1.5 rounded-full bg-cream text-wine text-xs font-semibold">
                            Batch {{ $user->batch_no }}
                        </span>

                    </div>

                </div>


                <!-- Edit button -->
                <div class="flex-shrink-0">

                    <button
                        type="button"
                        onclick="toggleProfileEdit()"
                        id="editProfileButton"
                        class="w-full lg:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-wine text-white text-sm font-semibold hover:bg-wineDark active:scale-[.98] transition">

                        <svg id="editIcon"
                             class="w-4 h-4"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-9.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 8.5-8.5z"/>
                        </svg>

                        <span id="editProfileText">
                            Edit Profile
                        </span>

                    </button>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         PROFILE STATS
    ====================================================== -->

    <section class="grid grid-cols-3 gap-2 sm:gap-4">

        <div class="bg-white border border-[#eadfce] rounded-2xl p-3.5 sm:p-5">

            <div class="flex items-center gap-3">

                <div class="hidden sm:flex w-10 h-10 rounded-xl bg-cream text-wine items-center justify-center">
                    ✓
                </div>

                <div class="min-w-0">

                    <p class="text-xl sm:text-2xl font-bold text-ink">
                        {{ $registeredCount }}
                    </p>

                    <p class="text-[10px] sm:text-xs text-muted mt-0.5 truncate">
                        Events
                    </p>

                </div>

            </div>

        </div>


        <div class="bg-white border border-[#eadfce] rounded-2xl p-3.5 sm:p-5">

            <div class="flex items-center gap-3">

                <div class="hidden sm:flex w-10 h-10 rounded-xl bg-cream text-wine items-center justify-center">
                    !
                </div>

                <div class="min-w-0">

                    <p class="text-xl sm:text-2xl font-bold text-ink">
                        {{ $complaintCount }}
                    </p>

                    <p class="text-[10px] sm:text-xs text-muted mt-0.5 truncate">
                        Complaints
                    </p>

                </div>

            </div>

        </div>


        <div class="bg-white border border-[#eadfce] rounded-2xl p-3.5 sm:p-5">

            <div class="flex items-center gap-3">

                <div class="hidden sm:flex w-10 h-10 rounded-xl bg-cream text-wine items-center justify-center">
                    ?
                </div>

                <div class="min-w-0">

                    <p class="text-xl sm:text-2xl font-bold text-ink">
                        {{ $lostFoundCount }}
                    </p>

                    <p class="text-[10px] sm:text-xs text-muted mt-0.5 truncate">
                        Lost & Found
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         EDIT PROFILE
         Hidden by default
    ====================================================== -->

    <section id="profileEditSection"
             class="hidden">

        <div class="bg-white border border-[#eadfce] rounded-3xl shadow-sm p-5 sm:p-7">

            <div class="flex items-start justify-between gap-4 mb-6">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-wine">
                        Account Settings
                    </p>

                    <h2 class="text-lg sm:text-xl font-bold text-ink mt-1">
                        Edit Profile
                    </h2>

                    <p class="text-xs sm:text-sm text-muted mt-1">
                        Update your personal information and profile picture.
                    </p>

                </div>

                <button
                    type="button"
                    onclick="toggleProfileEdit()"
                    class="w-9 h-9 rounded-xl bg-cream text-wine flex items-center justify-center hover:bg-creamDark transition">

                    ✕

                </button>

            </div>


            <form
                action="{{ route('user.profile.update') }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf


                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">


                    <!-- Full name -->
                    <div>

                        <label class="block text-xs font-semibold text-ink mb-1.5">
                            Full Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            required
                            autocomplete="name"
                            class="w-full h-11 px-3.5 rounded-xl border border-[#e4d8c8] bg-[#fffdfa] text-sm text-ink placeholder-[#a49a8e] transition"
                            placeholder="Enter your full name">

                    </div>


                    <!-- Mobile -->
                    <div>

                        <label class="block text-xs font-semibold text-ink mb-1.5">
                            Mobile Number
                        </label>

                        <input
                            type="text"
                            name="mobile_number"
                            value="{{ old('mobile_number', $user->mobile_number) }}"
                            required
                            autocomplete="tel"
                            class="w-full h-11 px-3.5 rounded-xl border border-[#e4d8c8] bg-[#fffdfa] text-sm text-ink transition"
                            placeholder="01XXXXXXXXX">

                    </div>


                    <!-- Student ID -->
                    <div>

                        <label class="block text-xs font-semibold text-ink mb-1.5">
                            Student ID
                        </label>

                        <input
                            type="text"
                            name="student_id"
                            value="{{ old('student_id', $user->student_id) }}"
                            required
                            class="w-full h-11 px-3.5 rounded-xl border border-[#e4d8c8] bg-[#fffdfa] text-sm text-ink transition">

                    </div>


                    <!-- Department -->
                    <div>

                        <label class="block text-xs font-semibold text-ink mb-1.5">
                            Department
                        </label>

                        <input
                            type="text"
                            name="department"
                            value="{{ old('department', $user->department) }}"
                            required
                            class="w-full h-11 px-3.5 rounded-xl border border-[#e4d8c8] bg-[#fffdfa] text-sm text-ink transition">

                    </div>


                    <!-- Batch -->
                    <div>

                        <label class="block text-xs font-semibold text-ink mb-1.5">
                            Batch No
                        </label>

                        <input
                            type="text"
                            name="batch_no"
                            value="{{ old('batch_no', $user->batch_no) }}"
                            required
                            class="w-full h-11 px-3.5 rounded-xl border border-[#e4d8c8] bg-[#fffdfa] text-sm text-ink transition">

                    </div>


                    <!-- Profile picture -->
                    <div>

                        <label class="block text-xs font-semibold text-ink mb-1.5">
                            Profile Picture
                        </label>

                        <input
                            type="file"
                            name="profile_pic"
                            accept="image/*"
                            class="w-full h-11 text-xs text-muted border border-[#e4d8c8] rounded-xl bg-[#fffdfa] file:mr-3 file:h-full file:border-0 file:px-3 file:bg-cream file:text-wine file:font-semibold">

                        <p class="text-[10px] text-muted mt-1.5">
                            Choose a clear square image for the best result.
                        </p>

                    </div>


                </div>


                <!-- Buttons -->
                <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-2 mt-6 pt-5 border-t border-[#eee4d6]">

                    <button
                        type="button"
                        onclick="toggleProfileEdit()"
                        class="w-full sm:w-auto px-5 py-3 rounded-xl border border-[#e4d8c8] text-sm font-semibold text-muted hover:bg-cream transition">
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="w-full sm:w-auto px-6 py-3 rounded-xl bg-wine text-white text-sm font-semibold hover:bg-wineDark active:scale-[.98] transition">
                        Save Changes
                    </button>

                </div>

            </form>

        </div>

    </section>


    <!-- =====================================================
         REGISTERED EVENTS + COMPLAINTS
    ====================================================== -->

    <section class="grid grid-cols-1 lg:grid-cols-2 gap-5 sm:gap-6">


        <!-- Registered Events -->
        <div class="bg-white border border-[#eadfce] rounded-3xl shadow-sm overflow-hidden">

            <div class="px-5 sm:px-6 py-5 border-b border-[#eee4d6] flex items-center justify-between">

                <div>

                    <h2 class="font-bold text-base sm:text-lg text-ink">
                        Registered Events
                    </h2>

                    <p class="text-xs text-muted mt-1">
                        Events you have joined
                    </p>

                </div>

                <span class="px-2.5 py-1 rounded-full bg-cream text-wine text-xs font-bold">
                    {{ $registeredCount }}
                </span>

            </div>


            <div class="p-4 sm:p-5 space-y-3 max-h-[430px] overflow-y-auto">

                @forelse($registrations as $reg)

                    <div class="border border-[#eadfce] rounded-2xl p-3.5 bg-[#fffdfa] hover:bg-cream/40 transition">

                        <div class="flex gap-3">

                            @if($reg->event->banner)

                                <img
                                    src="{{ asset('storage/' . $reg->event->banner) }}"
                                    alt="{{ $reg->event->title }}"
                                    loading="lazy"
                                    class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl object-cover flex-shrink-0">

                            @else

                                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl bg-cream flex items-center justify-center text-wine font-bold flex-shrink-0">
                                    C
                                </div>

                            @endif


                            <div class="min-w-0 flex-1">

                                <h3 class="font-semibold text-sm text-ink line-clamp-2">
                                    {{ $reg->event->title }}
                                </h3>

                                <p class="text-[11px] text-muted mt-2">
                                    {{ date('d M Y, h:i A', strtotime($reg->event->date_time)) }}
                                </p>


                                @if(!empty($reg->responses))

                                    <div class="mt-2 bg-cream/60 rounded-xl px-2.5 py-2">

                                        @foreach($reg->responses as $k => $v)

                                            <div class="text-[10px] text-ink">
                                                <strong>{{ $k }}:</strong> {{ $v }}
                                            </div>

                                        @endforeach

                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="py-10 text-center">

                        <div class="w-12 h-12 mx-auto rounded-2xl bg-cream text-wine flex items-center justify-center text-xl">
                            +
                        </div>

                        <p class="text-sm font-semibold text-ink mt-3">
                            No registered events
                        </p>

                        <p class="text-xs text-muted mt-1">
                            Your joined events will appear here.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>


        <!-- Complaints -->
        <div class="bg-white border border-[#eadfce] rounded-3xl shadow-sm overflow-hidden">

            <div class="px-5 sm:px-6 py-5 border-b border-[#eee4d6] flex items-center justify-between">

                <div>

                    <h2 class="font-bold text-base sm:text-lg text-ink">
                        My Complaints
                    </h2>

                    <p class="text-xs text-muted mt-1">
                        Your submitted reports
                    </p>

                </div>

                <span class="px-2.5 py-1 rounded-full bg-cream text-wine text-xs font-bold">
                    {{ $complaintCount }}
                </span>

            </div>


            <div class="p-4 sm:p-5 space-y-3 max-h-[430px] overflow-y-auto">

                @forelse($complaints as $comp)

                    <div class="border border-[#eadfce] rounded-2xl p-4 bg-[#fffdfa]">

                        <div class="flex items-start gap-3">

                            <div class="w-9 h-9 rounded-xl bg-cream text-wine flex items-center justify-center flex-shrink-0 font-bold">
                                !
                            </div>

                            <div class="min-w-0">

                                <h3 class="font-semibold text-sm text-ink">
                                    {{ $comp->title }}
                                </h3>

                                <p class="text-xs text-muted mt-1.5 leading-5">
                                    {{ $comp->short_description }}
                                </p>

                                <p class="text-[10px] text-[#a49a8e] mt-2">
                                    {{ $comp->created_at->diffForHumans() }}
                                </p>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="py-10 text-center">

                        <div class="w-12 h-12 mx-auto rounded-2xl bg-cream text-wine flex items-center justify-center text-xl">
                            ✓
                        </div>

                        <p class="text-sm font-semibold text-ink mt-3">
                            No complaints
                        </p>

                        <p class="text-xs text-muted mt-1">
                            Your submitted complaints will appear here.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </section>


    <!-- =====================================================
         LOST & FOUND
    ====================================================== -->

    <section class="bg-white border border-[#eadfce] rounded-3xl shadow-sm overflow-hidden">

        <!-- Header -->
        <div class="px-5 sm:px-6 py-5 border-b border-[#eee4d6] flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

            <div>

                <h2 class="font-bold text-base sm:text-lg text-ink">
                    Lost & Found
                </h2>

                <p class="text-xs text-muted mt-1">
                    Help other students find lost belongings.
                </p>

            </div>


            <button
                type="button"
                onclick="toggleLostForm()"
                id="lostFormButton"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-wine text-white text-xs sm:text-sm font-semibold hover:bg-wineDark transition">

                <span id="lostFormButtonIcon">+</span>

                <span id="lostFormButtonText">
                    Add Report
                </span>

            </button>

        </div>


        <!-- Lost & Found form -->
        <div id="lostForm"
             class="hidden p-5 sm:p-6 border-b border-[#eee4d6] bg-[#fffdfa]">

            <form
                action="{{ route('user.lostfound.store') }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">


                    <!-- Title -->
                    <div>

                        <label class="block text-xs font-semibold text-ink mb-1.5">
                            Item Title
                        </label>

                        <input
                            type="text"
                            name="title"
                            placeholder="e.g. Lost Student ID"
                            required
                            class="w-full h-11 px-3.5 rounded-xl border border-[#e4d8c8] bg-white text-sm">

                    </div>


                    <!-- Location -->
                    <div>

                        <label class="block text-xs font-semibold text-ink mb-1.5">
                            Location
                        </label>

                        <input
                            type="text"
                            name="location"
                            placeholder="e.g. Cafeteria"
                            required
                            class="w-full h-11 px-3.5 rounded-xl border border-[#e4d8c8] bg-white text-sm">

                    </div>


                    <!-- Date -->
                    <div>

                        <label class="block text-xs font-semibold text-ink mb-1.5">
                            Date & Time
                        </label>

                        <input
                            type="datetime-local"
                            name="date_time"
                            required
                            class="w-full h-11 px-3 rounded-xl border border-[#e4d8c8] bg-white text-sm">

                    </div>


                    <!-- Mobile -->
                    <div>

                        <label class="block text-xs font-semibold text-ink mb-1.5">
                            Contact Number
                        </label>

                        <input
                            type="text"
                            name="mobile_number"
                            value="{{ old('mobile_number', $user->mobile_number) }}"
                            required
                            class="w-full h-11 px-3.5 rounded-xl border border-[#e4d8c8] bg-white text-sm">

                    </div>


                    <!-- Status -->
                    <div>

                        <label class="block text-xs font-semibold text-ink mb-1.5">
                            Status
                        </label>

                        <select
                            name="status"
                            class="w-full h-11 px-3.5 rounded-xl border border-[#e4d8c8] bg-white text-sm">

                            <option value="lost">
                                Lost
                            </option>

                            <option value="found">
                                Found
                            </option>

                        </select>

                    </div>


                    <!-- Image -->
                    <div>

                        <label class="block text-xs font-semibold text-ink mb-1.5">
                            Item Image
                        </label>

                        <input
                            type="file"
                            name="image"
                            accept="image/*"
                            class="w-full h-11 text-xs border border-[#e4d8c8] rounded-xl bg-white file:mr-2 file:h-full file:border-0 file:px-3 file:bg-cream file:text-wine">

                    </div>


                    <!-- Description -->
                    <div class="md:col-span-2 lg:col-span-3">

                        <label class="block text-xs font-semibold text-ink mb-1.5">
                            Description
                        </label>

                        <textarea
                            name="description"
                            rows="3"
                            required
                            placeholder="Describe the item and where it was lost/found..."
                            class="w-full px-3.5 py-3 rounded-xl border border-[#e4d8c8] bg-white text-sm resize-none"></textarea>

                    </div>


                </div>


                <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-2 mt-5">

                    <button
                        type="button"
                        onclick="toggleLostForm()"
                        class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-[#e4d8c8] text-xs font-semibold text-muted hover:bg-cream transition">
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-wine text-white text-xs font-semibold hover:bg-wineDark transition">
                        Publish Report
                    </button>

                </div>

            </form>

        </div>


        <!-- Lost & Found feed -->
        <div class="p-4 sm:p-6">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                @forelse($lostFounds as $item)

                    <article class="border border-[#eadfce] rounded-2xl bg-[#fffdfa] overflow-hidden hover:shadow-sm transition">


                        @if($item->image)

                            <img
                                src="{{ asset('storage/' . $item->image) }}"
                                alt="{{ $item->title }}"
                                loading="lazy"
                                class="w-full h-40 object-cover">

                        @else

                            <div class="w-full h-40 bg-cream flex items-center justify-center text-wine text-3xl">
                                ?
                            </div>

                        @endif


                        <div class="p-4">

                            <div class="flex items-start justify-between gap-2">

                                <h3 class="font-bold text-sm text-ink line-clamp-2">
                                    {{ $item->title }}
                                </h3>

                                <span class="flex-shrink-0 px-2 py-1 rounded-full text-[9px] font-bold
                                    {{ $item->status === 'lost'
                                        ? 'bg-red-50 text-red-700'
                                        : 'bg-green-50 text-green-700' }}">

                                    {{ ucfirst($item->status) }}

                                </span>

                            </div>


                            <p class="text-[11px] text-muted mt-3">
                                📍 {{ $item->location }}
                            </p>

                            <p class="text-[11px] text-muted mt-1">
                                📞 {{ $item->mobile_number }}
                            </p>


                            <p class="text-xs text-ink leading-5 mt-3 line-clamp-3">
                                {{ $item->description }}
                            </p>

                        </div>

                    </article>

                @empty

                    <div class="sm:col-span-2 lg:col-span-3 py-12 text-center">

                        <div class="w-14 h-14 mx-auto rounded-2xl bg-cream text-wine flex items-center justify-center text-2xl">
                            ?
                        </div>

                        <p class="text-sm font-semibold text-ink mt-3">
                            Nothing posted yet
                        </p>

                        <p class="text-xs text-muted mt-1">
                            Be the first to report a lost or found item.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </section>


</main>


<!-- =========================================================
     MOBILE BOTTOM NAVIGATION
========================================================= -->

<nav class="mobile-nav fixed bottom-0 left-0 right-0 z-50 bg-white/95 backdrop-blur border-t border-[#eadfce] safe-bottom">

    <div class="h-[68px] px-3 flex items-center justify-around">

        <a href="{{ route('dashboard') }}"
           class="flex flex-col items-center justify-center gap-1 w-20 h-full text-muted">

            <svg class="w-5 h-5"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="1.8"
                      d="M3 12l9-9 9 9M5 10v10h14V10"/>
            </svg>

            <span class="text-[10px] font-medium">
                Home
            </span>

        </a>


        <a href="{{ route('user.profile') }}"
           class="flex flex-col items-center justify-center gap-1 w-20 h-full text-wine">

            <div class="w-9 h-9 rounded-xl bg-cream flex items-center justify-center">

                <svg class="w-5 h-5"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="1.8"
                          d="M20 21a8 8 0 00-16 0M12 13a4 4 0 100-8 4 4 0 000 8z"/>
                </svg>

            </div>

            <span class="text-[10px] font-semibold">
                Profile
            </span>

        </a>


        <form method="POST"
              action="{{ route('logout') }}"
              class="w-20 h-full">

            @csrf

            <button type="submit"
                    class="w-full h-full flex flex-col items-center justify-center gap-1 text-muted">

                <svg class="w-5 h-5"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="1.8"
                          d="M17 16l4-4m0 0l-4-4m4 4H9m4 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h5a2 2 0 012 2v1"/>
                </svg>

                <span class="text-[10px] font-medium">
                    Logout
                </span>

            </button>

        </form>

    </div>

</nav>


<!-- =========================================================
     JAVASCRIPT
========================================================= -->

<script>

    /*
     * Profile edit toggle
     */
    function toggleProfileEdit() {

        const section = document.getElementById('profileEditSection');
        const text = document.getElementById('editProfileText');
        const icon = document.getElementById('editIcon');

        if (!section) return;

        const isHidden = section.classList.contains('hidden');

        if (isHidden) {

            section.classList.remove('hidden');

            text.textContent = 'Close Edit';

            icon.innerHTML = `
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6M6 6l12 12">
                </path>
            `;

            setTimeout(() => {

                section.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

            }, 50);

        } else {

            section.classList.add('hidden');

            text.textContent = 'Edit Profile';

            icon.innerHTML = `
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-9.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 8.5-8.5z">
                </path>
            `;

        }

    }


    /*
     * Lost & Found form toggle
     */
    function toggleLostForm() {

        const form = document.getElementById('lostForm');
        const text = document.getElementById('lostFormButtonText');
        const icon = document.getElementById('lostFormButtonIcon');

        if (!form) return;

        const isHidden = form.classList.contains('hidden');

        if (isHidden) {

            form.classList.remove('hidden');

            text.textContent = 'Close Form';
            icon.textContent = '×';

            setTimeout(() => {

                form.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

            }, 50);

        } else {

            form.classList.add('hidden');

            text.textContent = 'Add Report';
            icon.textContent = '+';

        }

    }


    /*
     * Prevent accidental double submit
     */
    document.addEventListener('DOMContentLoaded', function () {

        document.querySelectorAll('form').forEach(function (form) {

            form.addEventListener('submit', function () {

                const button = form.querySelector('button[type="submit"]');

                if (!button) return;

                if (button.dataset.submitting === 'true') {
                    return;
                }

                button.dataset.submitting = 'true';

                setTimeout(function () {

                    button.dataset.submitting = 'false';

                }, 5000);

            });

        });

    });

</script>

</body>
</html>