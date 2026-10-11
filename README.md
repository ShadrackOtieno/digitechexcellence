# DevAdvantage: portfolio website and back office (Laravel)

A public website that lists your work, plus a back office to manage it. Brand colours: blue and yellow.

**Public site:** home, work (search, category and technology filters, sorting), project case studies with gallery, services, about, contact, start-a-project form, sitemap.
**Back office (`/admin`):** dashboard, projects (cover, gallery, technologies), categories, technologies, services, team, testimonials, project inquiries (with status and notes), contact messages, site settings (text, contact details, brand colours, logo), account/password.

This folder is an **overlay**: it contains only the files that differ from a fresh Laravel project.

## Install (Laravel 11 or 12, PHP 8.2+, MySQL)

```bash
composer create-project laravel/laravel devadvantage
# copy everything from this zip over the new devadvantage folder (overwrite when asked)
cd devadvantage
cp .env.mysql.example .env        # then run: php artisan key:generate
```

1. Create the database (WAMP/XAMPP: phpMyAdmin > SQL, paste `database/mysql-setup.sql`), and check DB_* in `.env`.
2. `php artisan key:generate`
3. `php artisan migrate:fresh --seed`
4. `php artisan storage:link`
5. `php artisan serve` and open http://127.0.0.1:8000

Back office: http://127.0.0.1:8000/admin, with the ADMIN_EMAIL and ADMIN_PASSWORD from `.env` (defaults: `admin@devadvantage.test` / `ChangeMe-2026!`). Change the password at once in My account.

## Replace the placeholders (important)

- The six projects are **placeholders**, marked "(demo)" in the client name and shown with a "Demo" badge. Edit or delete them under Projects, and upload real screenshots. The dashboard reminds you until they are gone.
- The team member and testimonial are samples and are **hidden**. Fill them with real details before ticking "Show on website". Only publish quotes clients agreed to.
- Email, phone and WhatsApp in Settings are placeholders (`hello@devadvantage.test`, `254700000000`). Set your real ones. WhatsApp: digits only, international format.
- Set "Year founded" in Settings to show "Building since".

## Notes

- Icons are inline SVG (`<x-icon name="...">`); there are no emojis. Tailwind and Alpine load from CDNs, so the pages need internet access.
- Mail: with `MAIL_MAILER=log` notifications go to `storage/logs/laravel.log`. Inquiries and messages are always saved in the database even if mail fails.
- Forms have a honeypot field and rate limits.
- Brand colours can be changed in Settings > Brand colours.

## Troubleshooting

- `1071 Specified key was too long` or "table users already exists": run `php artisan migrate:fresh --seed` (the app forces InnoDB and 191-char index length).
- Images not showing for uploads: run `php artisan storage:link`.
- "Class not found" after copying: run `composer dump-autoload`.
- Blank styles: check your internet connection (Tailwind CDN).
