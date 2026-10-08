<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">

    <title>CampusOS · Student Dashboard</title>

    <!-- Roboto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet"
    >

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Roboto', 'sans-serif'],
                    },

                    colors: {
                        milk: '#FFFDF8',
                        cream: '#F4EBDD',
                        creamDark: '#E9DDCA',
                        wine: '#7F1D1D',
                        wineDark: '#641616',
                        ink: '#292522',
                        muted: '#81776B'
                    },

                    boxShadow: {
                        soft: '0 10px 35px rgba(70,45,25,.055)',
                        card: '0 16px 45px rgba(70,45,25,.07)',
                    }
                }
            }
        }
    </script>

    <style>
        * {
            box-sizing: border-box;
            scrollbar-width: thin;
            scrollbar-color: #d8cbb8 transparent;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background: #FFFDF8;
            color: #292522;
            font-family: 'Roboto', sans-serif;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        button,
        input,
        textarea,
        select {
            font-family: 'Roboto', sans-serif;
        }

        button,
        a {
            -webkit-tap-highlight-color: transparent;
        }

        img {
            max-width: 100%;
        }

        .glass {
            background: rgba(255,253,248,.92);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .soft-card {
            background: #FFFDF8;
            border: 1px solid #E9DDCA;
            box-shadow: 0 10px 35px rgba(70,45,25,.055);
        }

        .cream-card {
            background: #F4EBDD;
            border: 1px solid #E9DDCA;
        }

        .nav-item {
            transition: all .2s ease;
        }

        .nav-item:hover {
            background: #F4EBDD;
        }

        .nav-item.active {
            background: #7F1D1D;
            color: white;
            box-shadow: 0 8px 22px rgba(127,29,29,.18);
        }

        .page-section {
            display: none;
            animation: sectionIn .22s ease;
        }

        .page-section.active {
            display: block;
        }

        @keyframes sectionIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hover-card {
            transition:
                transform .2s ease,
                box-shadow .2s ease,
                border-color .2s ease;
        }

        .hover-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 45px rgba(70,45,25,.09);
            border-color: #dccdb8;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .input-field {
            width: 100%;
            margin-top: 8px;
            border: 1px solid #E9DDCA;
            border-radius: 13px;
            padding: 12px 14px;
            background: #FFFDF8;
            color: #292522;
            font-size: 14px;
            outline: none;
            transition: .2s ease;
        }

        .input-field:focus {
            border-color: #7F1D1D;
            box-shadow: 0 0 0 3px rgba(127,29,29,.06);
        }

        .section-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .16em;
            color: #81776B;
            font-weight: 800;
        }

        .resource-card {
            position: relative;
            overflow: hidden;
        }

        .resource-card::before {
            content: "";
            position: absolute;
            width: 100px;
            height: 100px;
            right: -35px;
            top: -35px;
            border-radius: 999px;
            background: rgba(127,29,29,.035);
        }

        .profile-gradient {
            background:
                radial-gradient(
                    circle at 90% 10%,
                    rgba(127,29,29,.10),
                    transparent 32%
                ),
                linear-gradient(
                    135deg,
                    #FFFDF8 0%,
                    #F8F0E5 100%
                );
        }

        /* =====================================================
           MOBILE DRAWER
        ===================================================== */

        .mobile-drawer {
            transform: translateX(-105%);
            transition: transform .28s ease;
        }

        .mobile-drawer.open {
            transform: translateX(0);
        }

        .mobile-overlay {
            opacity: 0;
            pointer-events: none;
            transition: opacity .25s ease;
        }

        .mobile-overlay.open {
            opacity: 1;
            pointer-events: auto;
        }

        /* =====================================================
           MOBILE BOTTOM NAV
        ===================================================== */

        .mobile-bottom-nav {
            padding-bottom: max(8px, env(safe-area-inset-bottom));
        }

        /*
         * Extra bottom space.
         *
         * This is intentionally larger than the navigation height
         * so the last content/card can always scroll completely
         * above the fixed bottom navigation.
         */
        .mobile-main {
            padding-bottom: calc(
                170px + env(safe-area-inset-bottom)
            );
        }

        @media (min-width: 1024px) {
            .mobile-main {
                padding-bottom: 2rem;
            }
        }

        /* Search */

        .global-search-wrap {
            position: relative;
        }

        .global-search-input {
            transition:
                border-color .2s ease,
                box-shadow .2s ease,
                width .2s ease;
        }

        .global-search-input:focus {
            border-color: #7F1D1D;
            box-shadow: 0 0 0 3px rgba(127,29,29,.06);
        }

        .search-highlight {
            outline: 2px solid rgba(127,29,29,.16);
            outline-offset: 3px;
        }

        .search-hidden {
            display: none !important;
        }

        .search-empty {
            display: none;
        }

        .search-empty.show {
            display: block;
        }

        /* Better touch targets */

        @media (max-width: 1023px) {
            button,
            a {
                min-height: 42px;
            }
        }

        /* Small phones */

        @media (max-width: 380px) {

            .mobile-bottom-nav button {
                font-size: 9px;
            }

            .mobile-bottom-nav svg {
                width: 19px;
                height: 19px;
            }

            .mobile-main {
                padding-bottom: calc(
                    175px + env(safe-area-inset-bottom)
                );
            }
        }

        /* Mobile cards */

        @media (max-width: 767px) {

            .mobile-main {
                padding-left: 14px;
                padding-right: 14px;
            }

            .mobile-card-padding {
                padding: 16px;
            }

            .mobile-title {
                font-size: 1.5rem;
                line-height: 1.15;
            }

            .hover-card:hover {
                transform: none;
                box-shadow: 0 10px 35px rgba(70,45,25,.055);
            }

            .global-search-input {
                font-size: 13px;
            }
        }

        /* Tablet */

        @media (min-width: 768px) and (max-width: 1023px) {

            .mobile-main {
                padding-left: 24px;
                padding-right: 24px;
            }
        }
    </style>
</head>

<body class="min-h-screen">

@php
    $joinedEvents = count($myRegistrations ?? []);
    $lostFoundCount = count($lostFounds ?? []);
    $complaintCount = count($myComplaints ?? []);
    $eventCount = count($events ?? []);
@endphp


<!-- =========================================================
     MOBILE OVERLAY
========================================================= -->

<div
    id="mobileOverlay"
    class="mobile-overlay fixed inset-0 bg-black/35 z-[70] lg:hidden"
    onclick="closeMobileDrawer()"
></div>


<!-- =========================================================
     MOBILE SIDEBAR / DRAWER
========================================================= -->

<aside
    id="mobileDrawer"
    class="mobile-drawer fixed left-0 top-0 bottom-0 w-[285px] max-w-[86vw] bg-milk z-[80] lg:hidden shadow-2xl flex flex-col"
