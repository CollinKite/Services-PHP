#Create image
#docker build -t my-php-app .

#Run Image
#docker run -p 8080:80 -d my-php-app
# docker run -p 8080:80 -it --rm --name my-running-app my-php-app


# Use the official PHP 8.0 on ARM64 architecture with Apache as a parent image
FROM arm64v8/php:8.2-apache

# Make port 80 available to the world outside this container
EXPOSE 80

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Change the ownership of all the files to the apache user and adjust the permissions.
RUN chown -R www-data:www-data /var/www/html/ && chmod -R 755 /var/www/html/

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Restart Apache
RUN service apache2 restart
