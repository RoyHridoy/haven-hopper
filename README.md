## 🤝 Contribution
Run Following commands before give a PR

1. Check Coding Style
```bash
./vendor/bin/pint
```

2. Run Static Analysis Tool
```bash
./vendor/bin/phpstan analyse
```

3. Check all tests are ok
```bash
php artisan test
```

## 🚀 Installation Guide

### Steps
1. Clone the repository
```bash
git clone https://github.com/RoyHridoy/haven-hopper.git
cd barta
```

2. Install dependencies
```bash
composer install
npm install
```

3. Configure environment variables
```bash
cp .env.example .env
php artisan key:generate
```

4. Run migrations and seed the database:
```bash
php artisan migrate
php artisan db:seed
```

5. Set up storage:
```bash
php artisan storage:link
```

6. Start the development server:
```bash
php artisan serve
```

7. Start asset compilation:
```bash
npm run dev
```
