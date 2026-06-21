<?php

namespace Database\Seeders;

use App\Models\Badge;
use App\Models\Documents;
use App\Models\PrivateMessage;
use App\Models\Suggestion;
use App\Models\Tutorial;
use App\Models\User;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // Bez broadcastów real-time podczas seedowania.
        EloquentModel::withoutEvents(fn () => $this->seed());
    }

    private function seed(): void
    {
        $admin   = User::where('email', 'admin@test.com')->first();
        $players = User::whereIn('email', ['aldric@test.com', 'lyra@test.com', 'borin@test.com'])->get();

        // --- Dokumentacja świata ---
        $documents = [
            ['Regulamin gry', "1. Szanuj innych graczy.\n2. Pisz zgodnie z konwencją świata.\n3. Decyzje MG są ostateczne.", 'regulamin'],
            ['Historia świata', 'Świat Aethelgard powstał z popiołów Starego Królestwa...', 'lore'],
            ['Wpływ wydarzeń na mechanikę', "Udział w wojnie: +50 PD.\nUkończenie misji fabularnej: +1 PH.\nKrytyczna porażka w walce: utrata przedmiotu.", 'mechanika'],
            ['Mapa świata', 'Ogólna mapa kontynentu wraz z głównymi lokacjami.', 'mapa'],
        ];

        foreach ($documents as [$name, $content, $category]) {
            Documents::updateOrCreate(
                ['name' => $name],
                [
                    'content'       => $content,
                    'category'      => $category,
                    'published_add' => now()->toDateString(),
                ]
            );
        }

        // --- Samouczki / FAQ ---
        $tutorials = [
            ['Jak stworzyć postać?', "Wejdź w „Moje postacie” → „Nowa postać”, wypełnij formularz, a następnie uzupełnij kartę postaci (statystyki, umiejętności, ekwipunek)."],
            ['Jak pisać posty fabularne?', 'Wybierz wątek, wybierz postać, którą piszesz, i opisz jej działania w trzeciej osobie.'],
            ['FAQ — najczęstsze pytania', 'P: Ile postaci mogę mieć? O: Dowolną liczbę. P: Kto akceptuje umiejętności? O: Mistrz Gry.'],
        ];

        foreach ($tutorials as [$name, $content]) {
            Tutorial::updateOrCreate(['name' => $name], ['content' => $content]);
        }

        // --- Sugestie / propozycje ---
        $suggestions = [
            ['Więcej wątków pobocznych', 'Proponuję dodać krótkie misje dla pojedynczych graczy.'],
            ['System pogody w świecie', 'Fajnie byłoby, gdyby pogoda wpływała na fabułę.'],
        ];

        foreach ($suggestions as $si => [$name, $content]) {
            $author = $players[$si % max($players->count(), 1)] ?? $admin;
            Suggestion::updateOrCreate(
                ['name' => $name],
                ['content' => $content, 'user_id' => $author?->id]
            );
        }

        // --- Odznaki / osiągnięcia ---
        $badges = [
            [Badge::FIRST_POST, 'Przyznawana za pierwszy post napisany postacią.', 'star'],
            ['Weteran', 'Za 100 napisanych postów.', 'shield-check'],
            ['Bohater wojny', 'Za udział w wydarzeniu wojennym.', 'fire'],
            ['Odkrywca', 'Za zwiedzenie wszystkich lokacji.', 'map'],
        ];

        $badgeModels = [];
        foreach ($badges as [$name, $desc, $icon]) {
            $badgeModels[] = Badge::updateOrCreate(['name' => $name], ['description' => $desc, 'icon' => $icon]);
        }

        // Przydziel kilka odznak graczom.
        foreach ($players as $i => $player) {
            $player->badges()->syncWithoutDetaching([
                $badgeModels[0]->id,
                $badgeModels[$i % count($badgeModels)]->id,
            ]);
        }

        // --- Prywatne wiadomości ---
        if ($players->count() >= 2) {
            $a = $players[0];
            $b = $players[1];

            PrivateMessage::firstOrCreate(
                ['sender_user_id' => $a->id, 'receiver_user_id' => $b->id, 'content' => 'Spotkajmy się w tawernie o zmierzchu.'],
                ['is_read' => true]
            );
            PrivateMessage::firstOrCreate(
                ['sender_user_id' => $b->id, 'receiver_user_id' => $a->id, 'content' => 'Będę. Przynieś mapę.'],
                ['is_read' => false]
            );
        }
    }
}
