<x-guest-layout>
    <div class="mb-8 overflow-hidden">
        <h3 class="text-2xl font-bold text-earth-900 mb-2">Đăng nhập</h3>
        <p class="text-earth-500 text-sm">Chào mừng bạn quay trở lại với cửa hàng của chúng tôi.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email của bạn')" class="text-earth-700 font-semibold mb-2" />
            <x-text-input id="email" class="block w-full py-3 px-4" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="example@gmail.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <x-input-label for="password" :value="__('Mật khẩu')" class="text-earth-700 font-semibold" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-bold text-sepia-600 hover:text-sepia-700 transition-colors" href="{{ route('password.request') }}">
                        {{ __('Quên mật khẩu?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block w-full py-3 px-4"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="rounded-lg border-beige-300 text-sepia-600 shadow-sm focus:ring-sepia-500 focus:ring-offset-0 w-5 h-5 transition-all" name="remember">
                <span class="ml-3 text-sm text-earth-600 font-medium group-hover:text-sepia-700 transition-colors">{{ __('Ghi nhớ đăng nhập') }}</span>
            </label>
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-4 text-sm tracking-widest">
                {{ __('ĐĂNG NHẬP NGAY') }}
            </x-primary-button>
        </div>

        <div class="mt-8 text-center border-t border-beige-100 pt-6">
            <p class="text-sm text-earth-500 font-medium">
                Chưa có tài khoản? 
                <a href="{{ route('register') }}" class="text-sepia-600 font-bold hover:underline">Đăng ký ngay</a>
            </p>
        </div>
    </form>
</x-guest-layout>

