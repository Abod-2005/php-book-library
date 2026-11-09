# Technical notes

## Docker obstacle

Docker and Compose were not installed on the local machine: the commands were not found. To verify the image despite this limitation, the existing GitHub Actions runner built it and ran a container on Linux. Its health endpoint returned OK and the HTTP CRUD smoke test passed. The local installation problem itself remains unresolved; install Docker Desktop and start its engine to run Compose locally.

## Git/GitHub lesson

Branching from the original main commit preserves the project history, and a pull request makes the Docker changes reviewable without changing main. Verify the account, repository and branch before publishing.

## Verification

- PHP 8.4.13: syntax checks passed; PHP CLI session simulation passed for initial list, add, edit and delete.
- [GitHub Actions run #2](https://github.com/Abod-2005/php-book-library/actions/runs/42618495958): Docker image built, container started, health endpoint returned OK, and HTTP CRUD smoke test passed. The run tested the PR merge commit based on e865f6e.
- Docker Compose, Docker health status, local browser UI and screenshots of the local container remain untested. The CI health endpoint check is not the same as inspecting Docker's health status.
- An earlier local HTTP connection was unavailable in the tool environment. The follow-up execution requiring expanded network access was rejected by automatic approval review.
- GitHub warned that checkout v4 targets Node 20 and was forced to run on Node 24; the workflow still passed.
