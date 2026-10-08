<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CampusOS - CR Dashboard</title>

    <!-- Roboto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: "Roboto", Arial, sans-serif;
            background: #f7f7f8;
            color: #18181b;
        }

        button,
        input,
        select {
            font-family: inherit;
        }

        ::selection {
            background: #7f1d1d;
            color: #ffffff;
        }

        .app-bg {
            background:
                radial-gradient(circle at 0% 0%, rgba(127, 29, 29, 0.045), transparent 30%),
                #f7f7f8;
        }

        .sidebar-link {
            color: #52525b;
            transition: all .18s ease;
        }

        .sidebar-link:hover {
            color: #7f1d1d;
            background: #fafafa;
        }

        .sidebar-link.active {
            color: #7f1d1d;
            background: #fef2f2;
            box-shadow: inset 3px 0 0 #7f1d1d;
        }

        .mobile-link.active {
            color: #7f1d1d;
        }

        .mobile-link.active .mobile-icon {
            background: #fef2f2;
        }

        .page-section {
            display: none;
        }

        .page-section.active {
            display: block;
        }

        .modal {
            display: none;
        }

        .modal.open {
            display: flex;
        }

        .modal-bg {
            background: rgba(24, 24, 27, .55);
            backdrop-filter: blur(5px);
        }

        .soft-shadow {
            box-shadow: 0 10px 35px rgba(24, 24, 27, .055);
        }

        .table-scroll::-webkit-scrollbar {
            height: 7px;
        }

        .table-scroll::-webkit-scrollbar-thumb {
            background: #d4d4d8;
            border-radius: 99px;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            scrollbar-width: none;
        }
    </style>
</head>

<body class="app-bg antialiased">

@php
    /*
    |--------------------------------------------------------------------------
    | Safe dashboard values
    |--------------------------------------------------------------------------
    | These values work with the variables already used by your current
    | controller. Nothing here requires a new controller variable to render.
    */

    $studentCount = isset($students) && method_exists($students, 'count')
        ? $students->count()
        : 0;

    $routineCount = isset($routines) && method_exists($routines, 'count')
        ? $routines->count()
        : 0;

    $cancelledCount = isset($cancelledClasses) && method_exists($cancelledClasses, 'count')
        ? $cancelledClasses->count()
        : 0;

    $weeklyCount = isset($weeklyClasses) && is_numeric($weeklyClasses)
        ? $weeklyClasses
        : $routineCount;

    $completedCount = isset($completedClasses) && is_numeric($completedClasses)
        ? $completedClasses
        : 0;
@endphp


<!-- =========================================================
     MOBILE OVERLAY
========================================================= -->
<div id="sidebarOverlay"
     class="fixed inset-0 z-40 hidden bg-black/40 lg:hidden"></div>


<!-- =========================================================
     DESKTOP SIDEBAR
========================================================= -->
<aside class="fixed inset-y-0 left-0 z-50 hidden w-[250px] border-r border-zinc-200 bg-white lg:flex lg:flex-col">

    <!-- Logo -->
    <div class="flex h-[76px] items-center border-b border-zinc-100 px-5">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#7f1d1d] text-white">
                <i data-lucide="graduation-cap" class="h-5 w-5"></i>
            </div>

            <div>
                <div class="text-[17px] font-extrabold tracking-tight text-zinc-900">
                    CampusOS
                </div>
                <div class="text-[10px] font-medium text-zinc-400">
                    CR Management Panel
                </div>
            </div>
        </div>
    </div>


    <!-- Navigation -->
    <div class="flex-1 overflow-y-auto px-3 py-5">

        <div class="mb-2 px-3 text-[10px] font-bold uppercase tracking-[.18em] text-zinc-400">
            Main
        </div>

        <nav class="space-y-1">

            <button
                type="button"
                data-section="dashboard"
                class="sidebar-link active flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left text-sm font-semibold">
                <i data-lucide="layout-dashboard" class="h-[18px] w-[18px]"></i>
                Dashboard
            </button>

            <button
                type="button"
                data-section="routine"
                class="sidebar-link flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left text-sm font-semibold">
                <i data-lucide="calendar-days" class="h-[18px] w-[18px]"></i>
                Class Routine
            </button>

            <button
                type="button"
                data-section="students"
                class="sidebar-link flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left text-sm font-semibold">
                <i data-lucide="users" class="h-[18px] w-[18px]"></i>
                Students
            </button>

            <button
                type="button"
                data-section="cancelled"
                class="sidebar-link flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left text-sm font-semibold">
                <i data-lucide="calendar-x-2" class="h-[18px] w-[18px]"></i>
                Cancelled Classes

                @if($cancelledCount > 0)
                    <span class="ml-auto rounded-full bg-red-50 px-2 py-0.5 text-[10px] font-bold text-red-700">
                        {{ $cancelledCount }}
                    </span>
                @endif
            </button>

        </nav>


        <div class="mb-2 mt-8 px-3 text-[10px] font-bold uppercase tracking-[.18em] text-zinc-400">
            Account
        </div>

        <nav class="space-y-1">

            <button
                type="button"
                data-section="settings"
                class="sidebar-link flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left text-sm font-semibold">
                <i data-lucide="settings-2" class="h-[18px] w-[18px]"></i>
                Settings
            </button>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button
                    type="submit"
                    class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left text-sm font-semibold text-zinc-500 transition hover:bg-red-50 hover:text-red-700">
                    <i data-lucide="log-out" class="h-[18px] w-[18px]"></i>
                    Logout
                </button>
            </form>

        </nav>
    </div>


    <!-- User card -->
    <div class="m-4 rounded-2xl bg-[#450a0a] p-4 text-white">

        <div class="mb-3 flex items-center gap-2">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10 text-red-200">
                <i data-lucide="shield-check" class="h-4 w-4"></i>
            </div>

            <div class="text-xs font-bold">
                CR Account
            </div>
        </div>

        <div class="truncate text-sm font-bold">
            {{ Auth::user()->name }}
        </div>

        <div class="mt-1 text-[11px] text-red-200/70">
            Batch {{ $crBatch }}
        </div>
    </div>

</aside>


<!-- =========================================================
     MOBILE SIDEBAR
