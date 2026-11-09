# Technical Notes

## Docker Challenge

The main challenge was setting up Docker on Windows. Initially, the docker command was not recognized because Docker Desktop was not installed.

I installed Docker Desktop and used the WSL 2 backend. After installation, I successfully built the PHP application image and started the container using Docker Compose.

The container passed its healthcheck, and the application was accessible at http://localhost:8080.

A multi-stage build was not necessary because the application has no separate dependency installation or compilation stage.

## Git and GitHub Lesson

I learned how to use feature branches to develop changes without directly modifying the main branch.

I also learned how to organize commits, open a pull request, and use GitHub Actions to automatically verify Docker builds and application functionality.

## Verification Results

- PHP syntax checks passed.
- Docker image built successfully.
- Docker Compose started the application successfully.
- Container status: healthy.
- Browser access at http://localhost:8080 succeeded.
- Book creation, editing and deletion were tested successfully.
- GitHub Actions Docker build and HTTP CRUD tests passed.
- Pull Request #1 was created from feat/dockerize-library to main.
- Docker and browser screenshots were captured for submission.
