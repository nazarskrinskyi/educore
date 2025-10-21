FROM php:8.3-fpm

# Set noninteractive mode for apt
ENV DEBIAN_FRONTEND=noninteractive

# Install system dependencies + Node.js
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev gnupg \
    libicu-dev locales bash bash-completion nano vim less htop \
    && docker-php-ext-install intl pdo_mysql mbstring zip exif pcntl bcmath gd \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# Set locale to UTF-8 (fixes weird terminal chars)
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && locale-gen
ENV LANG=en_US.UTF-8
ENV LANGUAGE=en_US:en
ENV LC_ALL=en_US.UTF-8

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy PHP config
COPY /docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini

# Copy app files
COPY . .

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Install Node/Vite dependencies
RUN npm install && npm run build

# Setup developer-friendly shell
RUN echo '\
# Enable color prompt\n\
force_color_prompt=yes\n\
PS1="\[\033[01;32m\]\u@\h\[\033[00m\]:\[\033[01;34m\]\w\[\033[00m\]\$ "\n\
\n\
# Autocomplete support\n\
if [ -f /etc/bash_completion ]; then . /etc/bash_completion; fi\n\
\n\
# Better history\n\
HISTCONTROL=ignoredups:erasedups\n\
HISTSIZE=5000\n\
HISTFILESIZE=10000\n\
PROMPT_COMMAND="history -a; history -n; $PROMPT_COMMAND"\n\
\n\
# Aliases\n\
alias ll="ls -alF --color=auto"\n\
alias la="ls -A --color=auto"\n\
alias l="ls -CF --color=auto"\n\
alias art="php artisan"\n\
alias tinker="php artisan tinker"\n\
alias sail="./vendor/bin/sail"\n\
' >> /root/.bashrc

# Set permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Expose PHP-FPM port
EXPOSE 9000

CMD ["php-fpm"]
