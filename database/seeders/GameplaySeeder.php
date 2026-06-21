<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Event;
use App\Models\Mission;
use App\Models\User;
use App\Models\WorldLog;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Seeder;

class GameplaySeeder extends Seeder
{
    public function run(): void
    {
        // Bez broadcastów real-time podczas seedowania.
        EloquentModel::withoutEvents(fn () => $this->seed());
    }

    private function seed(): void
    {
        $mg     = User::where('email', 'mg@test.com')->first();
        $admin  = User::where('email', 'admin@test.com')->first();
        $players = User::where('role', UserRole::Player)->where('approved', true)->get();

        // --- Misje (zgłoszone przez graczy, oceniane przez role werdyktujące) ---
        $missions = [
            ['Oblężenie Czarnej Wieży', 'Grupa bohaterów musi przełamać obronę twierdzy nekromanty.', 'approved', 5],
            ['Zaginiona karawana', 'Odnaleźć kupiecką karawanę zaginioną w Lesie Szeptów.', 'approved', 4],
            ['Klątwa wioski Olszyny', 'Zbadać dziwną zarazę nękającą mieszkańców.', 'proposed', null],
            ['Turniej rycerski', 'Reprezentować swój ród w wielkim turnieju.', 'proposed', null],
        ];

        foreach ($missions as $mi => [$name, $desc, $status, $rating]) {
            $proposer = $players[$mi % max($players->count(), 1)] ?? null;

            $mission = Mission::updateOrCreate(
                ['name' => $name],
                [
                    'description' => $desc,
                    'proposed_by' => $proposer?->id,
                    'status'      => $status,
                ]
            );

            // Kilku graczy dołącza do misji.
            $sync = [];
            foreach ($players->take(3) as $p) {
                $sync[$p->id] = ['review' => $mi === 0];
            }
            // Ocena werdyktująca od MG.
            if ($rating !== null && $mg) {
                $sync[$mg->id] = ['review' => false, 'rating' => $rating];
            }
            $mission->users()->sync($sync);
        }

        // --- Wydarzenia (kalendarz) ---
        $events = [
            ['Sesja grupowa: Wyprawa do podziemi', 'Spotkanie głównej drużyny.', 'sesja', now()->addDays(3)],
            ['Wielki Turniej Rycerski', 'Coroczne zawody na dworze królewskim.', 'event', now()->addDays(10)],
            ['Wojna o Przełęcz', 'Starcie dwóch frakcji o strategiczny punkt.', 'wojna', now()->addDays(21)],
            ['Festyn plonów', 'Zakończone święto zbiorów.', 'event', now()->subDays(7)],
        ];

        foreach ($events as [$name, $desc, $type, $date]) {
            Event::updateOrCreate(
                ['name' => $name],
                [
                    'description' => $desc,
                    'user_id'     => $mg?->id ?? $admin?->id,
                    'type'        => $type,
                    'date'        => $date,
                ]
            );
        }

        // --- Logi światowe / kronika ---
        $logs = [
            ['Upadek Starego Królestwa', 'Wielka wojna sprzed stu lat doprowadziła do rozpadu zjednoczonego królestwa na zwaśnione lenna.', now()->subYears(100)->startOfYear()],
            ['Noc Spadających Gwiazd', 'Deszcz meteorytów zmienił krajobraz Pustyni Spopielonych i obudził prastare moce.', now()->subYears(12)->startOfYear()],
            ['Pakt z Lasem Szeptów', 'Elfy zawarły kruchy rozejm z ludzkimi osadnikami granicznymi.', now()->subYears(3)->startOfYear()],
            ['Powrót nekromanty', 'W ruinach Czarnej Wieży dostrzeżono światła — zło powraca.', now()->subMonths(2)],
        ];

        foreach ($logs as [$title, $body, $date]) {
            WorldLog::updateOrCreate(
                ['title' => $title],
                [
                    'body'        => $body,
                    'occurred_on' => $date,
                    'user_id'     => $mg?->id ?? $admin?->id,
                ]
            );
        }
    }
}
