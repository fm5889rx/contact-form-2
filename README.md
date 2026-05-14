# お問い合わせフォーム（機能拡張版）

## Ⅰ。開発環境構築

- 旧教材の通りに`git clone`で構築すると、M4 Macでは環境構築に失敗するので、<br>
`Docker compose`を使わずに`Larsavel Sail`で開発することとした。
- 元のお問い合わせフォームからの`clone`で作成していく。
### 使用コマンド

- `git`イメージのクローン
```
git clone git@githob.com:fm5889rx/contact-form.git contact-form-2
```

- Laravel Sailをインストール
```
cd contact-form-2
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    -e COMPOSER_CACHE_DIR=/tmp/composer_cache \
    laravelsail/php82-composer:latest \
    composer require laravel/sail --dev
```

- .envファイルのコピー
```
cp .env.sample .env
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
内容が違っていたら、以下のように修正する。
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
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

 - Laravel Fortifyのセットアップ
 1. Fortifyのインストール
 ```
 sail composer require laravel/fortify
 ```
 2. Fortifyの設定ファイルを公開
```
sail artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider"
```
4. サービスプロバイダの登録
`config/app.php`にFortifyサービスプロバイダを登録する。
```php
'providers' => [
    // ...既存のプロバイダ

    /*
     * Application Service Providers...
     */
    App\Providers\AppServiceProvider::class,
    // App\Providers\AuthServiceProvider::class,
    // App\Providers\BroadcastServiceProvider::class,
    App\Providers\EventServiceProvider::class,
    App\Providers\RouteServiceProvider::class,
    App\Providers\FortifyServiceProvider::class, // ← この行を追加
])->toArray(),
```


- リポジトリの新規作成
1. `＋`メニューから`New Repository`をクリックする。
2. リポジトリ名を`contact-form-2`にする。
3. Descriptionは入力しないか、後でアプリ概要がわかるようにアプリ名を日本語で記述。
4. `public`/`Private`は`Public`のままにする。
5. `Create repojitory`ボタンをクリックする。
6. `Quick setup`のURL文字列をコピーする。
7. ターミナルから以下のコマンドを**順番に**実行する。
   ```
   git init
   git remote remove origin
   git remote add origin git@github.com:fm5889rx/contact-form-2
   git remote -v
   ```
   **↓**
   ```
   origin <git@githob.com>:fx5889rx/contact-form-2.git (fetch)
   origin <git@githob.com>:fx5889rx/contact-form-2.git (push)
   ```

- リポジトリの反映
ターミナルから以下のコマンドを**順番に**実行する。
   ```
   git add .
   git commit -m "git clone後の開発環境構築"
   git push origin main
   ```


### 動作確認

- Laravelの動作確認
ブラウザで`http://localhost`にアクセスし、Laravelのウェルカム画面が表示されることを確認。

- phpMyAdninの動作確認
ブラウザで`http://localhost:8080`にアクセスし、phpMyAdminが表示されていることを確認。<br>
⚠️旧教材ではMySQLのバージョンが古くて、M4 Macではうまく構築されず、phpMyAdminが接続エラーになるため。


# Ⅱ.機能一覧