>

    <div class="px-5 py-5 border-b border-creamDark flex items-center justify-between">

        <div class="flex items-center gap-3">

            <div class="w-10 h-10 rounded-xl bg-wine text-white flex items-center justify-center font-black">
                C
            </div>

            <div>
                <div class="font-black">
                    CampusOS
                </div>

                <div class="text-[10px] text-muted">
                    University Workspace
                </div>
            </div>

        </div>

        <button
            onclick="closeMobileDrawer()"
            class="w-9 h-9 rounded-xl border border-creamDark flex items-center justify-center text-ink"
            aria-label="Close menu"
        >
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none">
                <path
                    d="M6 6L18 18M18 6L6 18"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                />
            </svg>
        </button>

    </div>


    <div class="p-4">

        <div class="cream-card rounded-2xl p-4">

            <div class="flex items-center gap-3">

                @if($user->profile_pic)

                    <img
                        src="{{ asset('storage/' . $user->profile_pic) }}"
                        class="w-12 h-12 rounded-xl object-cover border-2 border-white shrink-0"
                        alt="Profile"
                        loading="lazy"
                    >

                @else

                    <div class="w-12 h-12 rounded-xl bg-wine text-white flex items-center justify-center font-bold shrink-0">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                @endif

                <div class="min-w-0">

                    <div class="font-bold text-sm truncate">
                        {{ $user->name }}
                    </div>

                    <div class="text-[11px] text-muted truncate mt-1">
                        ID: {{ $user->student_id }}
                    </div>

                </div>

            </div>

        </div>

    </div>


    <nav class="px-4 space-y-1 overflow-y-auto flex-1">

        <button
            onclick="mobileNavigate('home')"
            class="drawer-nav-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-left"
        >
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path d="M3 10.5L12 3L21 10.5V21H14V15H10V21H3V10.5Z"
                      stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
            </svg>
            Dashboard
        </button>


        <button
            onclick="mobileNavigate('schedule')"
            class="drawer-nav-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-left"
        >
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                <rect x="3" y="4" width="18" height="17" rx="3"
                      stroke="currentColor" stroke-width="1.8"/>
                <path d="M7 2V6M17 2V6M3 9H21"
                      stroke="currentColor" stroke-width="1.8"
                      stroke-linecap="round"/>
            </svg>
            Class Schedule
        </button>


        <button
            onclick="mobileNavigate('events')"
            class="drawer-nav-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-left"
        >
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path d="M12 3L14.7 8.4L20.7 9.3L16.35 13.5L17.4 19.5L12 16.65L6.6 19.5L7.65 13.5L3.3 9.3L9.3 8.4L12 3Z"
                      stroke="currentColor"
                      stroke-width="1.7"
                      stroke-linejoin="round"/>
            </svg>
            My Events
        </button>


        <button
            onclick="mobileNavigate('lost')"
            class="drawer-nav-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-left"
        >
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                <circle cx="11" cy="11" r="6.5"
                        stroke="currentColor" stroke-width="1.8"/>
                <path d="M16 16L21 21"
                      stroke="currentColor"
                      stroke-width="1.8"
                      stroke-linecap="round"/>
            </svg>
            Lost & Found
        </button>


        <button
            onclick="mobileNavigate('resources')"
            class="drawer-nav-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-left"
        >
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path d="M5 4.5C5 3.67 5.67 3 6.5 3H19V19H6.5C5.67 19 5 19.67 5 20.5C5 21.33 5.67 22 6.5 22H19"
                      stroke="currentColor"
                      stroke-width="1.7"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
                <path d="M5 20.5V4.5"
                      stroke="currentColor"
                      stroke-width="1.7"/>
            </svg>
            Resources
        </button>


        <button
            onclick="mobileNavigate('helpdesk')"
            class="drawer-nav-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-left"
        >
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="9"
                        stroke="currentColor" stroke-width="1.8"/>
                <path d="M9.5 9.5C9.5 8.12 10.62 7 12 7C13.38 7 14.5 8.12 14.5 9.5C14.5 10.45 14 11.08 13.1 11.7C12.35 12.2 12 12.75 12 13.5"
                      stroke="currentColor"
                      stroke-width="1.8"
                      stroke-linecap="round"/>
                <circle cx="12" cy="17" r="1" fill="currentColor"/>
            </svg>
            Helpdesk
        </button>


        <a
            href="{{ route('user.profile') }}"
            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold"
        >
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path d="M12 12C14.76 12 17 9.76 17 7C17 4.24 14.76 2 12 2C9.24 2 7 4.24 7 7C7 9.76 9.24 12 12 12Z"
                      stroke="currentColor" stroke-width="1.8"/>
                <path d="M3 22C3.8 17.95 7.25 15 12 15C16.75 15 20.2 17.95 21 22"
                      stroke="currentColor" stroke-width="1.8"
                      stroke-linecap="round"/>
            </svg>
            My Profile
        </a>

    </nav>


    <div class="p-4 border-t border-creamDark">

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button
                type="submit"
                class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-wine hover:bg-cream transition"
            >
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M10 17L15 12L10 7"
                          stroke="currentColor"
                          stroke-width="1.8"
                          stroke-linecap="round"
                          stroke-linejoin="round"/>
                    <path d="M15 12H3"
                          stroke="currentColor"
                          stroke-width="1.8"
                          stroke-linecap="round"/>
                    <path d="M14 4H20C20.55 4 21 4.45 21 5V19C21 19.55 20.55 20 20 20H14"
                          stroke="currentColor"
                          stroke-width="1.8"
                          stroke-linecap="round"/>
                </svg>

                Logout
            </button>

        </form>

    </div>

</aside>


<!-- =========================================================
     DESKTOP SIDEBAR
========================================================= -->

<aside class="hidden lg:flex fixed left-0 top-0 bottom-0 w-[250px] bg-milk border-r border-creamDark z-50 flex-col">

    <div class="px-6 py-6 border-b border-creamDark">

        <button
            onclick="openSection('home')"
            class="flex items-center gap-3"
        >

            <div class="w-11 h-11 rounded-2xl bg-wine text-white flex items-center justify-center font-black text-lg shadow-lg shadow-red-900/10">
                C
            </div>

            <div class="text-left">

                <div class="font-black tracking-tight text-lg">
                    CampusOS
                </div>

                <div class="text-[10px] text-muted font-medium">
                    University Workspace
                </div>

            </div>

        </button>

    </div>


    <div class="px-4 pt-5">

        <div class="cream-card rounded-2xl p-4">

            <div class="flex items-center gap-3">

                @if($user->profile_pic)

                    <img
                        src="{{ asset('storage/' . $user->profile_pic) }}"
                        class="w-11 h-11 rounded-xl object-cover border border-white"
                        alt="Profile"
                        loading="lazy"
                    >

                @else

                    <div class="w-11 h-11 rounded-xl bg-wine text-white flex items-center justify-center font-bold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                @endif

                <div class="min-w-0">

                    <div class="font-bold text-sm truncate">
                        {{ $user->name }}
                    </div>

                    <div class="text-[11px] text-muted truncate mt-0.5">
                        ID: {{ $user->student_id }}
                    </div>

                </div>

            </div>

        </div>

    </div>


    <nav class="px-4 mt-5 space-y-1 flex-1">

        <button
            onclick="openSection('home')"
            data-section="home"
            class="nav-item active w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-left"
        >
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none">
                <path d="M3 10.5L12 3L21 10.5V21H14V15H10V21H3V10.5Z"
                      stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
            </svg>
            Dashboard
        </button>


        <button
            onclick="openSection('schedule')"
            data-section="schedule"
            class="nav-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-left"
        >
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none">
                <rect x="3" y="4" width="18" height="17" rx="3"
                      stroke="currentColor" stroke-width="1.8"/>
                <path d="M7 2V6M17 2V6M3 9H21"
                      stroke="currentColor"
                      stroke-width="1.8"
                      stroke-linecap="round"/>
            </svg>
            Class Schedule
        </button>


        <button
            onclick="openSection('events')"
            data-section="events"
            class="nav-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-left"
        >
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none">
                <path d="M12 3L14.7 8.4L20.7 9.3L16.35 13.5L17.4 19.5L12 16.65L6.6 19.5L7.65 13.5L3.3 9.3L9.3 8.4L12 3Z"
                      stroke="currentColor"
                      stroke-width="1.7"
                      stroke-linejoin="round"/>
            </svg>
            My Events
        </button>


        <button
            onclick="openSection('lost')"
            data-section="lost"
            class="nav-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-left"
        >
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none">
                <circle cx="11" cy="11" r="6.5"
                        stroke="currentColor"
                        stroke-width="1.8"/>
                <path d="M16 16L21 21"
                      stroke="currentColor"
                      stroke-width="1.8"
                      stroke-linecap="round"/>
            </svg>
            Lost & Found
        </button>


        <button
            onclick="openSection('resources')"
            data-section="resources"
            class="nav-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-left"
        >
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none">
                <path d="M5 4.5C5 3.67 5.67 3 6.5 3H19V19H6.5C5.67 19 5 19.67 5 20.5C5 21.33 5.67 22 6.5 22H19"
                      stroke="currentColor"
                      stroke-width="1.7"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
                <path d="M5 20.5V4.5"
                      stroke="currentColor"
                      stroke-width="1.7"/>
            </svg>
            Resources
        </button>


        <button
            onclick="openSection('helpdesk')"
            data-section="helpdesk"
            class="nav-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-left"
        >
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="9"
                        stroke="currentColor"
                        stroke-width="1.8"/>
                <path d="M9.5 9.5C9.5 8.12 10.62 7 12 7C13.38 7 14.5 8.12 14.5 9.5C14.5 10.45 14 11.08 13.1 11.7C12.35 12.2 12 12.75 12 13.5"
                      stroke="currentColor"
                      stroke-width="1.8"
                      stroke-linecap="round"/>
                <circle cx="12" cy="17" r="1"
                        fill="currentColor"/>
            </svg>
            Helpdesk
        </button>


        <a
            href="{{ route('user.profile') }}"
            class="nav-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold"
        >
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="8" r="4"
                        stroke="currentColor" stroke-width="1.8"/>
                <path d="M4 21C4.8 16.9 7.4 14.5 12 14.5C16.6 14.5 19.2 16.9 20 21"
                      stroke="currentColor"
                      stroke-width="1.8"
                      stroke-linecap="round"/>
            </svg>
            Edit Profile
        </a>

    </nav>


    <div class="p-4 border-t border-creamDark">

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button
                type="submit"
                class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-wine hover:bg-cream transition"
            >
                <svg width="19" height="19" viewBox="0 0 24 24" fill="none">
                    <path d="M10 17L15 12L10 7"
                          stroke="currentColor"
                          stroke-width="1.8"
                          stroke-linecap="round"
                          stroke-linejoin="round"/>
                    <path d="M15 12H3"
                          stroke="currentColor"
                          stroke-width="1.8"
                          stroke-linecap="round"/>
                    <path d="M14 4H20C20.55 4 21 4.45 21 5V19C21 19.55 20.55 20 20 20H14"
                          stroke="currentColor"
                          stroke-width="1.8"
                          stroke-linecap="round"/>
                </svg>
                Logout
            </button>

        </form>

    </div>

