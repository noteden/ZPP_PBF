<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Charakter;
use App\Models\Forum;
use App\Models\Post;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Seeder;

class ForumSeeder extends Seeder
{
    public function run(): void
    {
        // Bez obserwerów, by uniknąć efektów ubocznych (powiadomienia/odznaki) przy seedowaniu.
        EloquentModel::withoutEvents(function () {
            $structure = [
                ['Świat gry', 'Ogólne informacje o świecie i fabule', false, [
                    ['Tawerna „Pod Złotym Smokiem”', 'Miejsce spotkań bohaterów'],
                    ['Rynek miejski', 'Handel, plotki i spotkania'],
                ]],
                ['Lokacje', 'Tematyczne fora odpowiadające miejscom w świecie', false, [
                    ['Las Szeptów', 'Tajemniczy prastary las'],
                    ['Góry Żelazne', 'Krasnoludzkie twierdze i kopalnie'],
                ]],
                ['Sekcja Mistrzów Gry', 'Dział widoczny wyłącznie dla MG', true, [
                    ['Kuluary MG', 'Planowanie wątków i scenariuszy'],
                ]],
            ];

            $players = User::whereIn('email', ['user@test.com', 'aldric@test.com', 'lyra@test.com', 'borin@test.com', 'seraphina@test.com'])->get();
            $characters = Charakter::all()->keyBy('user_id');

            foreach ($structure as [$catName, $catDesc, $onlyGM, $forums]) {
                $category = Category::updateOrCreate(
                    ['name' => $catName],
                    ['description' => $catDesc, 'OnlyforGM' => $onlyGM]
                );

                foreach ($forums as [$forumName, $forumDesc]) {
                    $forum = Forum::updateOrCreate(
                        ['name' => $forumName, 'category_id' => $category->id],
                        ['description' => $forumDesc]
                    );

                    if ($onlyGM) {
                        continue;
                    }

                    // Po dwa wątki na forum z kilkoma postami.
                    foreach (['Powitanie w '.$forumName, 'Wydarzenia w '.$forumName] as $ti => $threadName) {
                        $author = $players[$ti % $players->count()];

                        $thread = Thread::updateOrCreate(
                            ['name' => $threadName, 'forum_id' => $forum->id],
                            [
                                'user_id'  => $author->id,
                                'tag'      => 'normalny',
                                'archived' => $ti === 1 && $forumName === 'Rynek miejski',
                            ]
                        );

                        foreach ($players as $pi => $player) {
                            $character = $characters[$player->id] ?? null;
                            Post::updateOrCreate(
                                [
                                    'thread_id' => $thread->id,
                                    'user_id'   => $player->id,
                                    'content'   => 'Wpis postaci '.($character?->name ?? $player->name).' w wątku „'.$threadName.'”.',
                                ],
                                [
                                    'charakter_id' => $character?->id,
                                    'tag'          => $pi === 0 ? 'ważne' : 'normalny',
                                ]
                            );
                        }
                    }
                }
            }
        });
    }
}
