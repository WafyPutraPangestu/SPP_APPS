<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ForgotPassword extends Component
{
    public string $email = '';

    public function sendResetLink(): void
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('success', 'Link reset password telah dikirim ke email Anda. Silakan cek inbox atau folder spam.');
            $this->email = '';
        } else {
            $this->addError('email', 'Email tidak ditemukan di sistem kami.');
        }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
