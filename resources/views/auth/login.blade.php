<x-guest-layout>
    <div class="flex min-h-screen bg-white">
        <div class="flex flex-col justify-center flex-1 px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="w-full max-w-sm mx-auto lg:w-96">
                <div>
                    <img class="w-auto h-12" src="{{ asset('img/sksulogo.png') }}" alt="Workflow">
                    <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                        Sign in to your accounts
                    </h2>
                    <x-jet-validation-errors class="mb-4" />
                    @if (session('status'))
                    <div class="mb-4 text-sm font-medium text-green-600">
                        {{ session('status') }}
                    </div>
                    @endif
                </div>

                <div class="mt-8">
                    <div class="mt-6">
                        <form action="{{ route('login') }}" method="POST" class="space-y-6">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">
                                    Email address
                                </label>
                                <div class="mt-1">
                                    <input id="email" autofocus value="{{ old('email') }}" name="email" type="email" autocomplete="email" required class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label for="password" class="block text-sm font-medium text-gray-700">
                                    Password
                                </label>
                                <div class="mt-1">
                                    <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input id="remember" name="remember" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    <label for="remember" class="block ml-2 text-sm text-gray-900">
                                        Remember me
                                    </label>
                                </div>
                                {{--
                                @if (Route::has('password.request'))
                                <div class="text-sm">
                                    <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                                Forgot your password?
                                </a>
                            </div>
                            @endif --}}

                    </div>

                    <div>
                        <button type="submit" class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Sign in
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="relative flex-1 hidden w-0 lg:block">
        <img class="absolute inset-0 object-cover w-full h-full" src="{{ asset('img/bg.webp') }}" alt="">
        <img src="{{ asset('img/leina.webp') }}" alt="leina image" class="absolute w-44 top-5 right-10">
    </div>
    </div>
</x-guest-layout>
