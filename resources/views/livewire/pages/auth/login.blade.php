<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\Attributes\On;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    public string $captchaInput = '';
    public string $captchaText = '';
    public string $recaptchaToken = '';

    public function mount(): void
    {
        $this->generateCaptcha();
    }

    public function generateCaptcha(): void
    {
        $this->captchaText = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijklmnpqrstuvwqyz0123456789'), 0, 6);
        Session::put('captcha_value', $this->captchaText);
    }

    #[On('recaptchaToken')]
    public function setRecaptchaToken(string $token): void
    {
        $this->recaptchaToken = $token;
    }

    public function login(): void
    {
        // public function login()
        $this->validate([
            'form.email' => 'required|email',
            'form.password' => 'required',
            'captchaInput' => 'required',
        ]);

        // 1. Cek captcha manual
        if (strtolower($this->captchaInput) !== strtolower(Session::get('captcha_value'))) {
            $this->addError('captchaInput', 'Captcha manual tidak cocok.');
            $this->generateCaptcha(); // regenerate ulang
            return;
        }

        // 2. Cek Google reCAPTCHA
        if (!$this->verifyRecaptcha($this->recaptchaToken)) {
            $this->addError('form.email', 'Verifikasi Google reCAPTCHA gagal.');
            return;
        }

        $this->form->authenticate();
        Session::regenerate();

        session()->flash('success', 'Selamat datang! Anda berhasil login.');

        // Dengan Wire Navigate
        // $this->redirectIntended(default: route('dashboard.index'), navigate: true);
        // $this->redirectIntended(default: route('dashboard.index', absolute: false), navigate: true);

        // Tanpa Wire Navigate
        // return $this->redirectIntended(route('dashboard.index'));
        $this->redirectIntended(default: route('dashboard.index', absolute: false), navigate: false);
    }

    private function verifyRecaptcha(string $token): bool
    {
        $secret = config('services.recaptcha.secret');
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secret,
            'response' => $token,
        ]);

        $result = $response->json();
        return $result['success'] === true && $result['score'] >= 0.5;
    }
}; ?>

<div>
    {{-- <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script> --}}

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="px-2 sm:px-4 max-w-md mx-auto">
        {{-- <form wire:submit="login" class="login-form"> --}}
        <form wire:submit.prevent="login" class="login-form">
            <!-- Email -->
            {{-- <div>
                <x-input-label for="email" :value="__('Email *')" />
                <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" required
                    autofocus />
                <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
            </div> --}}

            <!-- Password -->
            {{-- <div class="mt-4">
                <x-input-label for="password" :value="__('Password *')" />
                <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full" type="password"
                    required />
                <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
            </div> --}}

            <!-- Username -->
            <div class="mt-4">
                <x-input-label for="username" :value="__('Username *')" />
                <div class="relative">
                    <input wire:model="form.email" id="email" type="text" required
                        class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                </div>
                <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4" x-data="{ show: false }">
                <x-input-label for="password" :value="__('Password *')" />
                <div class="relative">
                    <input :type="show ? 'text' : 'password'" wire:model="form.password" id="password" required
                        class="block mt-1 w-full rounded-lg border-gray-300 pr-10 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                    <!-- Tombol mata -->
                    <button type="button" @click="show = !show"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5" tabindex="-1">
                        <!-- Icon Show -->
                        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <!-- Icon Hide -->
                        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a10.05 10.05 0 013.422-4.775m3.472-1.695A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.956 9.956 0 01-1.507 2.572M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
            </div>

            <!-- Captcha -->
            <div class="mt-4">
                <x-input-label for="captcha" :value="__('Captcha *')" />
                <div
                    class="preview rounded border text-center py-2 my-2 bg-gray-100 text-lg tracking-widest select-none">
                    @foreach (str_split($captchaText) as $char)
                        <span
                            style="transform: rotate({{ rand(-20, 20) }}deg); display: inline-block;">{{ $char }}</span>
                    @endforeach
                </div>
                <div class="captcha-form flex">
                    <input type="text" id="captcha" wire:model="captchaInput" placeholder="Masukkan captcha"
                        class="block w-full border rounded-l px-3 py-1">
                    <button type="button" wire:click="generateCaptcha" class="bg-gray-500 text-white px-3 rounded-r">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                            <path fill-rule="evenodd"
                                d="M15.312 11.424a5.5 5.5 0 0 1-9.201 2.466l-.312-.311h2.433a.75.75 0 0 0 0-1.5H3.989a.75.75 0 0 0-.75.75v4.242a.75.75 0 0 0 1.5 0v-2.43l.31.31a7 7 0 0 0 11.712-3.138.75.75 0 0 0-1.449-.39Zm1.23-3.723a.75.75 0 0 0 .219-.53V2.929a.75.75 0 0 0-1.5 0V5.36l-.31-.31A7 7 0 0 0 3.239 8.188a.75.75 0 1 0 1.448.389A5.5 5.5 0 0 1 13.89 6.11l.311.31h-2.432a.75.75 0 0 0 0 1.5h4.243a.75.75 0 0 0 .53-.219Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('captchaInput')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember" class="inline-flex items-center">
                    <input wire:model="form.remember" id="remember" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Forgot password?') }}
                    </a>
                @endif

                {{-- <x-primary-button class="ms-3">
                    {{ __('Log in') }}
                </x-primary-button> --}}

                {{-- <x-primary-button class="ms-3" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="login">Log in</span>
                    <span wire:loading wire:target="login" class="flex items-center justify-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 25 25">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Loading...
                    </span>
                </x-primary-button> --}}

                <x-primary-button class="ms-3" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="login">Log in</span>
                    <span wire:loading wire:target="login">
                        Loading...
                    </span>
                </x-primary-button>
            </div>
        </form>

        <footer class="py-2 mt-5 text-center text-xs text-black dark:text-black/70">
            &copy; 2025
            @if (now()->year != 2025)
                - {{ now()->year }}
            @endif
            | PENAKs`E <a href="https://inspektorat.wonosobokab.go.id" target="_blank"
                class="text-blue-600 hover:underline">Inspektorat Daerah Kabupaten
                Wonosobo</a><br>Powered by <a href="https://diskominfo.wonosobokab.go.id/" target="_blank"
                class="text-blue-600 hover:underline">Diskominfo</a> |
            Mas@guNk86
        </footer>

    </div>
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.sitekey') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ config('services.recaptcha.sitekey') }}', {
                    action: 'login'
                }).then(function(token) {
                    Livewire.dispatch('recaptchaToken', {
                        token: token
                    });
                });
            });
        });
    </script>
</div>
