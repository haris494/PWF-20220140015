<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Hanya admin yang bisa update, dan hanya produk miliknya sendiri.
     */
    public function update(User $user, Product $product): bool
    {
        return $user->role === 'admin' && $user->id === $product->user_id;
    }

    /**
     * Hanya admin yang bisa delete, dan hanya produk miliknya sendiri.
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->role === 'admin' && $user->id === $product->user_id;
    }
}
