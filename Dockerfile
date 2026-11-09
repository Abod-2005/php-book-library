FROM php:8.3-cli
WORKDIR /app
COPY src/ /app/
USER www-data
EXPOSE 8080
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 CMD php -r "exit(@file_get_contents('http://127.0.0.1:8080/health.php') === 'OK' ? 0 : 1);"
CMD ["php", "-S", "0.0.0.0:8080", "-t", "/app"]