</aside>


<!-- =========================================================
     MAIN AREA
========================================================= -->

<div class="lg:ml-[250px] min-h-screen">


<!-- =========================================================
     TOP HEADER
========================================================= -->

<header class="sticky top-0 z-40 glass border-b border-creamDark">

    <div class="max-w-[1500px] mx-auto px-4 sm:px-6 py-2.5 min-h-[68px] flex items-center gap-3">


        <!-- Mobile Menu -->

        <button
            onclick="openMobileDrawer()"
            class="lg:hidden w-10 h-10 rounded-xl border border-creamDark bg-milk flex items-center justify-center shrink-0"
            aria-label="Open menu"
        >

            <svg width="21" height="21" viewBox="0 0 24 24" fill="none">
                <path d="M4 6H20M4 12H20M4 18H20"
                      stroke="currentColor"
                      stroke-width="1.8"
                      stroke-linecap="round"/>
            </svg>

        </button>


        <!-- Welcome -->

        <div class="min-w-0 flex-1">

            <div class="hidden sm:block text-xs text-muted font-semibold">
                {{ now()->format('l, d F Y') }}
            </div>

            <h1 class="text-base sm:text-xl font-black mt-0.5 truncate">
                Welcome back, {{ Str::before($user->name, ' ') }} 👋
            </h1>

        </div>


        <!-- =================================================
             GLOBAL SEARCH
        ================================================== -->

        <div class="global-search-wrap hidden md:block w-[260px] lg:w-[310px]">

            <div class="relative">

                <svg
                    class="absolute left-3 top-1/2 -translate-y-1/2 text-muted pointer-events-none"
                    width="18"
                    height="18"
                    viewBox="0 0 24 24"
                    fill="none"
                >
                    <circle
                        cx="11"
                        cy="11"
                        r="6.5"
                        stroke="currentColor"
                        stroke-width="1.8"
                    />

                    <path
                        d="M16 16L21 21"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                    />
                </svg>

                <input
                    id="globalSearch"
                    type="search"
                    placeholder="Search campus..."
                    autocomplete="off"
                    class="global-search-input w-full h-11 rounded-xl border border-creamDark bg-milk pl-10 pr-10 text-sm outline-none"
                    oninput="globalSearch(this.value)"
                >

                <button
                    type="button"
                    id="clearSearchBtn"
                    onclick="clearGlobalSearch()"
                    class="hidden absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-lg hover:bg-cream text-muted items-center justify-center"
                    aria-label="Clear search"
                >
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M6 6L18 18M18 6L6 18"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                        />
                    </svg>
                </button>

            </div>

        </div>


        <!-- Mobile Search Button -->

        <button
            type="button"
            onclick="toggleMobileSearch()"
            class="md:hidden w-10 h-10 rounded-xl border border-creamDark bg-milk flex items-center justify-center shrink-0"
            aria-label="Search"
        >
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none">
                <circle
                    cx="11"
                    cy="11"
                    r="6.5"
                    stroke="currentColor"
                    stroke-width="1.8"
                />
                <path
                    d="M16 16L21 21"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                />
            </svg>
        </button>


        <!-- Profile -->

        <a
            href="{{ route('user.profile') }}"
            class="flex items-center gap-2 px-2 sm:px-3 py-2 rounded-xl border border-creamDark hover:bg-cream transition text-sm font-semibold shrink-0"
        >

            @if($user->profile_pic)

                <img
                    src="{{ asset('storage/' . $user->profile_pic) }}"
                    class="w-8 h-8 rounded-lg object-cover"
                    alt="Profile"
                    loading="lazy"
                >

            @else

                <div class="w-8 h-8 rounded-lg bg-wine text-white flex items-center justify-center text-xs font-bold">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

            @endif

            <span class="hidden sm:inline">
                Profile
            </span>

        </a>

    </div>


    <!-- Mobile Search Row -->

    <div
        id="mobileSearchRow"
        class="hidden md:hidden px-4 pb-3"
    >

        <div class="relative">

            <svg
                class="absolute left-3 top-1/2 -translate-y-1/2 text-muted pointer-events-none"
                width="18"
                height="18"
                viewBox="0 0 24 24"
                fill="none"
            >
                <circle
                    cx="11"
                    cy="11"
                    r="6.5"
                    stroke="currentColor"
                    stroke-width="1.8"
                />

                <path
                    d="M16 16L21 21"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                />
            </svg>

            <input
                id="mobileGlobalSearch"
                type="search"
                placeholder="Search events, classes, resources..."
                autocomplete="off"
                class="global-search-input w-full h-11 rounded-xl border border-creamDark bg-milk pl-10 pr-10 text-sm outline-none"
                oninput="globalSearch(this.value)"
            >

            <button
                type="button"
                onclick="clearGlobalSearch()"
                class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-lg hover:bg-cream text-muted flex items-center justify-center"
                aria-label="Clear search"
            >
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none">
                    <path
                        d="M6 6L18 18M18 6L6 18"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                    />
                </svg>
            </button>

        </div>

    </div>

</header>


<main class="max-w-[1500px] mx-auto px-4 sm:px-6 py-5 sm:py-6 mobile-main">


<!-- =========================================================
     SEARCH RESULT STATUS
========================================================= -->

<div
    id="globalSearchStatus"
    class="hidden mb-5 rounded-2xl border border-creamDark bg-cream px-4 py-3 text-sm"
>
    <div class="flex items-center justify-between gap-3">

        <div>
            <span class="font-bold">
                Search results
            </span>

            <span
                id="globalSearchCount"
                class="text-muted ml-1"
            >
                0 results
            </span>
        </div>

        <button
            type="button"
            onclick="clearGlobalSearch()"
            class="text-xs font-bold text-wine"
        >
            Clear
        </button>

    </div>
</div>


<!-- =========================================================
     FLASH MESSAGES
========================================================= -->

@if(session('success'))

    <div class="mb-5 rounded-2xl border border-green-200 bg-green-50 text-green-800 px-4 sm:px-5 py-4 text-sm font-medium">
        {{ session('success') }}
    </div>

@endif


@if(session('error'))

    <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 text-red-800 px-4 sm:px-5 py-4 text-sm font-medium">
        {{ session('error') }}
    </div>

@endif


@if($errors->any())

    <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 text-red-800 px-4 sm:px-5 py-4">

        <ul class="list-disc list-inside text-sm space-y-1">

            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach

        </ul>

    </div>

@endif


<!-- =========================================================
     DASHBOARD HOME
========================================================= -->

