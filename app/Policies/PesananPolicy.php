<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Pesanan;

class PesananPolicy
{
    public function view(User $user, Pesanan $pesanan): bool
    {
        return $user->id === $pesanan->pembeli_id
            || $user->id === optional($pesanan->mitra)->user_id; // izinkan mitra juga
    }


    public function update(User $user, Pesanan $pesanan): bool
    {
        return $user->id === $pesanan->pembeli_id
            || $user->id === optional($pesanan->mitra)->user_id;
    }

}
