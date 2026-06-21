<?php

use Illuminate\Support\Facades\Broadcast;

// Prywatny kanał powiadomień użytkownika (domyślny kanał notyfikacji Laravel).
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Prywatny kanał konwersacji — dostęp tylko dla obu jej stron.
Broadcast::channel('conversation.{a}.{b}', function ($user, $a, $b) {
    return in_array((int) $user->id, [(int) $a, (int) $b], true);
});

// Kanał wątku jest publiczny (dla zalogowanych) — definiowany po stronie klienta jako Echo.channel().