<section id="section-home" class="page-section active">

    <!-- PROFILE HERO -->

    <div class="soft-card profile-gradient rounded-[24px] sm:rounded-[28px] p-4 sm:p-7">

        <div class="flex flex-col md:flex-row md:items-center gap-5 sm:gap-6">

            <div class="shrink-0">

                @if($user->profile_pic)

                    <img
                        src="{{ asset('storage/' . $user->profile_pic) }}"
                        alt="Profile"
                        loading="lazy"
                        class="w-20 h-20 sm:w-28 sm:h-28 rounded-[22px] sm:rounded-[26px] object-cover border-4 border-white shadow-sm"
                    >

                @else

                    <div class="w-20 h-20 sm:w-28 sm:h-28 rounded-[22px] sm:rounded-[26px] bg-wine text-white flex items-center justify-center text-3xl font-black shadow-sm">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                @endif

            </div>


            <div class="flex-1 min-w-0">

                <div class="section-label">
                    Student Profile
                </div>

                <h2 class="text-xl sm:text-3xl font-black mt-1 break-words">
                    {{ $user->name }}
                </h2>

                <div class="flex flex-wrap gap-2 mt-3 sm:mt-4">

                    <span class="px-2.5 sm:px-3 py-1.5 rounded-lg bg-white border border-creamDark text-[11px] sm:text-xs font-bold">
                        ID: {{ $user->student_id }}
                    </span>

                    <span class="px-2.5 sm:px-3 py-1.5 rounded-lg bg-white border border-creamDark text-[11px] sm:text-xs font-bold">
                        Batch: {{ $user->batch_no }}
                    </span>

                    <span class="px-2.5 sm:px-3 py-1.5 rounded-lg bg-white border border-creamDark text-[11px] sm:text-xs font-bold break-all">
                        {{ $user->department }}
                    </span>

                </div>

            </div>


            <a
                href="{{ route('user.profile') }}"
                class="w-full md:w-auto text-center px-5 py-3 rounded-xl bg-wine hover:bg-wineDark text-white text-sm font-bold transition shadow-sm"
            >
                Edit Profile
            </a>

        </div>

    </div>


    <!-- STATISTICS -->

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mt-4 sm:mt-5">

        <div class="soft-card hover-card rounded-2xl p-4">

            <div class="flex items-center justify-between">

                <div class="w-9 h-9 rounded-xl cream-card flex items-center justify-center text-wine">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M12 3L14.7 8.4L20.7 9.3L16.35 13.5L17.4 19.5L12 16.65L6.6 19.5L7.65 13.5L3.3 9.3L9.3 8.4L12 3Z"
                              stroke="currentColor"
                              stroke-width="1.7"
                              stroke-linejoin="round"/>
                    </svg>
                </div>

                <span class="text-[9px] font-bold text-muted">
                    EVENTS
                </span>

            </div>

            <div class="text-2xl font-black mt-3">
                {{ $joinedEvents }}
            </div>

            <div class="text-xs sm:text-sm text-muted mt-1">
                Events Joined
            </div>

        </div>


        <div class="soft-card hover-card rounded-2xl p-4">

            <div class="flex items-center justify-between">

                <div class="w-9 h-9 rounded-xl cream-card flex items-center justify-center text-wine">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <circle cx="11" cy="11" r="6.5"
                                stroke="currentColor"
                                stroke-width="1.8"/>
                        <path d="M16 16L21 21"
                              stroke="currentColor"
                              stroke-width="1.8"
                              stroke-linecap="round"/>
                    </svg>
                </div>

                <span class="text-[9px] font-bold text-muted">
                    POSTS
                </span>

            </div>

            <div class="text-2xl font-black mt-3">
                {{ $lostFoundCount }}
            </div>

            <div class="text-xs sm:text-sm text-muted mt-1">
                Lost & Found
            </div>

        </div>


        <div class="soft-card hover-card rounded-2xl p-4">

            <div class="flex items-center justify-between">

                <div class="w-9 h-9 rounded-xl cream-card flex items-center justify-center text-wine">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <rect x="3" y="4" width="18" height="17" rx="3"
                              stroke="currentColor"
                              stroke-width="1.8"/>
                        <path d="M7 2V6M17 2V6M3 9H21"
                              stroke="currentColor"
                              stroke-width="1.8"
                              stroke-linecap="round"/>
                    </svg>
                </div>

                <span class="text-[9px] font-bold text-muted">
                    CAMPUS
                </span>

            </div>

            <div class="text-2xl font-black mt-3">
                {{ $eventCount }}
            </div>

            <div class="text-xs sm:text-sm text-muted mt-1">
                Available Events
            </div>

        </div>


        <div class="soft-card hover-card rounded-2xl p-4">

            <div class="flex items-center justify-between">

                <div class="w-9 h-9 rounded-xl cream-card flex items-center justify-center text-wine">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="9"
                                stroke="currentColor"
                                stroke-width="1.8"/>
                        <path d="M9.5 9.5C9.5 8.12 10.62 7 12 7C13.38 7 14.5 8.12 14.5 9.5C14.5 10.45 14 11.08 13.1 11.7C12.35 12.2 12 12.75 12 13.5"
                              stroke="currentColor"
                              stroke-width="1.8"
                              stroke-linecap="round"/>
                        <circle cx="12" cy="17" r="1"
                                fill="currentColor"/>
                    </svg>
                </div>

                <span class="text-[9px] font-bold text-muted">
                    SUPPORT
                </span>

            </div>

            <div class="text-2xl font-black mt-3">
                {{ $complaintCount }}
            </div>

            <div class="text-xs sm:text-sm text-muted mt-1">
                My Complaints
            </div>

        </div>

    </div>


    <!-- TODAY'S CLASSES -->

    <div class="mt-8 sm:mt-9">

        <div class="flex items-end justify-between gap-3 mb-4">

            <div>

                <div class="section-label">
                    Academic
                </div>

                <h2 class="text-xl sm:text-2xl font-black mt-1">
                    Today's Classes
                </h2>

            </div>

            <button
                onclick="openSection('schedule')"
                class="text-xs sm:text-sm font-bold text-wine whitespace-nowrap"
            >
                Full schedule →
            </button>

        </div>


        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-3 sm:gap-4">

            @forelse($todaysRoutines as $routine)

                @php
                    $isCancelled = in_array($routine->id, $cancelledRoutineIdsToday);
                @endphp

                <div
                    class="soft-card hover-card rounded-2xl p-4 sm:p-5"
                    data-search-item
                    data-search-section="schedule"
                    data-search-text="{{ strtolower($routine->course_title . ' ' . $routine->course_code . ' ' . $routine->course_teacher . ' today ' . $routine->class_time) }}"
                >

                    <div class="flex justify-between items-start gap-3">

                        <span class="px-2.5 py-1.5 rounded-lg text-[10px] font-bold
                            {{ $isCancelled
                                ? 'bg-red-50 text-red-700 border border-red-100'
                                : 'bg-[#F4EBDD] text-[#7F1D1D]' }}">

                            {{ $isCancelled ? 'Cancelled Today' : 'Active Class' }}

                        </span>

                        <span class="text-xs font-bold text-muted whitespace-nowrap">
                            {{ $routine->class_time }}
                        </span>

                    </div>


                    <h3 class="font-black text-base sm:text-lg mt-4">
                        {{ $routine->course_title }}
                    </h3>

                    <p class="text-xs text-muted mt-2">
                        Course Code:
                        <b class="text-ink">{{ $routine->course_code }}</b>
                    </p>

                    <p class="text-xs text-muted mt-1">
                        Teacher:
                        <b class="text-ink">{{ $routine->course_teacher }}</b>
                    </p>

                </div>

            @empty

                <div class="md:col-span-2 xl:col-span-3 cream-card rounded-2xl p-7 text-center">

                    <div class="text-2xl">
                        ☕
                    </div>

                    <p class="font-bold mt-2">
                        No classes scheduled today.
                    </p>

                    <p class="text-sm text-muted mt-1">
                        Enjoy your day!
                    </p>

                </div>

            @endforelse

        </div>

    </div>


    <!-- CLASS SCHEDULE PREVIEW -->

    <div class="mt-8 sm:mt-9">

        <div class="flex items-end justify-between gap-3 mb-4">

            <div>

                <div class="section-label">
                    Weekly Routine
                </div>

                <h2 class="text-xl sm:text-2xl font-black mt-1">
                    Class Schedule
                </h2>

            </div>

            <button
                onclick="openSection('schedule')"
                class="text-xs sm:text-sm font-bold text-wine whitespace-nowrap"
            >
                View all →
            </button>

        </div>


        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-3 sm:gap-4">

            @forelse($routines as $routine)

                <div
                    class="soft-card hover-card rounded-2xl p-4 sm:p-5"
                    data-search-item
                    data-search-section="schedule"
                    data-search-text="{{ strtolower($routine->day . ' ' . $routine->course_title . ' ' . $routine->course_code . ' ' . $routine->course_teacher . ' ' . $routine->class_time) }}"
                >

                    <div class="flex items-center justify-between gap-3">

                        <span class="px-3 py-1.5 rounded-lg bg-wine text-white text-[10px] font-bold">
                            {{ $routine->day }}
                        </span>

                        <span class="text-xs font-bold text-muted">
                            {{ $routine->class_time }}
                        </span>

                    </div>

                    <h3 class="font-black mt-4">
                        {{ $routine->course_title }}
                    </h3>

                    <div class="text-xs text-muted mt-2">
                        {{ $routine->course_code }}
                    </div>

                    <div class="text-xs text-muted mt-1">
                        {{ $routine->course_teacher }}
                    </div>

                </div>

            @empty

                <div class="md:col-span-2 xl:col-span-3 cream-card rounded-2xl p-6 text-center">
                    <p class="font-bold">
                        No class schedule available.
                    </p>
                </div>

            @endforelse

        </div>

    </div>


    <!-- LOST & FOUND PREVIEW -->

    <div class="mt-8 sm:mt-9">

        <div class="flex items-end justify-between gap-3 mb-4">

            <div>

                <div class="section-label">
                    Campus Community
                </div>

                <h2 class="text-xl sm:text-2xl font-black mt-1">
                    Lost & Found
                </h2>

            </div>

            <button
                onclick="openSection('lost')"
                class="text-xs sm:text-sm font-bold text-wine whitespace-nowrap"
            >
                View all →
            </button>

        </div>


        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-4">

            @forelse($lostFounds as $item)

                @if($loop->iteration <= 3)

                    <div
                        class="soft-card hover-card rounded-2xl overflow-hidden"
                        data-search-item
                        data-search-section="lost"
                        data-search-text="{{ strtolower($item->title . ' ' . $item->location . ' ' . $item->description . ' ' . $item->status) }}"
                    >

                        @if($item->image)

                            <img
                                src="{{ asset('storage/' . $item->image) }}"
                                class="w-full h-40 object-cover"
                                alt="{{ $item->title }}"
                                loading="lazy"
                            >

                        @else

                            <div class="h-40 bg-cream flex items-center justify-center text-wine">

                                <svg width="42" height="42" viewBox="0 0 24 24" fill="none">
                                    <circle cx="11" cy="11" r="6.5"
                                            stroke="currentColor"
                                            stroke-width="1.7"/>
                                    <path d="M16 16L21 21"
                                          stroke="currentColor"
                                          stroke-width="1.7"
                                          stroke-linecap="round"/>
                                </svg>

                            </div>

                        @endif


                        <div class="p-4 sm:p-5">

                            <div class="flex items-start justify-between gap-3">

                                <h3 class="font-black line-clamp-2">
                                    {{ $item->title }}
                                </h3>

                                <span class="shrink-0 px-2.5 py-1 rounded-lg text-[10px] font-bold
                                    {{ $item->status === 'lost'
                                        ? 'bg-red-50 text-red-700'
                                        : 'bg-green-50 text-green-700' }}">

                                    {{ ucfirst($item->status) }}

                                </span>

                            </div>

                            <p class="text-xs text-muted mt-3">
                                📍 {{ $item->location }}
                            </p>

                            <p class="text-sm text-muted mt-2 line-clamp-2">
                                {{ $item->description }}
                            </p>

                        </div>

                    </div>

                @endif

            @empty

                <div class="md:col-span-2 xl:col-span-3 cream-card rounded-2xl p-7 text-center">

                    <p class="font-bold mt-2">
                        No Lost & Found posts
                    </p>

                    <p class="text-sm text-muted mt-1">
                        New reports will appear here.
                    </p>

                </div>

            @endforelse

        </div>

    </div>


    <!-- QUICK ACCESS -->

    <div class="mt-8 sm:mt-9">

        <h2 class="text-xl font-black">
            Quick Access
        </h2>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mt-4">

            <button
                onclick="openSection('events')"
                class="soft-card hover-card rounded-2xl p-4 sm:p-5 text-left"
            >

                <div class="w-11 h-11 rounded-xl cream-card flex items-center justify-center text-wine">

                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M12 3L14.7 8.4L20.7 9.3L16.35 13.5L17.4 19.5L12 16.65L6.6 19.5L7.65 13.5L3.3 9.3L9.3 8.4L12 3Z"
                              stroke="currentColor"
                              stroke-width="1.7"
                              stroke-linejoin="round"/>
                    </svg>

                </div>

                <h3 class="font-black mt-4">
                    My Events
                </h3>

                <p class="text-sm text-muted mt-1">
                    View your registered university events.
                </p>

            </button>


            <button
                onclick="openLostReport()"
                class="soft-card hover-card rounded-2xl p-4 sm:p-5 text-left"
            >

                <div class="w-11 h-11 rounded-xl cream-card flex items-center justify-center text-wine">

                    <svg width="21" height="21" viewBox="0 0 24 24" fill="none">
                        <path d="M12 5V19M5 12H19"
                              stroke="currentColor"
                              stroke-width="1.8"
                              stroke-linecap="round"/>
                    </svg>

                </div>

                <h3 class="font-black mt-4">
                    Add Report
                </h3>

                <p class="text-sm text-muted mt-1">
                    Report a lost or found campus item.
                </p>

            </button>


            <button
                onclick="openSection('helpdesk')"
                class="soft-card hover-card rounded-2xl p-4 sm:p-5 text-left"
            >

                <div class="w-11 h-11 rounded-xl cream-card flex items-center justify-center text-wine">

                    <svg width="21" height="21" viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="9"
                                stroke="currentColor"
                                stroke-width="1.8"/>
                        <path d="M9.5 9.5C9.5 8.12 10.62 7 12 7C13.38 7 14.5 8.12 14.5 9.5C14.5 10.45 14 11.08 13.1 11.7C12.35 12.2 12 12.75 12 13.5"
                              stroke="currentColor"
                              stroke-width="1.8"
                              stroke-linecap="round"/>
                        <circle cx="12" cy="17" r="1"
                                fill="currentColor"/>
                    </svg>

                </div>

                <h3 class="font-black mt-4">
                    Helpdesk
                </h3>

                <p class="text-sm text-muted mt-1">
                    Submit and track your complaints.
                </p>

            </button>


            <a
                href="{{ route('user.profile') }}"
                class="soft-card hover-card rounded-2xl p-4 sm:p-5 text-left"
            >

                <div class="w-11 h-11 rounded-xl cream-card flex items-center justify-center text-wine">

                    <svg width="21" height="21" viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="8" r="4"
                                stroke="currentColor"
                                stroke-width="1.8"/>
                        <path d="M4 21C4.8 16.9 7.4 14.5 12 14.5C16.6 14.5 19.2 16.9 20 21"
                              stroke="currentColor"
                              stroke-width="1.8"
                              stroke-linecap="round"/>
                    </svg>

                </div>

                <h3 class="font-black mt-4">
                    Profile
                </h3>

                <p class="text-sm text-muted mt-1">
                    Update your student information.
                </p>

            </a>

        </div>

    </div>

