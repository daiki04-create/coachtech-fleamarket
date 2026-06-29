# coachtech-fleamarket

本プロジェクトは、coachtechの模擬案件に基づいたフリマアプリです。Laravel Sailを用いたDockerベースの環境構築から、Laravel Fortifyによる認証基盤の実装、Stripe決済連携までを網羅した包括的なアプリケーションです。

## 開発環境構築手順

### 1. Laravel Sailのインストール
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    -e COMPOSER_CACHE_DIR=/tmp/composer_cache \
    laravelsail/php82-composer:latest \
    composer require laravel/sail --dev

### 2. Sailの設定ファイルを生成
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    -e COMPOSER_CACHE_DIR=/tmp/composer_cache \
    laravelsail/php82-composer:latest \
    php artisan sail:install --with=mysql

### 3. 認証基盤（Fortify）の実装
./vendor/bin/sail composer require laravel/fortify
./vendor/bin/sail artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider"
./vendor/bin/sail artisan migrate

## 環境変数設定 (.env)
プロジェクトルートの `.env` ファイルに以下の主要な設定を記述しています。

* **App**: `APP_NAME=coachtech-fleamarket`
* **Database**: `DB_HOST=mysql` を指定し、Sail環境のMySQLコンテナと接続します。
* **Mailtrap**: `MAIL_HOST=sandbox.smtp.mailtrap.io` 等のSMTP設定によるメール認証フローの管理。
* **Stripe**: `STRIPE_KEY` および `STRIPE_SECRET` を用いた決済処理機能の統合。

## データベース設計
- [ER図 (.dio)](./.dio)

## 起動方法

### コンテナの起動
```bash
./vendor/bin/sail up -d

### データベースの初期化とシード実行
```bash
./vendor/bin/sail artisan migrate:fresh --seed