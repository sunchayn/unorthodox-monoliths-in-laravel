# Unorthodox Monoliths in Laravel
Tackling scalability challenges in large monoliths with strategies like multi-application infra, circuit fuse, and hybrid DB optimization

[Read the full article on Medium](https://medium.com/studocu-techblog/unorthodox-monoliths-in-laravel-ebb41277780e)

---

In this repository, you will find examples for:
- Multi Application Infrastructure
- Circuit Fuse for Distributed Databases
- Hybrid Optimizations MySQL + PHP combination

---

## How to run the demo?
1. Clone the repository.
2. Run `composer install`.
3. Run `php artisan migrate`.
4. Run `php artisan serve` (so you can test the URls).

## Multi Application Infrastructure
The key idea is to boot a separate Laravel application instance for the REST API, complete with its own HTTP Kernel and exception handler. This isolates its global middleware, service providers, and error handling from the main application.

The applications defined here are:
- app/Http/RestApi/RestApiApplication.php
- app/Http/Monolith/MonolithApplication.php

You can visit the following URLs to try it out:
- http://127.0.0.1:8000/rest-api/test
- http://127.0.0.1:8000/web/test
- http://127.0.0.1:8000/rest-api/test/exception
- http://127.0.0.1:8000/web/test/exception

## Circuit Fuse for Distributed Databases
The circuit fuse serves as a pseudo circuit breaker that will absorb the shock when the database is down.
The goal of such a layer is to return an empty state for missing tables (due to replication errors).

The logic is defined in: `app/Core/Database/Concerns/HandlesConnectionErrors.php`

To try it out, visit these URLs:
- http://127.0.0.1:8000/web/fuse/normal
- http://127.0.0.1:8000/web/fuse/has-errors

## Hybrid Optimizations MySQL + PHP combination
This combines an index only operation with post-processing in php
to answer queries that are impossible to do in MySQL alone or will take too long.

You can find the full query in `app/Modules/Courses/Queries/CourseInitialDocumentPerCategoryQuery.php`.

to test the query, visit this URL:
- http://127.0.0.1:8000/web/test/query

---

Make sure to read the full article for more context [Unorthodox Monoliths in Laravel](https://medium.com/studocu-techblog/unorthodox-monoliths-in-laravel-ebb41277780e).


