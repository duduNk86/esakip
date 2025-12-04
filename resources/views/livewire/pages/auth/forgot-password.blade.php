<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\Attributes\On;

new #[Layout('layouts.guest')] class extends Component {
    public string $email = '';
    public string $nowa = '';
    public string $captchaInput = '';
    public string $captchaText = '';
    public string $recaptchaToken = '';

    public function mount(): void
    {
        $this->generateCaptcha();
    }

    #[On('recaptchaToken')]
    public function setRecaptchaToken(string $token): void
    {
        $this->recaptchaToken = $token;
    }

    public function generateCaptcha(): void
    {
        $this->captchaText = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijklmnopqrstuvwqyz0123456789'), 0, 6);
        session()->put('captcha_value', $this->captchaText);
    }

    private function normalizePhoneNumber($number)
    {
        $number = preg_replace('/\D/', '', $number);

        if (substr($number, 0, 1) == '0') {
            $number = '62' . substr($number, 1);
        }

        return $number;
    }

    private function generateSecurePassword(int $length = 8): string
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $password;
    }

    public function submit(): void
    {
        $this->validate([
            'email' => 'required|email',
            'nowa' => 'required',
            'captchaInput' => 'required',
        ]);

        if (strtolower($this->captchaInput) !== strtolower(session('captcha_value'))) {
            $this->addError('captchaInput', 'Captcha tidak cocok!');
            $this->generateCaptcha();
            return;
        }

        if (!$this->verifyRecaptcha($this->recaptchaToken)) {
            $this->addError('email', 'Verifikasi Google reCAPTCHA gagal!');
            return;
        }

        $user = User::where('email', $this->email)
            ->where('nowa', $this->normalizePhoneNumber($this->nowa))
            ->first();

        if (!$user) {
            $this->addError('email', 'Data tidak ditemukan!');
            return;
        }

        $newPassword = $this->generateSecurePassword(8);
        $user->password = Hash::make($newPassword);
        $user->save();

        $this->sendWhatsapp($user->nowa, $newPassword);

        session()->flash('status', 'Sukses! Password berhasil di reset dan Password baru telah dikirimkan ke nomor WhatsApp Anda.');
        $this->reset(['email', 'nowa', 'captchaInput', 'recaptchaToken']);
        $this->generateCaptcha();
    }

    private function sendWhatsapp(string $nomor, string $passwordBaru): void
    {
        $curl = curl_init();
        $token = config('services.wablas.token');
        $url = config('services.wablas.endpoint');
        $random = true;

        $payload = [
            'data' => [
                [
                    'phone' => $nomor,
                    'message' => "Halo, password baru akun e-SAKIP Anda: *{$passwordBaru}*. Segera login dan ganti password.",
                ],
            ],
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER, ["Authorization: $token", 'Content-Type: application/json']);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($curl);
        curl_close($curl);
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
};
?>

<div>
    <div class="max-w-md mx-auto px-2 sm:px-4">
        {{-- <h2 class="text-lg font-semibold text-gray-600 mb-3 text-center">Lupa Password</h2> --}}

        @if (session('status'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form wire:submit="submit" class="forgotpassword-form">

            <div class="mb-4">
                <x-input-label for="email" value="Email *" class="mb-1" />
                <x-text-input type="email" wire:model="email" class="w-full" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="nowa" value="WhatsApp *" class="mb-1" />
                <x-text-input type="text" wire:model="nowa" class="w-full" placeholder="08xxxxxxxxxx" />
                <x-input-error :messages="$errors->get('nowa')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="captchaInput" value="Captcha *" />
                <div class="bg-gray-100 border rounded text-center py-2 my-2 text-lg tracking-widest select-none">
                    @foreach (str_split($captchaText) as $char)
                        <span
                            style="transform: rotate({{ rand(-20, 20) }}deg); display:inline-block;">{{ $char }}</span>
                    @endforeach
                </div>
                <div class="flex">
                    <input type="text" wire:model="captchaInput" placeholder="Masukkan captcha"
                        class="w-full rounded-l border px-3 py-1" />
                    <button type="button" wire:click="generateCaptcha" class="bg-gray-600 text-white px-3 rounded-r">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                            <path fill-rule="evenodd"
                                d="M15.312 11.424a5.5 5.5 0 0 1-9.201 2.466l-.312-.311h2.433a.75.75 0 0 0 0-1.5H3.989a.75.75 0 0 0-.75.75v4.242a.75.75 0 0 0 1.5 0v-2.43l.31.31a7 7 0 0 0 11.712-3.138.75.75 0 0 0-1.449-.39Zm1.23-3.723a.75.75 0 0 0 .219-.53V2.929a.75.75 0 0 0-1.5 0V5.36l-.31-.31A7 7 0 0 0 3.239 8.188a.75.75 0 1 0 1.448.389A5.5 5.5 0 0 1 13.89 6.11l.311.31h-2.432a.75.75 0 0 0 0 1.5h4.243a.75.75 0 0 0 .53-.219Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('captchaInput')" class="mt-2" />
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="/" wire:navigate>
                    {{ __('Log in?') }}
                </a>
                <x-primary-button class="ms-3">
                    {{ __('Send New Password') }}
                </x-primary-button>
            </div>
        </form>

        <footer class="py-2 mt-5 text-center text-xs text-black dark:text-black/70">
            &copy; 2025
            @if (now()->year != 2025)
                - {{ now()->year }}
            @endif
            | PENAKs`E <a href="https://inspektorat.wonosobokab.go.id" target="_blank"
                class="text-blue-600 hover:underline">Inspektorat
                Daerah Kabupaten
                Wonosobo</a><br>Powered by <a href="https://diskominfo.wonosobokab.go.id/" target="_blank"
                class="text-blue-600 hover:underline">Diskominfo</a> |
            Mas@guNk86
        </footer>
    </div>

    {{-- reCAPTCHA v3 --}}
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.sitekey') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ config('services.recaptcha.sitekey') }}', {
                    action: 'forgot_password'
                }).then(function(token) {
                    Livewire.dispatch('recaptchaToken', {
                        token: token
                    });
                });
            });
        });
    </script>
</div>
