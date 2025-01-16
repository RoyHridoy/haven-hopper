## 🤝 Contribution
Run Following commands before give a PR

### To maintain codebase we use [larastan](https://github.com/larastan/larastan), Please maintain rules.
1. Run Static Analysis Tool to check you have no error
```bash
composer analyse
```

### You have to ensure that you write tests for every feature you build
2. Check all tests are ok
```bash
php artisan test
```

## Remember, If all of above provides no error, your code will be merged


## 🚀 Installation Guide

### Steps
1. Clone the repository
```bash
git clone https://github.com/RoyHridoy/haven-hopper.git
cd haven-hopper
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

4. Run migrations:
```bash
php artisan migrate
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
