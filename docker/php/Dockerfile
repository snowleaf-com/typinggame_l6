# ベースイメージにPHP 7.2を指定
FROM php:7.2-fpm

# 必要なパッケージをインストール
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Composerのインストール
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# Node.jsとnpmのインストール（フロントエンドのビルド用）
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash - && \
    apt-get install -y nodejs

# 作業ディレクトリを設定
WORKDIR /var/www/html

# 権限を変更（オプション、環境に応じて調整）
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Laravel環境の設定
CMD ["php-fpm"]