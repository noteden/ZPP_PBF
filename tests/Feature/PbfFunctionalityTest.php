<?php

use App\Enums\PostTag;
use App\Enums\UserRole;
use App\Livewire\Character\Create as CharacterCreate;
use App\Livewire\Forum\ThreadCreate;
use App\Livewire\Missions\Index as MissionsIndex;
use App\Livewire\Tools\Conflict;
use App\Models\Category;
use App\Models\Charakter;
use App\Models\Forum;
use App\Models\Mission;
use App\Models\User;
use Livewire\Livewire;

function player(array $attrs = []): User
{
    return User::factory()->create(array_merge(['role' => UserRole::Player, 'approved' => true], $attrs));
}

function moderator(): User
{
    return User::factory()->create(['role' => UserRole::GameMaster, 'approved' => true]);
}

// --- Bramka zatwierdzania kont ---
test('niezatwierdzony użytkownik jest przekierowany na stronę oczekiwania', function () {
    $user = player(['approved' => false]);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertRedirect(route('pending-approval'));
});

test('zatwierdzony użytkownik widzi dashboard', function () {
    $this->actingAs(player())
        ->get(route('dashboard'))
        ->assertOk();
});

// --- Postacie ---
test('gracz może utworzyć postać wraz z kartą', function () {
    $user = player();

    Livewire::actingAs($user)
        ->test(CharacterCreate::class)
        ->set('name', 'Testowy Bohater')
        ->set('age', 30)
        ->set('race', 'Człowiek')
        ->call('save');

    $this->assertDatabaseHas('charakters', [
        'name' => 'Testowy Bohater',
        'user_id' => $user->id,
    ]);

    $character = Charakter::where('name', 'Testowy Bohater')->first();
    $this->assertDatabaseHas('charakter_sheets', ['charakter_id' => $character->id]);
});

test('właściciel widzi swoją postać, obcy dostaje 403', function () {
    $owner = player();
    $character = Charakter::create([
        'name' => 'Moja Postać', 'age' => '25', 'origin' => 'Tu', 'race' => 'Elf',
        'eyes' => 'Zielone', 'hair' => 'Czarne', 'biography' => '...', 'user_id' => $owner->id,
    ]);

    $this->actingAs($owner)->get(route('character.show', $character))->assertOk();
    $this->actingAs(player())->get(route('character.show', $character))->assertForbidden();
});

// --- Forum ---
test('dział tylko dla MG jest niedostępny dla gracza', function () {
    $category = Category::create(['name' => 'Sekcja MG', 'description' => 'd', 'OnlyforGM' => true]);
    $forum = Forum::create(['name' => 'Kuluary', 'description' => 'd', 'category_id' => $category->id]);

    $this->actingAs(player())->get(route('forum.show', $forum))->assertForbidden();
    $this->actingAs(moderator())->get(route('forum.show', $forum))->assertOk();
});

test('gracz tworzy wątek z pierwszym postem', function () {
    $user = player();
    $category = Category::create(['name' => 'Tawerna', 'description' => 'd', 'OnlyforGM' => false]);
    $forum = Forum::create(['name' => 'Pod Smokiem', 'description' => 'd', 'category_id' => $category->id]);

    Livewire::actingAs($user)
        ->test(ThreadCreate::class, ['forum' => $forum])
        ->set('name', 'Nowa przygoda')
        ->set('content', 'Treść pierwszego posta.')
        ->set('tag', PostTag::Normal->value)
        ->call('save');

    $this->assertDatabaseHas('threads', ['name' => 'Nowa przygoda', 'forum_id' => $forum->id]);
    $this->assertDatabaseHas('posts', ['content' => 'Treść pierwszego posta.', 'user_id' => $user->id]);
});

// --- Misje: zgłaszanie i ocena werdyktująca ---
test('gracz zgłasza misję', function () {
    $user = player();

    Livewire::actingAs($user)
        ->test(MissionsIndex::class)
        ->set('name', 'Oblężenie')
        ->set('description', 'Opis misji.')
        ->call('propose');

    $this->assertDatabaseHas('missions', [
        'name' => 'Oblężenie',
        'proposed_by' => $user->id,
        'status' => 'proposed',
    ]);
});

test('moderator ocenia misję, a gracz nie może', function () {
    $mod = moderator();
    $mission = Mission::create(['name' => 'Misja', 'description' => 'd', 'status' => 'proposed']);

    Livewire::actingAs($mod)
        ->test(MissionsIndex::class)
        ->call('rate', $mission->id, 4);

    expect($mission->fresh()->averageRating())->toBe(4.0);

    // Gracz nie ma uprawnień werdyktujących.
    Livewire::actingAs(player())
        ->test(MissionsIndex::class)
        ->call('rate', $mission->id, 1)
        ->assertForbidden();
});

// --- Narzędzie rozstrzygania konfliktów ---
test('rzut kością zwraca wynik w zakresie kości', function () {
    Livewire::actingAs(player())
        ->test(Conflict::class)
        ->set('sides', 20)
        ->call('roll')
        ->assertSet('lastRoll', fn ($v) => $v >= 1 && $v <= 20);
});

// --- Strony renderują się dla zatwierdzonego gracza ---
test('kluczowe strony zwracają 200', function () {
    $user = player();

    foreach ([
        'character.index', 'missions.index', 'events.index', 'world-logs.index',
        'badges.index', 'leaderboard.index', 'suggestions.index', 'library.index',
        'tools.conflict', 'forum.index',
    ] as $name) {
        $this->actingAs($user)->get(route($name))->assertOk();
    }
});

test('profil gracza jest dostępny', function () {
    $user = player();
    $this->actingAs(player())->get(route('player.show', $user))->assertOk();
});
