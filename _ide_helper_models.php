<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $role
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\siswa> $siswa
 * @property-read int|null $siswa_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id_kategori
 * @property string $tahun_ajaran
 * @property int $nominal_spp
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\tagihan> $tagihan
 * @property-read int|null $tagihan_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|kategori_spp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|kategori_spp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|kategori_spp query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|kategori_spp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|kategori_spp whereIdKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|kategori_spp whereNominalSpp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|kategori_spp whereTahunAjaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|kategori_spp whereUpdatedAt($value)
 */
	class kategori_spp extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id_pembayaran
 * @property string $order_id
 * @property int $id_tagihan
 * @property int $jumlah_bayar
 * @property string|null $snap_token
 * @property string|null $midtrans_transaction_id
 * @property string|null $metode_bayar
 * @property string $status_pembayaran
 * @property \Illuminate\Support\Carbon|null $waktu_pembayaran
 * @property array<array-key, mixed>|null $callback_payload
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\tagihan $tagihan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pembayaran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pembayaran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pembayaran query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pembayaran whereCallbackPayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pembayaran whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pembayaran whereIdPembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pembayaran whereIdTagihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pembayaran whereJumlahBayar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pembayaran whereMetodeBayar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pembayaran whereMidtransTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pembayaran whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pembayaran whereSnapToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pembayaran whereStatusPembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pembayaran whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|pembayaran whereWaktuPembayaran($value)
 */
	class pembayaran extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id_siswa
 * @property int $id_user
 * @property string $nis
 * @property string $nama_siswa
 * @property string $kelas
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\tagihan> $tagihan
 * @property-read int|null $tagihan_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|siswa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|siswa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|siswa query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|siswa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|siswa whereIdSiswa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|siswa whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|siswa whereKelas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|siswa whereNamaSiswa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|siswa whereNis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|siswa whereUpdatedAt($value)
 */
	class siswa extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id_tagihan
 * @property int $id_siswa
 * @property int $id_kategori
 * @property string $bulan
 * @property int $tahun
 * @property string $status_tagihan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\kategori_spp $kategori_spp
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\pembayaran> $pembayaran
 * @property-read int|null $pembayaran_count
 * @property-read \App\Models\siswa $siswa
 * @method static \Illuminate\Database\Eloquent\Builder<static>|tagihan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|tagihan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|tagihan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|tagihan whereBulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|tagihan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|tagihan whereIdKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|tagihan whereIdSiswa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|tagihan whereIdTagihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|tagihan whereStatusTagihan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|tagihan whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|tagihan whereUpdatedAt($value)
 */
	class tagihan extends \Eloquent {}
}

