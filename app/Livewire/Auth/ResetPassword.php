<?php

namespace App\Livewire\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Component;

class ResetPassword extends Component
{
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(string $token): void
    {
        $this->token = $token;
        $this->email = request()->query('email', '');
    }

    public function resetPassword(): void
    {
        $this->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'email.required'     => 'Email wajib diisi.',
        ]);

        $status = Password::reset(
            [
                'email'                 => $this->email,
                'password'              => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token'                 => $this->token,
            ],
            function ($user, string $password) {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('message', 'Password berhasil direset! Silakan login dengan password baru Anda.');
            $this->redirect(route('login'));
        } else {
            $this->addError('email', match ($status) {
                Password::INVALID_TOKEN => 'Link reset sudah kadaluarsa atau tidak valid. Silakan minta link baru.',
                Password::INVALID_USER  => 'Email tidak ditemukan di sistem kami.',
                default                 => 'Terjadi kesalahan. Silakan coba lagi.',
            });
        }
    }

    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}