========================================================= -->
<aside
    id="mobileSidebar"
    class="fixed inset-y-0 left-0 z-50 w-[285px] -translate-x-full border-r border-zinc-200 bg-white shadow-2xl transition-transform duration-300 lg:hidden">

    <div class="flex h-[76px] items-center justify-between border-b border-zinc-100 px-5">

        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#7f1d1d] text-white">
                <i data-lucide="graduation-cap" class="h-5 w-5"></i>
            </div>

            <div>
                <div class="font-extrabold text-zinc-900">
                    CampusOS
                </div>

                <div class="text-[10px] text-zinc-400">
                    CR Management
                </div>
            </div>
        </div>

        <button
            type="button"
            id="closeMobileSidebar"
            class="rounded-xl p-2 text-zinc-500 hover:bg-zinc-100">
            <i data-lucide="x" class="h-5 w-5"></i>
        </button>

    </div>


    <div class="space-y-1 p-3">

        <button type="button" data-section="dashboard"
                class="sidebar-link active flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left text-sm font-semibold">
            <i data-lucide="layout-dashboard" class="h-[18px] w-[18px]"></i>
            Dashboard
        </button>

        <button type="button" data-section="routine"
                class="sidebar-link flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left text-sm font-semibold">
            <i data-lucide="calendar-days" class="h-[18px] w-[18px]"></i>
            Class Routine
        </button>

        <button type="button" data-section="students"
                class="sidebar-link flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left text-sm font-semibold">
            <i data-lucide="users" class="h-[18px] w-[18px]"></i>
            Students
        </button>

        <button type="button" data-section="cancelled"
                class="sidebar-link flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left text-sm font-semibold">
            <i data-lucide="calendar-x-2" class="h-[18px] w-[18px]"></i>
            Cancelled Classes
        </button>

        <button type="button" data-section="settings"
                class="sidebar-link flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left text-sm font-semibold">
            <i data-lucide="settings-2" class="h-[18px] w-[18px]"></i>
            Settings
        </button>

    </div>

</aside>


<!-- =========================================================
     MAIN AREA