</section>


<!-- =========================================================
     CLASS SCHEDULE
========================================================= -->

<section id="section-schedule" class="page-section">

    <div>

        <div class="section-label">
            Academic
        </div>

        <h2 class="text-2xl sm:text-3xl font-black mt-1">
            Class Schedule
        </h2>

        <p class="text-sm text-muted mt-2">
            Weekly routine for Batch {{ $user->batch_no }}
        </p>

    </div>


    <div class="grid xl:grid-cols-[1.5fr_.7fr] gap-5 mt-6">

        <!-- Weekly Routine -->

        <div class="soft-card rounded-[24px] sm:rounded-[26px] p-4 sm:p-6">

            <div class="flex items-center justify-between mb-5">

                <div>

                    <h3 class="text-lg font-black">
                        Weekly Routine
                    </h3>

                    <p class="text-xs text-muted mt-1">
                        Your regular class schedule
                    </p>

                </div>

                <div class="w-10 h-10 rounded-xl cream-card flex items-center justify-center text-wine">

                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <rect x="3" y="4" width="18" height="17" rx="3"
                              stroke="currentColor"
                              stroke-width="1.8"/>
                        <path d="M7 2V6M17 2V6M3 9H21"
                              stroke="currentColor"
                              stroke-width="1.8"
                              stroke-linecap="round"/>
                    </svg>

                </div>

            </div>


            <div class="space-y-3">

                @forelse($routines as $routine)

                    <div
                        class="border border-creamDark rounded-2xl p-4 hover:bg-cream/40 transition"
                        data-search-item
                        data-search-section="schedule"
                        data-search-text="{{ strtolower($routine->day . ' ' . $routine->course_title . ' ' . $routine->course_code . ' ' . $routine->course_teacher . ' ' . $routine->class_time) }}"
                    >

                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">

                            <div>

                                <div class="flex items-center gap-2 flex-wrap">

                                    <span class="px-2.5 py-1 rounded-lg bg-wine text-white text-[11px] font-bold">
                                        {{ $routine->day }}
                                    </span>

                                    <span class="text-xs text-muted">
                                        {{ $routine->course_code }}
                                    </span>

                                </div>

                                <h4 class="font-black mt-2">
                                    {{ $routine->course_title }}
                                </h4>

                                <p class="text-xs text-muted mt-1">
                                    Course Teacher:
                                    {{ $routine->course_teacher }}
                                </p>

                            </div>

                            <div class="sm:text-right">

                                <div class="font-black">
                                    {{ $routine->class_time }}
                                </div>

                                <div class="text-xs text-muted mt-1">
                                    Class Time
                                </div>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="cream-card rounded-2xl p-6 text-center">
                        <p class="text-sm text-muted">
                            No routines posted for your batch yet.
                        </p>
                    </div>

                @endforelse

            </div>

        </div>


        <!-- Cancellations -->

        <div class="soft-card rounded-[24px] sm:rounded-[26px] p-4 sm:p-6">

            <h3 class="text-lg font-black">
                Class Cancellations
            </h3>

            <p class="text-sm text-muted mt-1">
                Latest cancellation notices
            </p>

            <div class="space-y-3 mt-5">

                @forelse($cancelledClasses as $cancel)

                    <div class="bg-red-50 border border-red-100 rounded-2xl p-4">

                        <div class="flex justify-between gap-3">

                            <div>

                                <div class="font-bold text-red-950">
                                    {{ $cancel->routine->course_title ?? 'Class' }}
                                </div>

                                <div class="text-xs text-red-700 mt-1">
                                    Cancelled:
                                    {{ $cancel->cancelled_date }}
                                </div>

                            </div>

                            <span class="h-fit px-2.5 py-1 rounded-lg bg-wine text-white text-[10px] font-bold">
                                Cancelled
                            </span>

                        </div>

                    </div>

                @empty

                    <div class="cream-card rounded-2xl p-5 text-center">

                        <div class="font-bold">
                            All clear
                        </div>

                        <p class="text-xs text-muted mt-1">
                            No active class cancellations.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     EVENTS
