# Inovindo Academy — AGENTS.md

Laravel 12 LMS with Filament 4 admin, Livewire 3 + Volt frontend, Pest 3 tests.

## Quick start

```bash
composer setup          # install, .env, key:generate, migrate, npm install+build
composer dev            # server + queue:listen + pail + Vite concurrently
composer test           # config:clear → php artisan test (Pest)
npm run build           # Vite production build
npm run dev             # Vite dev server
```

## Architecture

| Role | Path | Implementation |
|------|------|---------------|
| **student** | `/courses/...`, `/events/...`, `/discussions/...`, `/leaderboard` | Web controllers + Livewire |
| **instructor** | `/instructor/...` | Web controllers + Livewire |
| **admin** | `/admin` | Filament panel (auto-discovers `app/Filament/{Resources,Pages,Widgets}`) |
| **public** | `/certificates/...` | No auth middleware |

Auth pages (`/login`, `/register`, etc.) live in `routes/auth.php` as Volt functional pages.

## Key models

`User`, `Course`, `Module`, `Section`, `Lesson`, `Enrollment`, `LessonCompletion`, `Transaction`, `Discussion`, `DiscussionReply`, `Bookmark`, `Event`, `PageView`

## Testing (Pest 3)

```bash
composer test                                    # all tests
php artisan test --filter=ExampleTest            # single file
php artisan test tests/Feature/Auth             # directory
```

Uses `RefreshDatabase` trait + SQLite `:memory:` for feature tests.

## Conventions

- Three roles: `student` (default), `instructor`, `admin` — enforced via `StudentMiddleware`, `InstructorMiddleware`, and `FilamentUser::canAccessPanel`
- Carbon locale set to `'id'` in `AppServiceProvider`
- Default session/queue/cache driver: `database`
- Gamification: users have `points` + `level`, ranked by `User::RANKS`
- Filament resources in `app/Filament/Resources/` — each resource has own subdirectory
- Livewire components under `app/Livewire/` organized by domain (`Actions/`, `Discussions/`, `Forms/`, `Instructor/`)
