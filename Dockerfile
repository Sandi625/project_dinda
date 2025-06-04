FROM php:8.2-fpm

# Install Nginx
RUN apt-get update && apt-get install -y nginx

# ... (bagian PHP yang sama seperti di atas) ...

# Copy Nginx config
COPY docker/nginx.conf /etc/nginx/sites-available/default

# Copy script startup
COPY docker/startup.sh /usr/local/bin/startup
RUN chmod +x /usr/local/bin/startup

# Expose port 80 dan 9000
EXPOSE 80 9000

CMD ["/usr/local/bin/startup"]
