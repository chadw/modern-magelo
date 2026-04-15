# Modern EQEmu Magelo
![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)![TailwindCSS](https://img.shields.io/badge/tailwindcss-%2338B2AC.svg?style=for-the-badge&logo=tailwind-css&logoColor=white)![DaisyUI](https://img.shields.io/badge/daisyui-5A0EF8?style=for-the-badge&logo=daisyui&logoColor=white)

## Live Demo
You can see this in use on [Project Lazarus](https://magelo.lazaruseq.com/)

## Requirements

- PHP >= 8.2, Composer, Mysql/MariaDB, and an EQemu DB.

## Installation

[Download the item/spell icons!](https://github.com/chadw/modern-allaclone/releases/download/1.0.0/icons.zip) and unzip them to /public/img/icons

### To setup a local development environment
```
git clone https://github.com/chadw/modern-magelo.git
cd modern-magelo

composer install
npm install
npm run dev

cp .env.example .env
```
Create a magelo db utf8mb4/utf8mb4_unicode_ci
Edit the .env variables to point to your magelo db
```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=magelo
DB_USERNAME=root
DB_PASSWORD=
```

Edit the .env variables to point to your eqemu db.
```
EQEMU_DB_HOST=127.0.0.1
EQEMU_DB_PORT=3306
EQEMU_DB_DATABASE=peq
EQEMU_DB_USERNAME=user
EQEMU_DB_PASSWORD=password
```

Note: If your .env APP_KEY is empty, run `php artisan key:generate` to generate a key.
Now run migrations. This will populate your magelo db with tables used for sessions and caching.
```
php artisan migrate
```

In /config/everquest.php there is some variables you may need to change. Currently only the item_links will work but it's best if you change them all.
```
'item_links'                => 'https://www.lazaruseq.com/alla/items/{item_id}',
'spell_links'               => 'https://www.lazaruseq.com/alla/spells/{spell_id}',
'faction_links'             => 'https://www.lazaruseq.com/alla/factions/{faction_id}',
```

If you have players who scrape data from the old magelo, and want to allow a friendly way to get the bazaar data, you can setup an api_key for them.
```
php artisan api:generate-key "Korwar's Key" (should be a friendly name so you can reference it if needed)
```

### To set this up in production
Copy over your magelo db and run the following command on your production server
```
php artisan optimize:clear
```

Next build the assets. Do this on your dev server preferrably.
```
npm run build
```
Then copy the /public/build/ folder to your production server.

Always install this outside your publically accessible web directory. Symlink the /public folder to your public accessible web directory.

## Screenshots



## License

Licensed under the [MIT license](https://opensource.org/licenses/MIT).
