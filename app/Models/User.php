<?php
// ── App\Models\User ──────────────────────────────────────────────

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;

#[Fillable(['role', 'name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function siswa()
    {
        // foreign key di tabel siswas = id_user
        // local key di tabel users   = id  (bukan id_user!)
        return $this->hasMany(Siswa::class, 'id_user', 'id');
    }

    /**
     * Kirim email reset password menggunakan template custom.
     */
    public function sendPasswordResetNotification($token): void
    {
        $url = url(route('password.reset', [
            'token' => $token,
            'email' => $this->email,
        ], false));

        Mail::send('emails.reset-password', ['url' => $url], function ($message) {
            $message->to($this->email)
                    ->subject('Reset Password — Ponpes La-Taksal');
        });
    }
}
