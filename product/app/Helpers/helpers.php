<?php

use App\Models\User;

if (!function_exists('user_id')) {
    function user_id(): ?int
    {
        return session('user_id') ?? session('user')['id'] ?? null;
    }
}

if (!function_exists('current_user')) {
    function current_user(): ?User
    {
        $id = session('user_id') ?? session('user')['id'] ?? null;
        return $id ? User::find($id) : null;
    }
}

if (!function_exists('is_logged_in')) {
    function is_logged_in(): bool
    {
        return session()->has('user');
    }
}