# API Backend Coding Task

This is the technical test project for API oriented backends.

## About

- The API is built using DDD (Domain Driven Design) and Hexagonal Architecture.
- The API uses the Slim Framework as the HTTP layer.
- The Requests have a validation layer using the `Respect\Validation` library.
- The Responses are normalized using a Response builder class and with model transformers.
- The API uses native sql queries to interact with the database.
- The API uses JWT for authentication.
- The API has a middleware to validate the JWT token.
- The API has a helper function to simplify the access to the current user.
- The API has a middleware to validate authorization.
- The API has redis as a cache system.
- The API has documentation using OpenAPI.
- The API has tests using PHPUnit.
- The database had a migration to create the tables and seed to populate the tables.
- There are some configurations on the database to grant correct character encoding.
- The repository has hooks before commit to run the tests.
- The repository has a GitHub Action to run the tests and code quality validation on every push.

## Build

```bash
make build
```

- This command executes the Docker image building process and performs the [Composer](https://getcomposer.org) dependencies installation.
- This command will also create a `.env` file based on the `.env.example` file.

## Run

```bash
make run
```
- This command starts the Docker containers and the PHP built-in development server.
- The API will be available at [http://localhost:8080](http://localhost:8080).
- The database will be available at `localhost:3306`.
- The database credentials are on the `.env` file.
- There is a Redis container available at `localhost:6379`.

## Stop

```bash
make stop
```

## Documentation

The API documentation is available at [http://localhost:8080/api/documentation](http://localhost:8080/api/documentation).

## Tests

```bash
make test
```

- This command executes the PHPUnit tests.
- This command will execute the Integration tests.
- The tests are located in the `tests` directory.

## Caché

- The API uses Redis as a cache system.
- The cache is enabled by default.
- The cache TTL is set to 60 seconds.
- All the services to list and get detail use the cache.

---

Type `make help` for more tasks present in `Makefile`.

## Functional requirements

**Implement a CRUD (Create-Read-Update-Delete) API.**

The following add-ons will be positively evaluated:

- [x] Authentication
- [x] Authorization
- [x] Cache
- [x] Documentation

---

A light infrastructure is provided with a populated MySQL database with example data and a web server using PHP built-in development server.

## Non functional requirements

- The presence of unit, integration and acceptance tests will positively appreciated.
- Use whatever you want to achieve this: MVC, hexagonal arquitecture, DDD, etc.
- A deep knowledge about SOLID, YAGNI or KISS would be positively evaluated.
- DevOps knowledge (GitHub Actions, Jenkins, etc.) would be appreciated too.
- It's important to find a balance between code quality and deadline; releasing a non functional application in time or a perfect application out of time may be negatively evaluated.
- Good and well-documented commits will be appreciated.
- Efficient and smart use of third party libraries will be positively appreciated.

---

Beyond the requirements of this test we want to see what you can do, feel free to show us your real potential and, the
most important part, have fun!

