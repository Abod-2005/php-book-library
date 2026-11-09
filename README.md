# Dockerized PHP Book Library

A PHP personal book library with validated add, edit and delete operations, developed in [Abod-2005/php-book-library](https://github.com/Abod-2005/php-book-library).

## Stack and behavior

PHP 8.3 CLI, PHP sessions, HTML and Bootstrap 5 from a CDN. There is no database or package installation step. Each browser session has its own list; changes are temporary and may disappear when the session expires or the container is recreated. Internet access is needed for Bootstrap styling and the delete confirmation modal. This educational application has no authentication and is intended for local use.

## Run with Docker Compose

Install Docker Engine with the Compose plugin, then run:

```sh
docker compose up -d --build
docker compose ps
```

Open http://localhost:8080/ and http://localhost:8080/health.php (expected response: OK). To use another host port, set APP_PORT before starting, for example `APP_PORT=8081 docker compose up -d --build` on Linux/macOS. In PowerShell use `$env:APP_PORT="8081"; docker compose up -d --build`. No secrets or environment variables are required.

## Alternative: Docker CLI

```sh
docker build -t book-library .
docker run -d --name book-library -p 8080:8080 book-library
docker ps
docker inspect --format '{{.State.Health.Status}}' book-library
```

## Test

In the browser, add a unique title, an author of at least two words, a valid genre, a year between 1000 and the current year, and a positive page count. Edit the new book and confirm the new title appears; delete it and confirm it disappears. Reload between steps to check the session.

With Bash and curl, run `bash tests/smoke.sh http://localhost:8080` to exercise the initial list and add/edit/delete in a fresh cookie session. GitHub Actions is configured to build the image and run this test.

## Stop and clean up

For Compose: `docker compose down`. For Docker CLI: `docker rm -f book-library`; optionally remove the image with `docker image rm book-library`. Make users can run `make build`, `make run`, and `make stop`.

## Design and verification

There are no compiled assets or dependency manager, so a multi-stage build would add a stage without reducing runtime dependencies. The container runs as www-data and checks the PHP HTTP health endpoint. PHP's built-in server is suitable for this local educational exercise, not a production deployment.

Local verification and pending evidence are recorded in docs/notes.md and docs/checklist.md. The upstream repository did not declare a license at inspection; no license terms are asserted here. The author should select a license for their own work if they wish to grant reuse rights.

