<x-guest-layout>
    <div class="mb-8 overflow-hidden">
        <h3 class="text-2xl font-bold text-earth-900 mb-2">Đăng ký thành viên</h3>
        <p class="text-earth-500 text-sm">Tham gia cùng chúng tôi để nhận những ưu đãi đặc biệt.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Họ và tên của bạn')" class="text-earth-700 font-semibold mb-2" />
            <x-text-input id="name" class="block w-full py-3 px-4" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nguyễn Văn A" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-earth-700 font-semibold mb-2" />
            <x-text-input id="email" class="block w-full py-3 px-4" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="example@gmail.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Mật khẩu')" class="text-earth-700 font-semibold mb-2" />
            <x-text-input id="password" class="block w-full py-3 px-4"
                            type="password"
                            name="password"
                            required autocomplete="new-password"
                            placeholder="Tối thiểu 8 ký tự" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Xác nhận mật khẩu')" class="text-earth-700 font-semibold mb-2" />
            <x-text-input id="password_confirmation" class="block w-full py-3 px-4"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Nhập lại mật khẩu" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4">
            <x-primary-button class="w-full justify-center py-4 text-sm tracking-widest">
                {{ __('ĐĂNG KÝ NGAY') }}
            </x-primary-button>
        </div>

        <div class="mt-8 text-center border-t border-beige-100 pt-6">
            <p class="text-sm text-earth-500 font-medium">
                Đã có tài khoản? 
                <a href="{{ route('login') }}" class="text-sepia-600 font-bold hover:underline">Đăng nhập ngay</a>
            </p>
        </div>
    </form>
</x-guest-layout>