========================================================= -->
<div class="lg:pl-[250px]">

    <!-- HEADER -->
    <header class="sticky top-0 z-30 border-b border-zinc-200/80 bg-white/95 backdrop-blur-xl">

        <div class="flex h-[68px] items-center justify-between px-4 sm:px-6 lg:px-8">

            <div class="flex min-w-0 items-center gap-3">

                <button
                    type="button"
                    id="openMobileSidebar"
                    class="rounded-xl border border-zinc-200 bg-white p-2 text-zinc-600 lg:hidden">
                    <i data-lucide="menu" class="h-5 w-5"></i>
                </button>

                <div class="min-w-0">
                    <div id="pageTitle"
                         class="truncate text-lg font-extrabold tracking-tight text-zinc-900 sm:text-xl">
                        Dashboard
                    </div>

                    <div class="hidden text-xs text-zinc-400 sm:block">
                        Batch {{ $crBatch }} · Class management
                    </div>
                </div>

            </div>


            <div class="flex items-center gap-3">

                <div class="hidden text-right sm:block">
                    <div class="text-xs font-bold text-zinc-800">
                        {{ Auth::user()->name }}
                    </div>

                    <div class="mt-0.5 text-[10px] text-zinc-400">
                        CR · Batch {{ $crBatch }}
                    </div>
                </div>

                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-red-50 text-sm font-extrabold text-[#7f1d1d]">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>

            </div>

        </div>

    </header>


    <!-- CONTENT -->
    <main class="mx-auto max-w-[1450px] px-4 pb-28 pt-6 sm:px-6 lg:px-8 lg:pb-10">


        <!-- SUCCESS -->
        @if(session('success'))
            <div class="mb-5 flex items-start gap-3 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">

                <i data-lucide="circle-check" class="mt-0.5 h-5 w-5 shrink-0"></i>

                <div class="text-sm font-medium">
                    {{ session('success') }}
                </div>

            </div>
        @endif


        <!-- ERRORS -->
        @if($errors->any())
            <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-red-800">

                <div class="mb-1 flex items-center gap-2 text-sm font-bold">
                    <i data-lucide="circle-alert" class="h-4 w-4"></i>
                    Please check the following:
                </div>

                <ul class="list-inside list-disc text-xs">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif


        <!-- =====================================================
             DASHBOARD
        ====================================================== -->
        <section id="section-dashboard" class="page-section active">

            <div class="mb-6 flex flex-col justify-between gap-4 md:flex-row md:items-end">

                <div>

                    <div class="mb-2 inline-flex items-center gap-2 rounded-full bg-red-50 px-3 py-1 text-[11px] font-bold text-[#7f1d1d]">
                        <span class="h-1.5 w-1.5 rounded-full bg-[#7f1d1d]"></span>
                        Batch {{ $crBatch }}
                    </div>

                    <h1 class="text-2xl font-black tracking-tight text-zinc-950 sm:text-3xl">
                        Welcome, {{ Auth::user()->name }}
                    </h1>

                    <p class="mt-1 text-sm text-zinc-500">
                        Manage your class routine and students from one place.
                    </p>

                </div>


                <div class="flex flex-wrap gap-2">

                    <button
                        type="button"
                        onclick="openModal('routineModal')"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#7f1d1d] px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-red-900/10 transition hover:bg-[#691616]">
                        <i data-lucide="plus" class="h-4 w-4"></i>
                        Add Class
                    </button>

                    <button
                        type="button"
                        onclick="openModal('studentModal')"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-bold text-zinc-700 shadow-sm transition hover:bg-zinc-50">
                        <i data-lucide="user-plus" class="h-4 w-4"></i>
                        Add Student
                    </button>

                </div>

            </div>


            <!-- STAT CARDS -->
            <div class="grid grid-cols-2 gap-3 lg:grid-cols-4">

                <!-- Students -->
                <div class="rounded-2xl border border-zinc-200 bg-white p-4 soft-shadow sm:p-5">

                    <div class="mb-5 flex items-center justify-between">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 text-[#7f1d1d]">
                            <i data-lucide="users" class="h-5 w-5"></i>
                        </div>

                        <span class="text-[10px] font-bold uppercase tracking-wider text-zinc-400">
                            Students
                        </span>
                    </div>

                    <div class="text-2xl font-black text-zinc-950 sm:text-3xl">
                        {{ $studentCount }}
                    </div>

                    <div class="mt-1 text-xs text-zinc-400">
                        Total students
                    </div>

                </div>


                <!-- Weekly -->
                <div class="rounded-2xl border border-zinc-200 bg-white p-4 soft-shadow sm:p-5">

                    <div class="mb-5 flex items-center justify-between">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 text-[#7f1d1d]">
                            <i data-lucide="calendar-check-2" class="h-5 w-5"></i>
                        </div>

                        <span class="text-[10px] font-bold uppercase tracking-wider text-zinc-400">
                            Weekly
                        </span>
                    </div>

                    <div class="text-2xl font-black text-zinc-950 sm:text-3xl">
                        {{ $weeklyCount }}
                    </div>

                    <div class="mt-1 text-xs text-zinc-400">
                        Weekly classes
                    </div>

                </div>


                <!-- Cancelled -->
                <div class="rounded-2xl border border-zinc-200 bg-white p-4 soft-shadow sm:p-5">

                    <div class="mb-5 flex items-center justify-between">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 text-red-700">
                            <i data-lucide="calendar-x-2" class="h-5 w-5"></i>
                        </div>

                        <span class="text-[10px] font-bold uppercase tracking-wider text-zinc-400">
                            Cancelled
                        </span>
                    </div>

                    <div class="text-2xl font-black text-zinc-950 sm:text-3xl">
                        {{ $cancelledCount }}
                    </div>

                    <div class="mt-1 text-xs text-zinc-400">
                        Cancelled classes
                    </div>

                </div>


                <!-- Completed -->
                <div class="rounded-2xl border border-zinc-200 bg-white p-4 soft-shadow sm:p-5">

                    <div class="mb-5 flex items-center justify-between">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 text-[#7f1d1d]">
                            <i data-lucide="check-check" class="h-5 w-5"></i>
                        </div>

                        <span class="text-[10px] font-bold uppercase tracking-wider text-zinc-400">
                            Completed
                        </span>
                    </div>

                    <div class="text-2xl font-black text-zinc-950 sm:text-3xl">
                        {{ $completedCount }}
                    </div>

                    <div class="mt-1 text-xs text-zinc-400">
                        Completed classes
                    </div>

                </div>

            </div>


            <!-- LOWER DASHBOARD -->
            <div class="mt-5 grid gap-5 xl:grid-cols-[1.5fr_.8fr]">


                <!-- ROUTINE PREVIEW -->
                <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white soft-shadow">

                    <div class="flex items-center justify-between border-b border-zinc-100 px-5 py-4">

                        <div>
                            <h2 class="font-extrabold text-zinc-900">
                                Class Routine
                            </h2>

                            <p class="mt-0.5 text-xs text-zinc-400">
                                Current weekly schedule
                            </p>
                        </div>

                        <button
                            type="button"
                            data-section="routine"
                            class="rounded-lg px-3 py-2 text-xs font-bold text-[#7f1d1d] hover:bg-red-50">
                            View all
                        </button>

                    </div>


                    <div class="divide-y divide-zinc-100">

                        @if(isset($routines) && $routines->count() > 0)

                            @foreach($routines->take(6) as $routine)

                                <div class="flex items-center gap-3 px-5 py-4 transition hover:bg-zinc-50">

                                    <div class="hidden h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-zinc-100 text-zinc-600 sm:flex">
                                        <i data-lucide="book-open" class="h-4 w-4"></i>
                                    </div>

                                    <div class="min-w-0 flex-1">

                                        <div class="truncate text-sm font-bold text-zinc-900">
                                            {{ $routine->course_title }}
                                        </div>

                                        <div class="mt-1 flex flex-wrap gap-x-3 gap-y-1 text-[11px] text-zinc-400">
                                            <span>{{ $routine->course_code }}</span>
                                            <span>{{ $routine->course_teacher }}</span>
                                            <span>{{ $routine->room }}</span>
                                        </div>

                                    </div>

                                    <div class="text-right">

                                        <div class="text-xs font-bold text-zinc-800">
                                            {{ $routine->day }}
                                        </div>

                                        <div class="mt-1 text-[11px] text-zinc-400">
                                            {{ $routine->class_time }}
                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        @else

                            <div class="px-5 py-12 text-center">

                                <i data-lucide="calendar-plus-2" class="mx-auto h-8 w-8 text-zinc-300"></i>

                                <p class="mt-3 text-sm font-semibold text-zinc-500">
                                    No classes added yet.
                                </p>

                                <button
                                    type="button"
                                    onclick="openModal('routineModal')"
                                    class="mt-3 text-xs font-bold text-[#7f1d1d]">
                                    Add your first class
                                </button>

                            </div>

                        @endif

                    </div>

                </div>


                <!-- QUICK ACTIONS -->
                <div class="space-y-5">

                    <div class="rounded-2xl bg-[#450a0a] p-5 text-white shadow-lg shadow-red-950/10">

                        <div class="flex items-start justify-between">

                            <div>
                                <div class="text-[10px] font-bold uppercase tracking-[.16em] text-red-200">
                                    Quick actions
                                </div>

                                <h3 class="mt-1 text-lg font-extrabold">
                                    Manage your batch
                                </h3>
                            </div>

                            <div class="rounded-xl bg-white/10 p-2">
                                <i data-lucide="zap" class="h-5 w-5 text-red-200"></i>
                            </div>

                        </div>


                        <div class="mt-5 grid grid-cols-2 gap-2">

                            <button
                                type="button"
                                onclick="openModal('routineModal')"
                                class="rounded-xl bg-white/10 px-3 py-3 text-left transition hover:bg-white/15">
                                <i data-lucide="calendar-plus" class="h-4 w-4 text-red-200"></i>
                                <div class="mt-2 text-xs font-bold">
                                    Add class
                                </div>
                            </button>

                            <button
                                type="button"
                                onclick="openModal('studentModal')"
                                class="rounded-xl bg-white/10 px-3 py-3 text-left transition hover:bg-white/15">
                                <i data-lucide="user-plus" class="h-4 w-4 text-red-200"></i>
                                <div class="mt-2 text-xs font-bold">
                                    Add student
                                </div>
                            </button>

                            <button
                                type="button"
                                data-section="cancelled"
                                class="rounded-xl bg-white/10 px-3 py-3 text-left transition hover:bg-white/15">
                                <i data-lucide="calendar-x" class="h-4 w-4 text-red-200"></i>
                                <div class="mt-2 text-xs font-bold">
                                    Cancelled
                                </div>
                            </button>

                            <button
                                type="button"
                                data-section="students"
                                class="rounded-xl bg-white/10 px-3 py-3 text-left transition hover:bg-white/15">
                                <i data-lucide="users-round" class="h-4 w-4 text-red-200"></i>
                                <div class="mt-2 text-xs font-bold">
                                    Students
                                </div>
                            </button>

                        </div>

                    </div>


                    <!-- RECENT CANCELLATIONS -->
                    <div class="rounded-2xl border border-zinc-200 bg-white p-5 soft-shadow">

                        <div class="flex items-center justify-between">

                            <div>
                                <h3 class="font-extrabold text-zinc-900">
                                    Recent cancellations
                                </h3>

                                <p class="mt-1 text-xs text-zinc-400">
                                    Latest cancelled classes
                                </p>
                            </div>

                            <span class="rounded-full bg-red-50 px-2.5 py-1 text-[10px] font-bold text-red-700">
                                {{ $cancelledCount }}
                            </span>

                        </div>


                        <div class="mt-4 space-y-3">

                            @if(isset($cancelledClasses) && $cancelledClasses->count() > 0)

                                @foreach($cancelledClasses->take(3) as $cancel)

                                    <div class="flex items-center gap-3 rounded-xl bg-zinc-50 p-3">

                                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-red-50 text-red-700">
                                            <i data-lucide="calendar-off" class="h-4 w-4"></i>
                                        </div>

                                        <div class="min-w-0">
                                            <div class="truncate text-xs font-bold text-zinc-800">
                                                {{ $cancel->routine->course_title ?? 'N/A' }}
                                            </div>

                                            <div class="mt-0.5 text-[10px] text-zinc-400">
                                                {{ $cancel->cancelled_date }}
                                            </div>
                                        </div>

                                    </div>

                                @endforeach

                            @else

                                <div class="py-5 text-center text-xs text-zinc-400">
                                    No cancelled classes.
                                </div>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </section>


        <!-- =====================================================
             ROUTINE PAGE
        ====================================================== -->
        <section id="section-routine" class="page-section">

            <div class="mb-5 flex flex-col justify-between gap-3 sm:flex-row sm:items-end">

                <div>
                    <h1 class="text-2xl font-black tracking-tight text-zinc-950">
                        Class Routine
                    </h1>

                    <p class="mt-1 text-sm text-zinc-500">
                        Add, edit, delete and cancel classes for specific dates.
                    </p>
                </div>

                <button
                    type="button"
                    onclick="openModal('routineModal')"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#7f1d1d] px-4 py-2.5 text-sm font-bold text-white hover:bg-[#691616]">
                    <i data-lucide="plus" class="h-4 w-4"></i>
                    Add Class
                </button>

            </div>


            <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white soft-shadow">

                <div class="table-scroll overflow-x-auto">

                    <table class="w-full min-w-[950px]">

                        <thead class="border-b border-zinc-100 bg-zinc-50">

                            <tr class="text-left text-[10px] font-bold uppercase tracking-wider text-zinc-400">

                                <th class="px-5 py-4">
                                    Day & Time
                                </th>

                                <th class="px-5 py-4">
                                    Course
                                </th>

                                <th class="px-5 py-4">
                                    Teacher / Room
                                </th>

                                <th class="px-5 py-4">
                                    Cancel Date
                                </th>

                                <th class="px-5 py-4 text-right">
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-zinc-100">

                        @if(isset($routines) && $routines->count() > 0)

                            @foreach($routines as $routine)

                                <tr class="transition hover:bg-zinc-50">

                                    <td class="px-5 py-4">

                                        <div class="font-bold text-zinc-800">
                                            {{ $routine->day }}
                                        </div>

                                        <div class="mt-1 text-xs text-zinc-400">
                                            {{ $routine->class_time }}
                                        </div>

                                    </td>


                                    <td class="px-5 py-4">

                                        <div class="font-bold text-zinc-800">
                                            {{ $routine->course_title }}
                                        </div>

                                        <div class="mt-1 text-xs text-zinc-400">
                                            {{ $routine->course_code }}
                                        </div>

                                    </td>


                                    <td class="px-5 py-4">

                                        <div class="text-sm font-medium text-zinc-700">
                                            {{ $routine->course_teacher }}
                                        </div>

                                        <div class="mt-1 text-xs text-zinc-400">
                                            {{ $routine->room }}
                                        </div>

                                    </td>


                                    <td class="px-5 py-4">

                                        <form
                                            action="{{ route('cr.routine.cancel.date', $routine->id) }}"
                                            method="POST"
                                            class="flex items-center gap-2">

                                            @csrf

                                            <input
                                                type="date"
                                                name="cancelled_date"
                                                required
                                                class="w-[145px] rounded-lg border border-zinc-200 bg-white px-2.5 py-2 text-xs text-zinc-700 outline-none focus:border-red-800">

                                            <button
                                                type="submit"
                                                class="rounded-lg bg-red-50 px-3 py-2 text-xs font-bold text-red-700 hover:bg-red-100">
                                                Cancel
                                            </button>

                                        </form>

                                    </td>


                                    <td class="px-5 py-4">

                                        <div class="flex justify-end gap-2">

                                            <button
                                                type="button"
                                                onclick="toggleEdit('{{ $routine->id }}')"
                                                class="rounded-lg bg-zinc-100 px-3 py-2 text-xs font-bold text-zinc-700 hover:bg-zinc-200">
                                                Edit
                                            </button>


                                            <form
                                                action="{{ route('cr.routine.delete', $routine->id) }}"
                                                method="POST">

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this routine?')"
                                                    class="rounded-lg bg-red-50 px-3 py-2 text-xs font-bold text-red-700 hover:bg-red-100">
                                                    Delete
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>


                                <!-- EDIT ROW -->
                                <tr
                                    id="edit-form-{{ $routine->id }}"
                                    class="hidden bg-zinc-50">

                                    <td colspan="5" class="px-5 py-5">

                                        <form
                                            action="{{ route('cr.routine.update', $routine->id) }}"
                                            method="POST"
                                            class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-6">

                                            @csrf
                                            @method('PUT')

                                            <input
                                                type="text"
                                                name="day"
                                                value="{{ $routine->day }}"
                                                required
                                                placeholder="Day"
                                                class="rounded-lg border border-zinc-200 px-3 py-2 text-sm">

                                            <input
                                                type="text"
                                                name="course_title"
                                                value="{{ $routine->course_title }}"
                                                required
                                                placeholder="Course title"
                                                class="rounded-lg border border-zinc-200 px-3 py-2 text-sm">

                                            <input
                                                type="text"
                                                name="course_code"
                                                value="{{ $routine->course_code }}"
                                                required
                                                placeholder="Course code"
                                                class="rounded-lg border border-zinc-200 px-3 py-2 text-sm">

                                            <input
                                                type="text"
                                                name="course_teacher"
                                                value="{{ $routine->course_teacher }}"
                                                required
                                                placeholder="Teacher"
                                                class="rounded-lg border border-zinc-200 px-3 py-2 text-sm">

                                            <input
                                                type="text"
                                                name="room"
                                                value="{{ $routine->room }}"
                                                required
                                                placeholder="Room"
                                                class="rounded-lg border border-zinc-200 px-3 py-2 text-sm">

                                            <input
                                                type="text"
                                                name="class_time"
                                                value="{{ $routine->class_time }}"
                                                required
                                                placeholder="Time"
                                                class="rounded-lg border border-zinc-200 px-3 py-2 text-sm">


                                            <div class="flex justify-end gap-2 sm:col-span-2 lg:col-span-6">

                                                <button
                                                    type="button"
                                                    onclick="toggleEdit('{{ $routine->id }}')"
                                                    class="rounded-lg border border-zinc-200 bg-white px-4 py-2 text-xs font-bold text-zinc-600">
                                                    Close
                                                </button>

                                                <button
                                                    type="submit"
                                                    class="rounded-lg bg-[#7f1d1d] px-4 py-2 text-xs font-bold text-white hover:bg-[#691616]">
                                                    Save Changes
                                                </button>

                                            </div>

                                        </form>

                                    </td>

                                </tr>

                            @endforeach

                        @else

                            <tr>
                                <td colspan="5" class="px-5 py-14 text-center">

                                    <i data-lucide="calendar-plus-2" class="mx-auto h-9 w-9 text-zinc-300"></i>

                                    <p class="mt-3 text-sm font-bold text-zinc-500">
                                        No routines added yet.
                                    </p>

                                    <button
                                        type="button"
                                        onclick="openModal('routineModal')"
                                        class="mt-3 text-xs font-bold text-[#7f1d1d]">
                                        Add Class
                                    </button>

                                </td>
                            </tr>

                        @endif

                        </tbody>

                    </table>

                </div>

            </div>

        </section>


        <!-- =====================================================
             STUDENTS PAGE
        ====================================================== -->
        <section id="section-students" class="page-section">

            <div class="mb-5 flex flex-col justify-between gap-3 sm:flex-row sm:items-end">

                <div>
                    <h1 class="text-2xl font-black tracking-tight text-zinc-950">
                        Students
                    </h1>

                    <p class="mt-1 text-sm text-zinc-500">
                        Manage student accounts for Batch {{ $crBatch }}.
                    </p>
                </div>

                <button
                    type="button"
                    onclick="openModal('studentModal')"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#7f1d1d] px-4 py-2.5 text-sm font-bold text-white hover:bg-[#691616]">
                    <i data-lucide="user-plus" class="h-4 w-4"></i>
                    Add Student
                </button>

            </div>


            <!-- Student summary -->
            <div class="mb-5 grid grid-cols-2 gap-3 sm:grid-cols-3">

                <div class="rounded-2xl border border-zinc-200 bg-white p-4 soft-shadow">
                    <div class="text-xs font-bold text-zinc-400">
                        Total Students
                    </div>

                    <div class="mt-1 text-2xl font-black text-zinc-950">
                        {{ $studentCount }}
                    </div>
                </div>


                <div class="rounded-2xl border border-zinc-200 bg-white p-4 soft-shadow">
                    <div class="text-xs font-bold text-zinc-400">
                        Batch
                    </div>

                    <div class="mt-1 text-2xl font-black text-zinc-950">
                        {{ $crBatch }}
                    </div>
                </div>


                <div class="col-span-2 rounded-2xl border border-zinc-200 bg-white p-4 soft-shadow sm:col-span-1">
                    <div class="text-xs font-bold text-zinc-400">
                        Account Access
                    </div>

                    <div class="mt-1 text-sm font-black text-[#7f1d1d]">
                        Student Accounts
                    </div>
                </div>

            </div>


            <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white soft-shadow">

                <div class="border-b border-zinc-100 p-4 sm:p-5">

                    <div class="relative">

                        <i
                            data-lucide="search"
                            class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-zinc-400">
                        </i>

                        <input
                            id="studentSearch"
                            type="text"
                            placeholder="Search student name, ID or department..."
                            class="w-full rounded-xl border border-zinc-200 py-2.5 pl-9 pr-3 text-sm outline-none focus:border-red-800">

                    </div>

                </div>


                <div class="table-scroll overflow-x-auto">

                    <table class="w-full min-w-[750px]">

                        <thead class="border-b border-zinc-100 bg-zinc-50">

                            <tr class="text-left text-[10px] font-bold uppercase tracking-wider text-zinc-400">

                                <th class="px-5 py-4">
                                    Student
                                </th>

                                <th class="px-5 py-4">
                                    Student ID
                                </th>

                                <th class="px-5 py-4">
                                    Department
                                </th>

                                <th class="px-5 py-4">
                                    Contact
                                </th>

                            </tr>

                        </thead>


                        <tbody id="studentTable" class="divide-y divide-zinc-100">

                        @if(isset($students) && $students->count() > 0)

                            @foreach($students as $student)

                                <tr class="student-row transition hover:bg-zinc-50">

                                    <td class="px-5 py-4">

                                        <div class="flex items-center gap-3">

                                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-red-50 text-xs font-black text-[#7f1d1d]">
                                                {{ strtoupper(substr($student->name, 0, 1)) }}
                                            </div>

                                            <div class="min-w-0">

                                                <div class="student-search-text truncate font-bold text-zinc-800">
                                                    {{ $student->name }}
                                                </div>

                                                <div class="truncate text-[11px] text-zinc-400">
                                                    {{ $student->email }}
                                                </div>

                                            </div>

                                        </div>

                                    </td>


                                    <td class="student-search-text px-5 py-4 text-sm font-semibold text-zinc-700">
                                        {{ $student->student_id }}
                                    </td>


                                    <td class="student-search-text px-5 py-4 text-sm text-zinc-600">
                                        {{ $student->department }}
                                    </td>


                                    <td class="px-5 py-4 text-sm text-zinc-500">
                                        {{ $student->mobile_number }}
                                    </td>

                                </tr>

                            @endforeach

                        @else

                            <tr>
                                <td colspan="4" class="px-5 py-14 text-center text-sm text-zinc-400">
                                    No students found in this batch.
                                </td>
                            </tr>

                        @endif

                        </tbody>

                    </table>

                </div>

            </div>

        </section>


        <!-- =====================================================
             CANCELLED PAGE
        ====================================================== -->
        <section id="section-cancelled" class="page-section">

            <div class="mb-5">

                <h1 class="text-2xl font-black tracking-tight text-zinc-950">
                    Cancelled Classes
                </h1>

                <p class="mt-1 text-sm text-zinc-500">
                    Review cancelled class dates and restore them when needed.
                </p>

            </div>


            <div class="mb-5 rounded-2xl border border-red-100 bg-red-50 p-4">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-red-700 shadow-sm">
                        <i data-lucide="calendar-x-2" class="h-5 w-5"></i>
                    </div>

                    <div>

                        <div class="text-sm font-extrabold text-red-800">
                            {{ $cancelledCount }} cancelled record(s)
                        </div>

                        <div class="text-xs text-red-700/60">
                            The weekly routine remains unchanged.
                        </div>

                    </div>

                </div>

            </div>


            <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white soft-shadow">

                <div class="table-scroll overflow-x-auto">

                    <table class="w-full min-w-[750px]">

                        <thead class="border-b border-zinc-100 bg-zinc-50">

                            <tr class="text-left text-[10px] font-bold uppercase tracking-wider text-zinc-400">

                                <th class="px-5 py-4">
                                    Cancelled Date
                                </th>

                                <th class="px-5 py-4">
                                    Course
                                </th>

                                <th class="px-5 py-4">
                                    Original Schedule
                                </th>

                                <th class="px-5 py-4 text-right">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-zinc-100">

                        @if(isset($cancelledClasses) && $cancelledClasses->count() > 0)

                            @foreach($cancelledClasses as $cancel)

                                <tr class="transition hover:bg-zinc-50">

                                    <td class="px-5 py-4">

                                        <span class="inline-flex rounded-lg bg-red-50 px-2.5 py-1.5 text-xs font-bold text-red-700">
                                            {{ $cancel->cancelled_date }}
                                        </span>

                                    </td>


                                    <td class="px-5 py-4">

                                        <div class="font-bold text-zinc-800">
                                            {{ $cancel->routine->course_title ?? 'N/A' }}
                                        </div>

                                        <div class="mt-1 text-xs text-zinc-400">
                                            {{ $cancel->routine->course_code ?? 'N/A' }}
                                        </div>

                                    </td>


                                    <td class="px-5 py-4">

                                        <div class="text-sm font-semibold text-zinc-700">
                                            {{ $cancel->routine->day ?? 'N/A' }}
                                        </div>

                                        <div class="mt-1 text-xs text-zinc-400">
                                            {{ $cancel->routine->class_time ?? 'N/A' }}
                                        </div>

                                    </td>


                                    <td class="px-5 py-4 text-right">

                                        <form
                                            action="{{ route('cr.routine.cancel.date', $cancel->class_routine_id) }}"
                                            method="POST">

                                            @csrf

                                            <input
                                                type="hidden"
                                                name="cancelled_date"
                                                value="{{ $cancel->cancelled_date }}">

                                            <button
                                                type="submit"
                                                class="rounded-lg bg-red-50 px-3 py-2 text-xs font-bold text-[#7f1d1d] hover:bg-red-100">
                                                Restore Class
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @endforeach

                        @else

                            <tr>

                                <td colspan="4" class="px-5 py-14 text-center">

                                    <i data-lucide="calendar-check-2" class="mx-auto h-9 w-9 text-zinc-300"></i>

                                    <p class="mt-3 text-sm font-bold text-zinc-500">
                                        No cancelled classes.
                                    </p>

                                    <p class="mt-1 text-xs text-zinc-400">
                                        Your batch schedule is clear.
                                    </p>

                                </td>

                            </tr>

                        @endif

                        </tbody>

                    </table>

                </div>

            </div>

        </section>


        <!-- =====================================================
             SETTINGS PAGE
        ====================================================== -->
        <section id="section-settings" class="page-section">

            <div class="mb-5">

                <h1 class="text-2xl font-black tracking-tight text-zinc-950">
                    Settings
                </h1>

                <p class="mt-1 text-sm text-zinc-500">
                    Account and batch information.
                </p>

            </div>


            <div class="grid gap-5 lg:grid-cols-2">

                <!-- Account -->
                <div class="rounded-2xl border border-zinc-200 bg-white p-5 soft-shadow">

                    <div class="mb-5 flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 text-[#7f1d1d]">
                            <i data-lucide="user-cog" class="h-5 w-5"></i>
                        </div>

                        <div>
                            <h2 class="font-extrabold text-zinc-900">
                                CR Account
                            </h2>

                            <p class="text-xs text-zinc-400">
                                Current signed-in account
                            </p>
                        </div>

                    </div>


                    <div class="space-y-3">

                        <div class="rounded-xl bg-zinc-50 p-3">

                            <div class="text-[10px] font-bold uppercase text-zinc-400">
                                Name
                            </div>

                            <div class="mt-1 text-sm font-bold text-zinc-800">
                                {{ Auth::user()->name }}
                            </div>

                        </div>


                        <div class="rounded-xl bg-zinc-50 p-3">

                            <div class="text-[10px] font-bold uppercase text-zinc-400">
                                Batch
                            </div>

                            <div class="mt-1 text-sm font-bold text-zinc-800">
                                {{ $crBatch }}
                            </div>

                        </div>

                    </div>

                </div>


                <!-- Summary -->
                <div class="rounded-2xl border border-zinc-200 bg-white p-5 soft-shadow">

                    <div class="mb-5 flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 text-[#7f1d1d]">
                            <i data-lucide="bar-chart-3" class="h-5 w-5"></i>
                        </div>

                        <div>
                            <h2 class="font-extrabold text-zinc-900">
                                Batch Summary
                            </h2>

                            <p class="text-xs text-zinc-400">
                                Current dashboard data
                            </p>
                        </div>

                    </div>


                    <div class="grid grid-cols-2 gap-3">

                        <div class="rounded-xl border border-zinc-100 p-3">
                            <div class="text-[10px] font-bold uppercase text-zinc-400">
                                Students
                            </div>
                            <div class="mt-1 text-xl font-black">
                                {{ $studentCount }}
                            </div>
                        </div>

                        <div class="rounded-xl border border-zinc-100 p-3">
                            <div class="text-[10px] font-bold uppercase text-zinc-400">
                                Weekly Classes
                            </div>
                            <div class="mt-1 text-xl font-black">
                                {{ $weeklyCount }}
                            </div>
                        </div>

                        <div class="rounded-xl border border-zinc-100 p-3">
                            <div class="text-[10px] font-bold uppercase text-zinc-400">
                                Cancelled
                            </div>
                            <div class="mt-1 text-xl font-black text-red-700">
                                {{ $cancelledCount }}
                            </div>
                        </div>

                        <div class="rounded-xl border border-zinc-100 p-3">
                            <div class="text-[10px] font-bold uppercase text-zinc-400">
                                Completed
                            </div>
                            <div class="mt-1 text-xl font-black text-[#7f1d1d]">
                                {{ $completedCount }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </section>

    </main>

</div>


<!-- =========================================================
     MOBILE BOTTOM NAVIGATION
========================================================= -->
<nav class="fixed bottom-0 left-0 right-0 z-40 border-t border-zinc-200 bg-white/95 px-2 pb-[max(8px,env(safe-area-inset-bottom))] pt-2 backdrop-blur-xl lg:hidden">

    <div class="mx-auto grid max-w-lg grid-cols-4 gap-1">

        <button
            type="button"
            data-section="dashboard"
            class="mobile-link active flex flex-col items-center gap-1 rounded-xl py-1.5 text-zinc-400">

            <span class="mobile-icon flex h-8 w-10 items-center justify-center rounded-xl">
                <i data-lucide="layout-dashboard" class="h-[18px] w-[18px]"></i>
            </span>

            <span class="text-[10px] font-bold">
                Home
            </span>

        </button>


        <button
            type="button"
            data-section="routine"
            class="mobile-link flex flex-col items-center gap-1 rounded-xl py-1.5 text-zinc-400">

            <span class="mobile-icon flex h-8 w-10 items-center justify-center rounded-xl">
                <i data-lucide="calendar-days" class="h-[18px] w-[18px]"></i>
            </span>

            <span class="text-[10px] font-bold">
                Routine
            </span>

        </button>


        <button
            type="button"
            data-section="students"
            class="mobile-link flex flex-col items-center gap-1 rounded-xl py-1.5 text-zinc-400">

            <span class="mobile-icon flex h-8 w-10 items-center justify-center rounded-xl">
                <i data-lucide="users" class="h-[18px] w-[18px]"></i>
            </span>

            <span class="text-[10px] font-bold">
                Students
            </span>

        </button>


        <button
            type="button"
            data-section="cancelled"
            class="mobile-link flex flex-col items-center gap-1 rounded-xl py-1.5 text-zinc-400">

            <span class="mobile-icon flex h-8 w-10 items-center justify-center rounded-xl">
                <i data-lucide="calendar-x-2" class="h-[18px] w-[18px]"></i>
            </span>

            <span class="text-[10px] font-bold">
                Cancelled
            </span>

        </button>

    </div>

</nav>


<!-- =========================================================
     ADD ROUTINE MODAL
========================================================= -->
<div id="routineModal" class="modal modal-bg fixed inset-0 z-[70] items-center justify-center p-4">

    <div class="max-h-[92vh] w-full max-w-2xl overflow-y-auto rounded-3xl bg-white shadow-2xl">

        <div class="flex items-center justify-between border-b border-zinc-100 px-5 py-4">

            <div>
                <h2 class="font-extrabold text-zinc-900">
                    Add Class Routine
                </h2>

                <p class="mt-0.5 text-xs text-zinc-400">
                    Add a weekly class for Batch {{ $crBatch }}
                </p>
            </div>

            <button
                type="button"
                onclick="closeModal('routineModal')"
                class="rounded-xl p-2 text-zinc-400 hover:bg-zinc-100">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>

        </div>


        <form
            action="{{ route('cr.routine.store') }}"
            method="POST"
            class="grid grid-cols-1 gap-4 p-5 sm:grid-cols-2">

            @csrf


            <div>
                <label class="mb-1.5 block text-xs font-bold text-zinc-600">
                    Day
                </label>

                <select
                    name="day"
                    required
                    class="w-full rounded-xl border border-zinc-200 px-3 py-2.5 text-sm outline-none focus:border-red-800">

                    @foreach(['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day)
                        <option value="{{ $day }}">
                            {{ $day }}
                        </option>
                    @endforeach

                </select>
            </div>


            <div>
                <label class="mb-1.5 block text-xs font-bold text-zinc-600">
                    Course Title
                </label>

                <input
                    type="text"
                    name="course_title"
                    required
                    placeholder="e.g. Data Structures"
                    class="w-full rounded-xl border border-zinc-200 px-3 py-2.5 text-sm outline-none focus:border-red-800">
            </div>


            <div>
                <label class="mb-1.5 block text-xs font-bold text-zinc-600">
                    Course Code
                </label>

                <input
                    type="text"
                    name="course_code"
                    required
                    placeholder="e.g. CSE 2101"
                    class="w-full rounded-xl border border-zinc-200 px-3 py-2.5 text-sm outline-none focus:border-red-800">
            </div>


            <div>
                <label class="mb-1.5 block text-xs font-bold text-zinc-600">
                    Course Teacher
                </label>

                <input
                    type="text"
                    name="course_teacher"
                    required
                    placeholder="Teacher name"
                    class="w-full rounded-xl border border-zinc-200 px-3 py-2.5 text-sm outline-none focus:border-red-800">
            </div>


            <div>
                <label class="mb-1.5 block text-xs font-bold text-zinc-600">
                    Room
                </label>

                <input
                    type="text"
                    name="room"
                    required
                    placeholder="Room 402"
                    class="w-full rounded-xl border border-zinc-200 px-3 py-2.5 text-sm outline-none focus:border-red-800">
            </div>


            <div>
                <label class="mb-1.5 block text-xs font-bold text-zinc-600">
                    Class Time
                </label>

                <input
                    type="text"
                    name="class_time"
                    required
                    placeholder="9:00 AM - 10:30 AM"
                    class="w-full rounded-xl border border-zinc-200 px-3 py-2.5 text-sm outline-none focus:border-red-800">
            </div>


            <div class="flex justify-end gap-2 sm:col-span-2">

                <button
                    type="button"
                    onclick="closeModal('routineModal')"
                    class="rounded-xl border border-zinc-200 px-4 py-2.5 text-sm font-bold text-zinc-600 hover:bg-zinc-50">
                    Cancel
                </button>

                <button
                    type="submit"
                    class="rounded-xl bg-[#7f1d1d] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#691616]">
                    Add Class
                </button>

            </div>

        </form>

    </div>

</div>


<!-- =========================================================
     ADD STUDENT MODAL
========================================================= -->
<div id="studentModal" class="modal modal-bg fixed inset-0 z-[70] items-center justify-center p-4">

    <div class="max-h-[92vh] w-full max-w-2xl overflow-y-auto rounded-3xl bg-white shadow-2xl">

        <div class="flex items-center justify-between border-b border-zinc-100 px-5 py-4">

            <div>
                <h2 class="font-extrabold text-zinc-900">
                    Add Student
                </h2>

                <p class="mt-0.5 text-xs text-zinc-400">
                    Create a student account for Batch {{ $crBatch }}
                </p>
            </div>

            <button
                type="button"
                onclick="closeModal('studentModal')"
                class="rounded-xl p-2 text-zinc-400 hover:bg-zinc-100">
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>

        </div>


        <form
            action="{{ route('cr.user.store') }}"
            method="POST"
            class="grid grid-cols-1 gap-4 p-5 sm:grid-cols-2">

            @csrf


            <div>
                <label class="mb-1.5 block text-xs font-bold text-zinc-600">
                    Full Name
                </label>

                <input
                    type="text"
                    name="name"
                    required
                    class="w-full rounded-xl border border-zinc-200 px-3 py-2.5 text-sm outline-none focus:border-red-800">
            </div>


            <div>
                <label class="mb-1.5 block text-xs font-bold text-zinc-600">
                    Email Address
                </label>

                <input
                    type="email"
                    name="email"
                    required
                    class="w-full rounded-xl border border-zinc-200 px-3 py-2.5 text-sm outline-none focus:border-red-800">
            </div>


            <div>
                <label class="mb-1.5 block text-xs font-bold text-zinc-600">
                    Mobile Number
                </label>

                <input
                    type="text"
                    name="mobile_number"
                    required
                    class="w-full rounded-xl border border-zinc-200 px-3 py-2.5 text-sm outline-none focus:border-red-800">
            </div>


            <div>
                <label class="mb-1.5 block text-xs font-bold text-zinc-600">
                    Student ID
                </label>

                <input
                    type="text"
                    name="student_id"
                    required
                    class="w-full rounded-xl border border-zinc-200 px-3 py-2.5 text-sm outline-none focus:border-red-800">
            </div>


            <div>
                <label class="mb-1.5 block text-xs font-bold text-zinc-600">
                    Department
                </label>

                <input
                    type="text"
                    name="department"
                    required
                    class="w-full rounded-xl border border-zinc-200 px-3 py-2.5 text-sm outline-none focus:border-red-800">
            </div>


            <div>
                <label class="mb-1.5 block text-xs font-bold text-zinc-600">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    required
                    class="w-full rounded-xl border border-zinc-200 px-3 py-2.5 text-sm outline-none focus:border-red-800">
            </div>


            <div class="flex justify-end gap-2 sm:col-span-2">

                <button
                    type="button"
                    onclick="closeModal('studentModal')"
                    class="rounded-xl border border-zinc-200 px-4 py-2.5 text-sm font-bold text-zinc-600 hover:bg-zinc-50">
                    Cancel
                </button>

                <button
                    type="submit"
                    class="rounded-xl bg-[#7f1d1d] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#691616]">
                    Create Student
                </button>

            </div>

        </form>

    </div>

</div>


<!-- =========================================================
     JAVASCRIPT
========================================================= -->
<script>

    /*
    |--------------------------------------------------------------------------
    | Icons
    |--------------------------------------------------------------------------
    */
    if (window.lucide) {
        lucide.createIcons();
    }


    /*
    |--------------------------------------------------------------------------
    | Page navigation
    |--------------------------------------------------------------------------
    */

    const pageTitles = {
        dashboard: 'Dashboard',
        routine: 'Class Routine',
        students: 'Students',
        cancelled: 'Cancelled Classes',
        settings: 'Settings'
    };


    function showSection(section) {

        document.querySelectorAll('.page-section').forEach(function(page) {

            if (page.id === 'section-' + section) {
                page.classList.add('active');
            } else {
                page.classList.remove('active');
            }

        });


        document.querySelectorAll('[data-section]').forEach(function(item) {

            if (item.dataset.section === section) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }

        });


        const title = document.getElementById('pageTitle');

        if (title) {
            title.textContent = pageTitles[section] || 'Dashboard';
        }


        closeMobileSidebar();


        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });

    }


    document.querySelectorAll('[data-section]').forEach(function(button) {

        button.addEventListener('click', function() {

            showSection(this.dataset.section);

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Edit routine
    |--------------------------------------------------------------------------
    */

    function toggleEdit(id) {

        const row = document.getElementById('edit-form-' + id);

        if (!row) {
            return;
        }

        row.classList.toggle('hidden');

    }


    /*
    |--------------------------------------------------------------------------
    | Modals
    |--------------------------------------------------------------------------
    */

    function openModal(id) {

        const modal = document.getElementById(id);

        if (!modal) {
            return;
        }

        modal.classList.add('open');

        document.body.classList.add('overflow-hidden');

    }


    function closeModal(id) {

        const modal = document.getElementById(id);

        if (!modal) {
            return;
        }

        modal.classList.remove('open');

        if (!document.querySelector('.modal.open')) {
            document.body.classList.remove('overflow-hidden');
        }

    }


    document.querySelectorAll('.modal').forEach(function(modal) {

        modal.addEventListener('click', function(event) {

            if (event.target === modal) {
                closeModal(modal.id);
            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Mobile sidebar
    |--------------------------------------------------------------------------
    */

    const mobileSidebar = document.getElementById('mobileSidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const openSidebarButton = document.getElementById('openMobileSidebar');
    const closeSidebarButton = document.getElementById('closeMobileSidebar');


    function openMobileSidebar() {

        if (!mobileSidebar || !sidebarOverlay) {
            return;
        }

        mobileSidebar.classList.remove('-translate-x-full');
        sidebarOverlay.classList.remove('hidden');

        document.body.classList.add('overflow-hidden');

    }


    function closeMobileSidebar() {

        if (!mobileSidebar || !sidebarOverlay) {
            return;
        }

        mobileSidebar.classList.add('-translate-x-full');
        sidebarOverlay.classList.add('hidden');

        if (!document.querySelector('.modal.open')) {
            document.body.classList.remove('overflow-hidden');
        }

    }


    if (openSidebarButton) {
        openSidebarButton.addEventListener('click', openMobileSidebar);
    }


    if (closeSidebarButton) {
        closeSidebarButton.addEventListener('click', closeMobileSidebar);
    }


    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeMobileSidebar);
    }


    /*
    |--------------------------------------------------------------------------
    | Student search
    |--------------------------------------------------------------------------
    */

    const studentSearch = document.getElementById('studentSearch');


    if (studentSearch) {

        studentSearch.addEventListener('input', function() {

            const query = this.value.toLowerCase().trim();

            document.querySelectorAll('.student-row').forEach(function(row) {

                const text = row.innerText.toLowerCase();

                row.style.display = text.includes(query) ? '' : 'none';

            });

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Escape key
    |--------------------------------------------------------------------------
    */

    document.addEventListener('keydown', function(event) {

        if (event.key !== 'Escape') {
            return;
        }

        document.querySelectorAll('.modal.open').forEach(function(modal) {
            closeModal(modal.id);
        });

        closeMobileSidebar();

    });


    /*
    |--------------------------------------------------------------------------
    | Re-render icons after dynamic UI changes
    |--------------------------------------------------------------------------
    */

    if (window.lucide) {
        setTimeout(function() {
            lucide.createIcons();
        }, 100);
    }

</script>

</body>
</html>
