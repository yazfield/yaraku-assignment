# The book list - Yaraku assignment
The assignment is to create a list of books. These are the requirements,
- Use Laravel (http://laravel.com) for the backend.
- Any persistence is okay, Laravel Cache, SQLite etc. Just choose the one that feels most convenient. 
- Create a list of books.
- Make it possible to add a book to the list.
- Make it possible to delete a book from the list.
- Make it possible to sort by title or author
- Make it possible to search for a book by title or author

## Installation
1. Clone this repository

```
git clone https://github.com/yazfield/yaraku-assignment.git
cd yaraku-assignment
```

2. Install all dependencies

```
composer install
```

2. Set `.env` config file.

I used `sqlite` for the database for the sake of simplicity.
```
cp .env.example .env
```
_.env file_
```
APP_NAME="The book list"
APP_ENV=local
APP_DEBUG=false
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
```

3. Generate an application 

```
php artisan key:generate
```

4. Create the database file.

```
touch database/database.sqlite
```

5. Migrate and seed the database

```
php artisan migrate --seed
```

6. Run the application

```
php artisan serve
```

If you don't have PHP 7.1+ and laravel dependencies you can use a docker compose file

```
cd laradock
cp ../.env.laradock.nginx .env
docker-compose up -d nginx
```
The application accessible on http://localhost:8080

## About the solution
- I have decided to make the application a Multi Page Application because it's simple, there's no complex UI so I didn't feel that an SPA library would be needed to provide better organisation and data/UI management.

- I haven't added user accounts because it wasn't specified in the requirements, so lists are open for everybody.

- I had put business logic inside the controllers since all the methods are very small, there's no complex logic so this wouldn't hurt.
