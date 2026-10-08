<x-guest-layout>
   <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
    @csrf

    <!-- Name -->
    <div>
        <x-input-label for="name" :value="__('Full Name')" />
        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- Email Address -->
    <div class="mt-4">
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Mobile Number -->
    <div class="mt-4">
        <x-input-label for="mobile_number" :value="__('Mobile Number')" />
        <x-text-input id="mobile_number" class="block mt-1 w-full" type="text" name="mobile_number" :value="old('mobile_number')" required />
        <x-input-error :messages="$errors->get('mobile_number')" class="mt-2" />
    </div>

    <!-- Student ID -->
    <div class="mt-4">
        <x-input-label for="student_id" :value="__('Student ID')" />
        <x-text-input id="student_id" class="block mt-1 w-full" type="text" name="student_id" :value="old('student_id')" required />
        <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
    </div>

    <!-- Department -->
    <div class="mt-4">
        <x-input-label for="department" :value="__('Department')" />
        <x-text-input id="department" class="block mt-1 w-full" type="text" name="department" :value="old('department')" required />
        <x-input-error :messages="$errors->get('department')" class="mt-2" />
    </div>

    <!-- Batch No -->
    <div class="mt-4">
        <x-input-label for="batch_no" :value="__('Batch No')" />
        <x-text-input id="batch_no" class="block mt-1 w-full" type="text" name="batch_no" :value="old('batch_no')" required />
        <x-input-error :messages="$errors->get('batch_no')" class="mt-2" />
    </div>

    <!-- Profile Picture (Optional) -->
    <div class="mt-4">
        <x-input-label for="profile_pic" :value="__('Profile Picture (Optional)')" />
        <input id="profile_pic" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none" type="file" name="profile_pic">
        <x-input-error :messages="$errors->get('profile_pic')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="mt-4">
        <x-input-label for="password" :value="__('Password')" />
        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Confirm Password -->
    <div class="mt-4">
        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <div class="flex items-center justify-end mt-4">
        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
            {{ __('Already registered?') }}
        </a>

        <x-primary-button class="ms-4">
            {{ __('Register') }}
        </x-primary-button>
    </div>
</form>
</x-guest-layout>