========================================================= -->

<section id="section-events" class="page-section">

    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">

        <div>

            <div class="section-label">
                Campus Activities
            </div>

            <h2 class="text-2xl sm:text-3xl font-black mt-1">
                University Events
            </h2>

            <p class="text-sm text-muted mt-2">
                Discover and register for campus activities.
            </p>

        </div>

        <div class="cream-card px-4 py-2 rounded-xl text-sm font-bold">
            {{ $joinedEvents }} Joined
        </div>

    </div>


    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-5 mt-6">

        @forelse($events as $event)

            <div
                class="soft-card hover-card rounded-[22px] sm:rounded-[24px] overflow-hidden flex flex-col"
                data-search-item
                data-search-section="events"
                data-search-text="{{ strtolower($event->title . ' ' . ($event->category->name ?? '') . ' ' . $event->location . ' ' . $event->description . ' ' . $event->date_time) }}"
            >

                @if($event->banner)

                    <img
                        src="{{ asset('storage/' . $event->banner) }}"
                        class="w-full h-40 sm:h-44 object-cover"
                        alt="Event Banner"
                        loading="lazy"
                    >

                @else

                    <div class="h-40 sm:h-44 bg-cream flex items-center justify-center">

                        <div class="w-16 h-16 rounded-2xl bg-milk border border-creamDark flex items-center justify-center text-wine text-2xl font-black">
                            ✦
                        </div>

                    </div>

                @endif


                <div class="p-4 sm:p-5 flex-1 flex flex-col">

                    <div class="flex items-center justify-between gap-2">

                        <span class="px-2.5 py-1 rounded-lg bg-cream text-wine text-[10px] font-bold">
                            {{ $event->category->name ?? 'Event' }}
                        </span>

                        @if(in_array($event->id, $myRegistrations))

                            <span class="text-[10px] font-bold text-green-700">
                                ✓ Registered
                            </span>

                        @endif

                    </div>


                    <h3 class="font-black text-lg mt-4">
                        {{ $event->title }}
                    </h3>


                    <p class="text-xs text-muted mt-2">
                        📍 {{ $event->location }}
                    </p>

                    <p class="text-xs text-muted mt-1">
                        ◷ {{ date('d M Y, h:i A', strtotime($event->date_time)) }}
                    </p>


                    <p class="text-sm text-muted line-clamp-2 mt-3">
                        {{ $event->description }}
                    </p>


                    <div class="mt-auto pt-5">

                        @if(in_array($event->id, $myRegistrations))

                            <div class="w-full text-center py-3 rounded-xl bg-green-50 text-green-700 text-xs font-bold border border-green-100">
                                Registered Successfully ✓
                            </div>

                        @else

                            <form
                                action="{{ route('user.event.register', $event->id) }}"
                                method="POST"
                                class="space-y-2"
                            >

                                @csrf

                                @if(!empty($event->custom_fields))

                                    @foreach($event->custom_fields as $field)

                                        <input
                                            type="text"
                                            name="{{ Str::slug($field, '_') }}"
                                            placeholder="{{ $field }}"
                                            required
                                            class="input-field"
                                        >

                                    @endforeach

                                @endif

                                <button
                                    type="submit"
                                    class="w-full py-3 rounded-xl bg-wine hover:bg-wineDark text-white text-xs font-bold transition"
                                >
                                    Register Now
                                </button>

                            </form>

                        @endif

                    </div>

                </div>

            </div>

        @empty

            <div class="md:col-span-2 xl:col-span-3 cream-card rounded-2xl p-8 text-center">

                <p class="font-bold mt-2">
                    No events available
                </p>

                <p class="text-sm text-muted mt-1">
                    New university events will appear here.
                </p>

            </div>

        @endforelse

    </div>

</section>


<!-- =========================================================
     LOST & FOUND
========================================================= -->

<section id="section-lost" class="page-section">

    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">

        <div>

            <div class="section-label">
                Campus Community
            </div>

            <h2 class="text-2xl sm:text-3xl font-black mt-1">
                Lost & Found
            </h2>

            <p class="text-sm text-muted mt-2">
                Help students find their missing belongings.
            </p>

        </div>


        <button
            id="addLostReportBtn"
            onclick="toggleLostForm()"
            class="px-5 py-3 rounded-xl bg-wine hover:bg-wineDark text-white text-sm font-bold transition"
        >
            <span id="lostFormButtonText">
                + Add Report
            </span>
        </button>

    </div>


    <!-- FORM -->

    <div
        id="lostForm"
        class="hidden soft-card rounded-[24px] sm:rounded-[26px] p-4 sm:p-6 mt-6"
    >

        <div class="flex items-start justify-between gap-4">

            <div>

                <h3 class="font-black text-lg">
                    Report Lost or Found Item
                </h3>

                <p class="text-sm text-muted mt-1">
                    Share the details with the campus community.
                </p>

            </div>

            <button
                type="button"
                onclick="toggleLostForm(false)"
                class="w-9 h-9 rounded-xl border border-creamDark hover:bg-cream font-bold"
            >
                ×
            </button>

        </div>


        <form
            action="{{ route('user.lostfound.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="grid md:grid-cols-2 xl:grid-cols-3 gap-4 mt-5"
        >

            @csrf

            <div>
                <label class="text-xs font-bold">
                    Item Title
                </label>

                <input
                    type="text"
                    name="title"
                    placeholder="e.g. Lost Student ID"
                    required
                    class="input-field"
                >
            </div>


            <div>
                <label class="text-xs font-bold">
                    Location
                </label>

                <input
                    type="text"
                    name="location"
                    placeholder="e.g. Library"
                    required
                    class="input-field"
                >
            </div>


            <div>
                <label class="text-xs font-bold">
                    Date & Time
                </label>

                <input
                    type="datetime-local"
                    name="date_time"
                    required
                    class="input-field"
                >
            </div>


            <div>
                <label class="text-xs font-bold">
                    Contact Number
                </label>

                <input
                    type="text"
                    name="mobile_number"
                    required
                    class="input-field"
                >
            </div>


            <div>
                <label class="text-xs font-bold">
                    Status
                </label>

                <select
                    name="status"
                    class="input-field"
                >
                    <option value="lost">Lost</option>
                    <option value="found">Found</option>
                </select>
            </div>


            <div>
                <label class="text-xs font-bold">
                    Item Image
                </label>

                <input
                    type="file"
                    name="image"
                    class="w-full mt-2 text-xs"
                >
            </div>


            <div class="md:col-span-2 xl:col-span-3">

                <label class="text-xs font-bold">
                    Description
                </label>

                <textarea
                    name="description"
                    rows="3"
                    required
                    placeholder="Describe the item..."
                    class="input-field"
                ></textarea>

            </div>


            <div class="md:col-span-2 xl:col-span-3 flex flex-col sm:flex-row justify-end gap-3">

                <button
                    type="button"
                    onclick="toggleLostForm(false)"
                    class="px-6 py-3 rounded-xl border border-creamDark hover:bg-cream text-sm font-bold"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="px-6 py-3 rounded-xl bg-wine hover:bg-wineDark text-white text-sm font-bold"
                >
                    Publish Report
                </button>

            </div>

        </form>

    </div>


    <!-- FEED -->

    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-5 mt-6">

        @forelse($lostFounds as $item)

            <div
                class="soft-card hover-card rounded-2xl overflow-hidden"
                data-search-item
                data-search-section="lost"
                data-search-text="{{ strtolower($item->title . ' ' . $item->location . ' ' . $item->description . ' ' . $item->status . ' ' . $item->mobile_number) }}"
            >

                @if($item->image)

                    <img
                        src="{{ asset('storage/' . $item->image) }}"
                        class="w-full h-40 sm:h-44 object-cover"
                        alt="{{ $item->title }}"
                        loading="lazy"
                    >

                @else

                    <div class="h-40 sm:h-44 bg-cream flex items-center justify-center text-wine">

                        <svg width="42" height="42" viewBox="0 0 24 24" fill="none">
                            <circle cx="11" cy="11" r="6.5"
                                    stroke="currentColor"
                                    stroke-width="1.7"/>
                            <path d="M16 16L21 21"
                                  stroke="currentColor"
                                  stroke-width="1.7"
                                  stroke-linecap="round"/>
                        </svg>

                    </div>

                @endif


                <div class="p-4 sm:p-5">

                    <div class="flex justify-between gap-3">

                        <h3 class="font-black">
                            {{ $item->title }}
                        </h3>

                        <span class="h-fit px-2.5 py-1 rounded-lg text-[10px] font-bold
                            {{ $item->status === 'lost'
                                ? 'bg-red-50 text-red-700'
                                : 'bg-green-50 text-green-700' }}">

                            {{ ucfirst($item->status) }}

                        </span>

                    </div>


                    <p class="text-xs text-muted mt-3">
                        📍 {{ $item->location }}
                    </p>

                    <p class="text-xs text-muted mt-1">
                        📞 {{ $item->mobile_number }}
                    </p>

                    <p class="text-sm text-muted mt-3 line-clamp-2">
                        {{ $item->description }}
                    </p>

                </div>

            </div>

        @empty

            <div class="md:col-span-2 xl:col-span-3 cream-card rounded-2xl p-8 text-center">

                <p class="font-bold mt-2">
                    No Lost & Found posts
                </p>

                <p class="text-sm text-muted mt-1">
                    Be the first to report an item.
                </p>

            </div>

        @endforelse

    </div>

