# お問い合わせフォーム

## 開発環境構築

旧教材の通りに`git clone`で構築すると、M4 Macでは環境構築に失敗するので、`Docker compose`を<br>
使わずに`Larsavel Sail`で開発することとした。

### 使用コマンド

- Laravelプロジェクトの作成
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    -e COMPOSER_CACHE_DIR=/tmp/composer_cache \
    laravelsail/php82-composer:latest \
    composer create-project laravel/laravel:^10.0 contact-form
```

- Laravel Sailをインストール
```
cd contact-form
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    -e COMPOSER_CACHE_DIR=/tmp/composer_cache \
    laravelsail/php82-composer:latest \
    composer require laravel/sail --dev
```

- Sailの設定ファイルをパブリッシュ（MySQLを選択）
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    -e COMPOSER_CACHE_DIR=/tmp/composer_cache \
    laravelsail/php82-composer:latest \
    php artisan sail:install --with=mysql
```

- `.env`ファイルの確認
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

- phpMyAdminの追加
`compose.yaml`ファイル中の`mysql`の記述の下に以下を追加。<br>
**インデントレベルに注意！**
```php
    phpmyadmin:
        image: 'phpmyadmin:latest'
        ports:
            - '${FORWARD_PHPMYADMIN_PORT:-8080}:80'
        environment:
            PMA_HOST: mysql
            PMA_USER: '${DB_USERNAME}'
            PMA_PASSWORD: '${DB_PASSWORD}'
        networks:
            - sail
        depends_on:
            - mysql
```

- Sailの起動<br>
※エイリアス登録済みとして記述
```
sail up -d
```

- アプリケーションキーの登録
```
sail artisan key:generate
```

### 動作確認

- Laravelの動作確認
ブラウザで`http://localhost`にアクセスし、Laravelのウェルカム画面が表示されることを確認。

- phpMyAdninの動作確認
ブラウザで`http://localhost:8080`にアクセスし、phpMyAdminnが表示されていることを確認。<br>
⚠️旧教材ではMySQLのバージョンが古くて、M4 Macではうまく構築されず、phpMyAdminが接続エラーになるため。


## 提供ファイルのインポート

フロントエンドプログラムは、旧教材はHTML/CSS、新教材はTailwind CSSなので、
こちらは旧教材のままインポートする。
- `resource/views/index.blade.php`
- `resource/views/confirm.blade.php`
- `resource/views/thanks.blade.php`
- `public/css/sanitize.css`
- `public/css/index.css`
- `public/css/confirm.css`
- `public/css/thanks.css`

