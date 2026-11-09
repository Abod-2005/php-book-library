# Technical notes

## Docker obstacle

Docker and Compose were not installed: the commands were not found. No image or container could be built or tested here, and the problem remains unresolved. Install Docker Desktop, start its engine, then run the README commands and record the actual result. Multi-stage was considered but adds no value for this dependency-free PHP app.

## Git/GitHub lesson

A feature branch isolates Docker changes from the initial main branch; a pull request makes commits reviewable before merging. Verify the active GitHub account and repository before pushing so that changes go to the intended feature branch rather than main.

## Verification performed

- PHP 8.4.13: syntax checks for both PHP files passed.
- PHP CLI request/session simulation: initial books, add, edit and delete passed. This did not test HTTP, browser behavior or Docker.
- An HTTP local test attempt could not connect across the tool environment. The follow-up execution requiring expanded network access was rejected by automatic approval review.
- Docker build, container health, GitHub Actions, browser screenshots and remote PR: pending.
- Git Bash smoke script could not run locally because MSYS initialization was denied; it is configured for GitHub's Ubuntu runner and remains unverified there.