</section>


<!-- =========================================================
     RESOURCES
========================================================= -->

<section id="section-resources" class="page-section">

    <div>

        <div class="section-label">
            Study Materials
        </div>

        <h2 class="text-2xl sm:text-3xl font-black mt-1">
            Resource Hub
        </h2>

        <p class="text-sm text-muted mt-2">
            Notes and study documents for {{ $user->department }}
        </p>

    </div>


    <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-5 mt-6">

        @forelse($resources as $res)

            <div
                class="resource-card soft-card hover-card rounded-[22px] sm:rounded-[24px] p-4 sm:p-5 flex flex-col min-h-[230px]"
                data-search-item
                data-search-section="resources"
                data-search-text="{{ strtolower($res->title . ' ' . ($res->short_description ?? '') . ' ' . $res->semester) }}"
            >

                <div class="flex items-start justify-between gap-4">

                    <div class="w-12 h-12 rounded-2xl bg-cream flex items-center justify-center text-wine text-xl font-bold shrink-0">

                        <svg width="21" height="21" viewBox="0 0 24 24" fill="none">
                            <path d="M5 4.5C5 3.67 5.67 3 6.5 3H19V19H6.5C5.67 19 5 19.67 5 20.5C5 21.33 5.67 22 6.5 22H19"
                                  stroke="currentColor"
                                  stroke-width="1.7"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path d="M5 20.5V4.5"
                                  stroke="currentColor"
                                  stroke-width="1.7"/>
                        </svg>

                    </div>

                    <span class="px-2.5 py-1 rounded-lg bg-cream text-wine text-[10px] font-bold">
                        {{ $res->semester }}
                    </span>

                </div>


                <div class="mt-5">

                    <h3 class="font-black text-lg line-clamp-2">
                        {{ $res->title }}
                    </h3>

                    <p class="text-sm text-muted mt-2 line-clamp-3">
                        {{ $res->short_description ?? 'Study material available for download.' }}
                    </p>

                </div>


                <div class="mt-auto pt-5 flex items-center justify-between gap-3">

                    <div class="text-[11px] text-muted">
                        Study Resource
                    </div>

                    <a
                        href="{{ asset('storage/' . $res->file_path) }}"
                        target="_blank"
                        rel="noopener"
                        class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-wine hover:bg-wineDark text-white text-xs font-bold transition"
                    >
                        Download
                    </a>

                </div>

            </div>

        @empty

            <div class="sm:col-span-2 xl:col-span-3 cream-card rounded-2xl p-10 text-center">

                <div class="w-14 h-14 rounded-2xl bg-milk border border-creamDark mx-auto flex items-center justify-center text-wine text-xl">
                    ▤
                </div>

                <p class="font-bold mt-4">
                    No study resources found.
                </p>

                <p class="text-sm text-muted mt-1">
                    New notes and study materials will appear here.
                </p>

            </div>

        @endforelse

    </div>

</section>


<!-- =========================================================
     HELPDESK
========================================================= -->







@include('helpdesk')











<!-- EXTRA MOBILE END SPACE -->

<div class="lg:hidden h-12"></div>


</main>

</div>


<!-- =========================================================
     MOBILE BOTTOM NAVIGATION
========================================================= -->

<nav
    class="mobile-bottom-nav lg:hidden fixed bottom-0 left-0 right-0 z-[60] glass border-t border-creamDark shadow-[0_-8px_30px_rgba(70,45,25,.08)]"
>

    <div class="max-w-xl mx-auto grid grid-cols-5 px-1.5 pt-2">

        <!-- Home -->

        <button
            onclick="openSection('home')"
            data-section="home"
            class="mobile-nav active flex flex-col items-center justify-center gap-1 py-2 px-1 rounded-xl text-[10px] font-bold"
        >

            <svg width="21" height="21" viewBox="0 0 24 24" fill="none">
                <path d="M3 10.5L12 3L21 10.5V21H14V15H10V21H3V10.5Z"
                      stroke="currentColor"
                      stroke-width="1.8"
                      stroke-linejoin="round"/>
            </svg>

            Home

        </button>


        <!-- Schedule -->

        <button
            onclick="openSection('schedule')"
            data-section="schedule"
            class="mobile-nav flex flex-col items-center justify-center gap-1 py-2 px-1 rounded-xl text-[10px] font-bold text-ink"
        >

            <svg width="21" height="21" viewBox="0 0 24 24" fill="none">
                <rect x="3" y="4" width="18" height="17" rx="3"
                      stroke="currentColor"
                      stroke-width="1.8"/>
                <path d="M7 2V6M17 2V6M3 9H21"
                      stroke="currentColor"
                      stroke-width="1.8"
                      stroke-linecap="round"/>
            </svg>

            Schedule

        </button>


        <!-- Events -->

        <button
            onclick="openSection('events')"
            data-section="events"
            class="mobile-nav flex flex-col items-center justify-center gap-1 py-2 px-1 rounded-xl text-[10px] font-bold text-ink"
        >

            <svg width="21" height="21" viewBox="0 0 24 24" fill="none">
                <path d="M12 3L14.7 8.4L20.7 9.3L16.35 13.5L17.4 19.5L12 16.65L6.6 19.5L7.65 13.5L3.3 9.3L9.3 8.4L12 3Z"
                      stroke="currentColor"
                      stroke-width="1.7"
                      stroke-linejoin="round"/>
            </svg>

            Events

        </button>


        <!-- Lost -->

        <button
            onclick="openSection('lost')"
            data-section="lost"
            class="mobile-nav flex flex-col items-center justify-center gap-1 py-2 px-1 rounded-xl text-[10px] font-bold text-ink"
        >

            <svg width="21" height="21" viewBox="0 0 24 24" fill="none">
                <circle cx="11" cy="11" r="6.5"
                        stroke="currentColor"
                        stroke-width="1.8"/>
                <path d="M16 16L21 21"
                      stroke="currentColor"
                      stroke-width="1.8"
                      stroke-linecap="round"/>
            </svg>

            Lost

        </button>


        <!-- Help -->

        <button
            onclick="openSection('helpdesk')"
            data-section="helpdesk"
            class="mobile-nav flex flex-col items-center justify-center gap-1 py-2 px-1 rounded-xl text-[10px] font-bold text-ink"
        >

            <svg width="21" height="21" viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="9"
                        stroke="currentColor"
                        stroke-width="1.8"/>
                <path d="M9.5 9.5C9.5 8.12 10.62 7 12 7C13.38 7 14.5 8.12 14.5 9.5C14.5 10.45 14 11.08 13.1 11.7C12.35 12.2 12 12.75 12 13.5"
                      stroke="currentColor"
                      stroke-width="1.8"
                      stroke-linecap="round"/>
                <circle cx="12" cy="17" r="1"
                        fill="currentColor"/>
            </svg>

            Help

        </button>

    </div>

</nav>


<!-- =========================================================
     JAVASCRIPT
========================================================= -->

<script>

/* =========================================================
   SECTION NAVIGATION
========================================================= */

