
# ==========================================
# Stage 1: Build PHP application
# ==========================================
FROM php:8.2-apache AS builder

WORKDIR /var/www/html

# Install MySQLi extension
RUN docker-php-ext-install mysqli

# Copy application source code
COPY . .

# ==========================================
# Stage 2: Production runtime
# ==========================================
FROM php:8.2-apache AS production

WORKDIR /var/www/html

# Copy compiled PHP extensions and configuration
COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

# Copy application files
COPY --from=builder --chown=www-data:www-data /var/www/html/ /var/www/html/

# Configure Apache for non-root execution
RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:8080>/' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's|/var/run/apache2|/tmp/apache2|g; s|/var/lock/apache2|/tmp/apache2|g; s|/var/log/apache2|/tmp/apache2|g' /etc/apache2/envvars \
    && a2enmod rewrite \
    && mkdir -p /tmp/apache2 \
    && chown -R www-data:www-data /tmp/apache2 /var/www/html

USER www-data

EXPOSE 8080

CMD ["apache2-foreground"]
