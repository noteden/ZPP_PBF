<?php

namespace App\Providers;

use App\Events\NotificationReceived;
use App\Events\ResourceChanged;
use App\Models\Charakter;
use App\Models\CharakterSheet;
use App\Models\Documents;
use App\Models\Event as EventModel;
use App\Models\Mission;
use App\Models\Post;
use App\Models\PostReport;
use App\Models\Skill;
use App\Models\Suggestion;
use App\Models\Thread;
use App\Models\Tutorial;
use App\Models\WorldLog;
use App\Observers\CharakterObserver;
use App\Observers\CharakterSheetObserver;
use App\Observers\PostObserver;
use App\Observers\SkillObserver;
use App\Observers\ThreadObserver;
use Carbon\CarbonImmutable;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        Post::observe(PostObserver::class);
        Thread::observe(ThreadObserver::class);
        Charakter::observe(CharakterObserver::class);
        CharakterSheet::observe(CharakterSheetObserver::class);
        Skill::observe(SkillObserver::class);

        // Real-time: po zapisaniu powiadomienia (kanał database) wyślij sygnał na kanał użytkownika.
        Event::listen(NotificationSent::class, function (NotificationSent $event): void {
            if ($event->channel === 'database' && isset($event->notifiable->id)) {
                NotificationReceived::dispatch((int) $event->notifiable->id);
            }
        });

        // Real-time: zmiany na listach (kanały publiczne) — listy odświeżają się na żywo.
        Mission::created(fn () => ResourceChanged::dispatch('missions'));
        Mission::updated(fn () => ResourceChanged::dispatch('missions'));
        EventModel::created(fn () => ResourceChanged::dispatch('events'));
        EventModel::deleted(fn () => ResourceChanged::dispatch('events'));
        WorldLog::created(fn () => ResourceChanged::dispatch('world-logs'));
        Suggestion::created(fn () => ResourceChanged::dispatch('suggestions'));
        Documents::created(fn () => ResourceChanged::dispatch('library'));
        Tutorial::created(fn () => ResourceChanged::dispatch('library'));
        PostReport::created(fn () => ResourceChanged::dispatch('moderators'));
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
