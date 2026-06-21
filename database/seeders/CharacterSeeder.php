<?php

namespace Database\Seeders;

use App\Models\Charakter;
use App\Models\CharakterSheet;
use App\Models\Equipment;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Seeder;

class CharacterSeeder extends Seeder
{
    public function run(): void
    {
        // Bez obserwerów (broadcasty real-time) podczas seedowania.
        EloquentModel::withoutEvents(fn () => $this->seedCharacters());
    }

    private function seedCharacters(): void
    {
        $characters = [
            // Postać konta testowego user@test.com.
            ['email' => 'user@test.com', 'name' => 'Kael Wędrowiec', 'age' => '28', 'origin' => 'Wolne Miasta', 'race' => 'Człowiek', 'eyes' => 'Brązowe', 'hair' => 'Ciemny blond', 'experience' => 800, 'history_points' => 5,
             'biography' => 'Młody awanturnik szukający przygód i sławy w rozległym świecie.',
             'stats' => ['Siła' => 12, 'Zręczność' => 13, 'Wytrzymałość' => 11, 'Inteligencja' => 12],
             'skills' => [['Walka mieczem', true, 2], ['Negocjacje', true, 2], ['Tropienie', false, 1]],
             'equipment' => ['Miecz podróżny', 'Skórzany kaftan', 'Plecak podróżnika']],

            ['email' => 'aldric@test.com', 'name' => 'Aldric z Doliny', 'age' => '34', 'origin' => 'Dolina Cierni', 'race' => 'Człowiek', 'eyes' => 'Szare', 'hair' => 'Czarne', 'experience' => 1200, 'history_points' => 8,
             'biography' => 'Wędrowny rycerz szukający odkupienia za grzechy przeszłości.',
             'stats' => ['Siła' => 14, 'Zręczność' => 11, 'Wytrzymałość' => 13, 'Inteligencja' => 9],
             'skills' => [['Władanie mieczem', true, 3], ['Jazda konna', true, 2]],
             'equipment' => ['Stalowy miecz', 'Kolczuga', 'Tarcza z herbem']],

            ['email' => 'lyra@test.com', 'name' => 'Lyra Świtczyca', 'age' => '27', 'origin' => 'Las Szeptów', 'race' => 'Elf', 'eyes' => 'Zielone', 'hair' => 'Srebrne', 'experience' => 2100, 'history_points' => 14,
             'biography' => 'Łuczniczka i strażniczka prastarego lasu.',
             'stats' => ['Siła' => 9, 'Zręczność' => 16, 'Wytrzymałość' => 10, 'Inteligencja' => 12],
             'skills' => [['Strzelectwo', true, 4], ['Skradanie', true, 3], ['Magia natury', false, 1]],
             'equipment' => ['Długi łuk', 'Kołczan strzał', 'Skórzany pancerz']],

            ['email' => 'borin@test.com', 'name' => 'Borin Kamienna Pięść', 'age' => '142', 'origin' => 'Góry Żelazne', 'race' => 'Krasnolud', 'eyes' => 'Brązowe', 'hair' => 'Rude', 'experience' => 1750, 'history_points' => 11,
             'biography' => 'Kowal i wojownik, mistrz topora bojowego.',
             'stats' => ['Siła' => 17, 'Zręczność' => 8, 'Wytrzymałość' => 16, 'Inteligencja' => 10],
             'skills' => [['Władanie toporem', true, 4], ['Kowalstwo', true, 5]],
             'equipment' => ['Topór bojowy', 'Płytowa zbroja', 'Młot kowalski']],

            ['email' => 'seraphina@test.com', 'name' => 'Seraphina Mrok', 'age' => '31', 'origin' => 'Miasto Cieni', 'race' => 'Człowiek', 'eyes' => 'Fioletowe', 'hair' => 'Kruczoczarne', 'experience' => 2600, 'history_points' => 18,
             'biography' => 'Czarodziejka parająca się zakazaną magią.',
             'stats' => ['Siła' => 7, 'Zręczność' => 10, 'Wytrzymałość' => 9, 'Inteligencja' => 18],
             'skills' => [['Magia ognia', true, 4], ['Alchemia', true, 2], ['Nekromancja', false, 1]],
             'equipment' => ['Kostur mocy', 'Grymuar', 'Amulet many']],

            ['email' => 'garrick@test.com', 'name' => 'Garrick Wilczy', 'age' => '29', 'origin' => 'Północne Rubieże', 'race' => 'Człowiek', 'eyes' => 'Niebieskie', 'hair' => 'Blond', 'experience' => 900, 'history_points' => 6,
             'biography' => 'Łowca potworów i tropiciel.',
             'stats' => ['Siła' => 13, 'Zręczność' => 14, 'Wytrzymałość' => 12, 'Inteligencja' => 11],
             'skills' => [['Tropienie', true, 3], ['Walka dwoma broniami', false, 1]],
             'equipment' => ['Para sztyletów', 'Płaszcz myśliwego']],

            ['email' => 'mira@test.com', 'name' => 'Mira Ziołoznawczyni', 'age' => '45', 'origin' => 'Wioska Olszyny', 'race' => 'Człowiek', 'eyes' => 'Zielone', 'hair' => 'Siwe', 'experience' => 1400, 'history_points' => 9,
             'biography' => 'Uzdrowicielka znająca tajniki ziół i mikstur.',
             'stats' => ['Siła' => 8, 'Zręczność' => 11, 'Wytrzymałość' => 10, 'Inteligencja' => 15],
             'skills' => [['Zielarstwo', true, 4], ['Leczenie', true, 3]],
             'equipment' => ['Torba zielarska', 'Sierp', 'Flakony z miksturami']],

            ['email' => 'theron@test.com', 'name' => 'Theron Płomień', 'age' => '38', 'origin' => 'Pustynia Spopielonych', 'race' => 'Człowiek', 'eyes' => 'Bursztynowe', 'hair' => 'Brązowe', 'experience' => 500, 'history_points' => 3,
             'biography' => 'Najemnik o niejasnej przeszłości.',
             'stats' => ['Siła' => 12, 'Zręczność' => 12, 'Wytrzymałość' => 11, 'Inteligencja' => 10],
             'skills' => [['Walka wręcz', true, 2]],
             'equipment' => ['Szabla', 'Skórznia']],
        ];

        foreach ($characters as $data) {
            $user = User::where('email', $data['email'])->first();
            if (!$user) {
                continue;
            }

            $character = Charakter::updateOrCreate(
                ['user_id' => $user->id, 'name' => $data['name']],
                [
                    'age'            => $data['age'],
                    'origin'         => $data['origin'],
                    'race'           => $data['race'],
                    'eyes'           => $data['eyes'],
                    'hair'           => $data['hair'],
                    'biography'      => $data['biography'],
                    'experience'     => $data['experience'],
                    'history_points' => $data['history_points'],
                ]
            );

            $sheet = CharakterSheet::updateOrCreate(
                ['charakter_id' => $character->id],
                ['statistic' => $data['stats']]
            );

            $skillIds = [];
            foreach ($data['skills'] as [$skillName, $accepted, $level]) {
                $skill = Skill::firstOrCreate(
                    ['name' => $skillName],
                    ['description' => 'Umiejętność: '.$skillName, 'accepted' => $accepted]
                );
                $skillIds[$skill->id] = ['level' => $level];
            }
            $sheet->skills()->sync($skillIds);

            $equipmentIds = [];
            foreach ($data['equipment'] as $itemName) {
                $item = Equipment::firstOrCreate(
                    ['name' => $itemName],
                    ['description' => $itemName, 'weight' => 1.0, 'statistic' => [], 'type' => 'inne']
                );
                $equipmentIds[$item->id] = ['number' => 1, 'is_equipped' => false];
            }
            $sheet->equipment()->sync($equipmentIds);
        }
    }
}
