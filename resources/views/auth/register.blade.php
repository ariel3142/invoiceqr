<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 p-4">
        <div class="w-full max-w-md bg-white/90 backdrop-blur-lg rounded-2xl shadow-2xl p-8 transform transition-all duration-500 hover:scale-[1.02] animate-fadeIn">

            {{-- TITLE --}}
            <h2 class="text-4xl font-extrabold text-gray-800 mb-2 text-center">Create Account</h2>
            <p class="text-gray-500 text-center mb-6">Join us today and start your journey</p>

            {{-- VALIDATION ERRORS --}}
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            {{-- REGISTER FORM --}}
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                        class="w-full border border-gray-300 rounded-xl shadow-sm px-4 py-2.5 focus:ring-2 focus:ring-indigo-400 focus:outline-none transition"
                        placeholder="John Doe">
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        class="w-full border border-gray-300 rounded-xl shadow-sm px-4 py-2.5 focus:ring-2 focus:ring-indigo-400 focus:outline-none transition"
                        placeholder="you@example.com">
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative flex items-center">
                        <input id="password" name="password" type="password" required
                            class="w-full border border-gray-300 rounded-xl shadow-sm px-4 py-2.5 pr-12 focus:ring-2 focus:ring-indigo-400 focus:outline-none transition"
                            placeholder="Enter your password">
                        <button type="button" id="togglePassword"
                            class="absolute right-4 text-gray-500 hover:text-indigo-600 focus:outline-none">
                        </button>
                    </div>
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <div class="relative flex items-center">
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            class="w-full border border-gray-300 rounded-xl shadow-sm px-4 py-2.5 pr-12 focus:ring-2 focus:ring-indigo-400 focus:outline-none transition"
                            placeholder="Re-enter your password">
                        <button type="button" id="toggleConfirmPassword"
                            class="absolute right-4 text-gray-500 hover:text-indigo-600 focus:outline-none">
                        </button>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="mt-6">
                    <button type="submit"
                        class="w-full border-2 border-indigo-500 bg-indigo-600 text-white font-semibold py-3 rounded-xl
                shadow-md hover:bg-indigo-700 hover:border-indigo-700 transition duration-300 ease-in-out
                focus:outline-none focus:ring-4 focus:ring-indigo-300 active:scale-[0.98]">
                        Register
                    </button>
                </div>

                {{-- Already Registered --}}
                <p class="text-center text-sm text-gray-600 mt-6">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Sign in</a>
                </p>
            </form>
        </div>
    </div>

    {{-- JS for password toggle --}}
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeConfirmIcon = document.getElementById('eyeConfirmIcon');

        function toggleVisibility(input, icon) {
            const type = input.type === 'password' ? 'text' : 'password';
            input.type = type;
            icon.outerHTML = type === 'password'
                ? `<svg xmlns="http://www.w3.org/2000/svg" id="${icon.id}" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>`
                : `<svg xmlns="http://www.w3.org/2000/svg" id="${icon.id}" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.98 8.223A10.477 10.477 0 012.458 12C3.732 16.057 7.523 19 12 19c1.72 0 3.358-.37 4.828-1.028M9.88 9.88A3 3 0 0114.12 14.12M6.228 6.228l11.544 11.544" />
                </svg>`;
        }

        togglePassword.addEventListener('click', () => toggleVisibility(passwordInput, eyeIcon));
        toggleConfirmPassword.addEventListener('click', () => toggleVisibility(confirmPasswordInput, eyeConfirmIcon));
    </script>

    {{-- Tailwind animation --}}
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fadeIn {
            animation: fadeIn 0.8s ease-out forwards;
        }
    </style>
</x-guest-layout>
