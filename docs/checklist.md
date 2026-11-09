# Assignment checklist

## Required
- [x] Existing meaningful application retained; add/edit/delete verified by CI HTTP smoke test.
- [x] Source, README, Dockerfile, .dockerignore, .gitignore, docs and screenshots directory.
- [x] Dockerfile provides the runtime, working directory, limited copy and command; no app packages required.
- [x] README covers stack, Docker, configuration, testing, cleanup and attribution.
- [x] Existing history preserved, feature branch pushed and pull request opened.
- [x] Multiple meaningful commits and technical notes.
- [x] Docker image built and container tested in GitHub Actions.
- [ ] Test Docker Compose and the full UI locally; capture a running-container status and working app screenshot.
- [ ] Complete the PDF with full name, student ID and all evidence; keep matching screenshots here.
- [ ] Decide whether to add a license; none was declared in the original repository.

## Bonuses
- [x] Compose configuration prepared; local verification pending.
- [x] GitHub Actions image build and CRUD smoke test passed.
- [ ] Multi-stage: intentionally omitted; there are no build artifacts or dependencies to separate.
- [x] Health endpoint and Docker HEALTHCHECK configured. HTTP endpoint passed in CI; Docker health status still needs inspection.
- [x] Makefile prepared.
- [x] Feature branch and open pull request.