function openSection(section) {

    document.querySelectorAll('.page-section').forEach(function(sectionElement) {
        sectionElement.classList.remove('active');
    });


    const target = document.getElementById('section-' + section);

    if (target) {
        target.classList.add('active');
    }


    /* Desktop sidebar */

    document.querySelectorAll('.nav-item[data-section]').forEach(function(item) {

        item.classList.remove('active');

        if (item.dataset.section === section) {
            item.classList.add('active');
        }

    });


    /* Mobile bottom navigation */

    document.querySelectorAll('.mobile-nav').forEach(function(item) {

        item.classList.remove(
            'bg-wine',
            'text-white'
        );

        item.classList.add('text-ink');

        if (item.dataset.section === section) {

            item.classList.remove('text-ink');

            item.classList.add(
                'bg-wine',
                'text-white'
            );

        }

    });


    /*
     * Do not force an unnecessary smooth animation while searching.
     * Normal section navigation still goes to the top.
     */

    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });

}


/* =========================================================
   MOBILE DRAWER
========================================================= */

function openMobileDrawer() {

    const drawer = document.getElementById('mobileDrawer');
    const overlay = document.getElementById('mobileOverlay');

    if (!drawer || !overlay) {
        return;
    }

    drawer.classList.add('open');
    overlay.classList.add('open');

    document.body.style.overflow = 'hidden';

}


function closeMobileDrawer() {

    const drawer = document.getElementById('mobileDrawer');
    const overlay = document.getElementById('mobileOverlay');

    if (!drawer || !overlay) {
        return;
    }

    drawer.classList.remove('open');
    overlay.classList.remove('open');

    document.body.style.overflow = '';

}


function mobileNavigate(section) {

    openSection(section);

    closeMobileDrawer();

}


/* =========================================================
   MOBILE SEARCH TOGGLE
========================================================= */

function toggleMobileSearch() {

    const row = document.getElementById('mobileSearchRow');

    if (!row) {
        return;
    }

    row.classList.toggle('hidden');

    if (!row.classList.contains('hidden')) {

        setTimeout(function() {

            const input = document.getElementById('mobileGlobalSearch');

            if (input) {
                input.focus();
            }

        }, 100);

    }

}


/* =========================================================
   GLOBAL SEARCH
========================================================= */

let lastSearchValue = '';


function globalSearch(value) {

    const query = String(value || '')
        .trim()
        .toLowerCase();


    lastSearchValue = query;


    /* Keep desktop + mobile inputs synchronized */

    const desktopInput = document.getElementById('globalSearch');
    const mobileInput = document.getElementById('mobileGlobalSearch');

    if (desktopInput && desktopInput.value !== value) {
        desktopInput.value = value;
    }

    if (mobileInput && mobileInput.value !== value) {
        mobileInput.value = value;
    }


    /* Clear button */

    const clearButton = document.getElementById('clearSearchBtn');

    if (clearButton) {

        if (query.length > 0) {

            clearButton.classList.remove('hidden');
            clearButton.classList.add('flex');

        } else {

            clearButton.classList.add('hidden');
            clearButton.classList.remove('flex');

        }

    }


    const status = document.getElementById('globalSearchStatus');
    const countElement = document.getElementById('globalSearchCount');


    /*
     * Empty search:
     * restore every searchable item.
     */

    if (!query) {

        document.querySelectorAll('[data-search-item]').forEach(function(item) {

            item.classList.remove(
                'search-hidden',
                'search-highlight'
            );

        });

        if (status) {
            status.classList.add('hidden');
        }

        return;
    }


    let resultCount = 0;
    let firstResult = null;
    let firstSection = null;


    document.querySelectorAll('[data-search-item]').forEach(function(item) {

        const searchableText = String(
            item.dataset.searchText || item.textContent || ''
        ).toLowerCase();


        const matched = searchableText.includes(query);


        if (matched) {

            item.classList.remove('search-hidden');
            item.classList.add('search-highlight');

            resultCount++;


            if (!firstResult) {
                firstResult = item;
                firstSection = item.dataset.searchSection || null;
            }

        } else {

            item.classList.add('search-hidden');
            item.classList.remove('search-highlight');

        }

    });


    if (status) {
        status.classList.remove('hidden');
    }


    if (countElement) {

        countElement.textContent =
            resultCount +
            (resultCount === 1 ? ' result' : ' results');

    }


    /*
     * If something is found in another section, automatically
     * switch to that section.
     */

    if (firstResult && firstSection) {

        const currentSection =
            document.querySelector('.page-section.active');

        const currentSectionId =
            currentSection
                ? currentSection.id.replace('section-', '')
                : null;


        if (currentSectionId !== firstSection) {

            document.querySelectorAll('.page-section').forEach(function(section) {
                section.classList.remove('active');
            });


            const target =
                document.getElementById('section-' + firstSection);


            if (target) {
                target.classList.add('active');
            }


            /* Update desktop sidebar */

            document.querySelectorAll('.nav-item[data-section]').forEach(function(item) {

                item.classList.remove('active');

                if (item.dataset.section === firstSection) {
                    item.classList.add('active');
                }

            });


            /* Update bottom nav */

            document.querySelectorAll('.mobile-nav').forEach(function(item) {

                item.classList.remove('bg-wine', 'text-white');
                item.classList.add('text-ink');

                if (item.dataset.section === firstSection) {

                    item.classList.remove('text-ink');

                    item.classList.add(
                        'bg-wine',
                        'text-white'
                    );

                }

            });

        }

    }


    /*
     * Remove highlight after a short period.
     * Search filtering remains active.
     */

    clearTimeout(window.searchHighlightTimer);

    window.searchHighlightTimer = setTimeout(function() {

        document.querySelectorAll('.search-highlight').forEach(function(item) {
            item.classList.remove('search-highlight');
        });

    }, 900);

}


/* =========================================================
   CLEAR GLOBAL SEARCH
========================================================= */

function clearGlobalSearch() {

    lastSearchValue = '';


    const desktopInput = document.getElementById('globalSearch');
    const mobileInput = document.getElementById('mobileGlobalSearch');


    if (desktopInput) {
        desktopInput.value = '';
    }


    if (mobileInput) {
        mobileInput.value = '';
    }


    document.querySelectorAll('[data-search-item]').forEach(function(item) {

        item.classList.remove(
            'search-hidden',
            'search-highlight'
        );

    });


    const status = document.getElementById('globalSearchStatus');

    if (status) {
        status.classList.add('hidden');
    }


    const clearButton = document.getElementById('clearSearchBtn');

    if (clearButton) {
        clearButton.classList.add('hidden');
        clearButton.classList.remove('flex');
    }

}


/* =========================================================
   LOST & FOUND FORM
========================================================= */

function toggleLostForm(forceOpen = null) {

    const form = document.getElementById('lostForm');
    const button = document.getElementById('addLostReportBtn');
    const buttonText = document.getElementById('lostFormButtonText');

    if (!form) {
        return;
    }


    const currentlyHidden = form.classList.contains('hidden');

    const shouldOpen =
        forceOpen === null
            ? currentlyHidden
            : forceOpen;


    if (shouldOpen) {

        form.classList.remove('hidden');

        if (button) {

            button.classList.remove('bg-wine');

            button.classList.add('bg-ink');

        }

        if (buttonText) {

            buttonText.textContent = '× Close Form';

        }


        setTimeout(function() {

            form.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

        }, 80);

    } else {

        form.classList.add('hidden');

        if (button) {

            button.classList.remove('bg-ink');

            button.classList.add('bg-wine');

        }

        if (buttonText) {

            buttonText.textContent = '+ Add Report';

        }

    }

}


/* =========================================================
   OPEN LOST + REPORT
========================================================= */

function openLostReport() {

    openSection('lost');

    setTimeout(function() {

        toggleLostForm(true);

    }, 150);

}


/* =========================================================
   ESCAPE KEY
========================================================= */

document.addEventListener('keydown', function(event) {

    if (event.key === 'Escape') {

        closeMobileDrawer();

    }

});


/* =========================================================
   SEARCH KEYBOARD SHORTCUT
   Ctrl + K / Cmd + K
========================================================= */

document.addEventListener('keydown', function(event) {

    if (
        (event.ctrlKey || event.metaKey) &&
        event.key.toLowerCase() === 'k'
    ) {

        event.preventDefault();


        if (window.innerWidth < 768) {

            const row = document.getElementById('mobileSearchRow');

            if (row) {
                row.classList.remove('hidden');
            }


            const input =
                document.getElementById('mobileGlobalSearch');

            if (input) {
                input.focus();
            }

        } else {

            const input =
                document.getElementById('globalSearch');

            if (input) {
                input.focus();
            }

        }

    }

});


/* =========================================================
   INITIAL STATE
========================================================= */

document.addEventListener('DOMContentLoaded', function() {

    openSection('home');

});


/* =========================================================
   RESIZE SAFETY
========================================================= */

window.addEventListener('resize', function() {

    if (window.innerWidth >= 1024) {

        closeMobileDrawer();

    }

});


/* =========================================================
   PREVENT BODY LOCK AFTER MOBILE DRAWER
========================================================= */

window.addEventListener('pageshow', function() {

    document.body.style.overflow = '';

});


</script>

</body>
</html>