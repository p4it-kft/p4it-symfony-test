### `symfony new --webapp my_symfony_form`

### `symfony server:start`
böngészőben oldal betöltése

### `php bin/console doctrine:database:create`
.env-ben beállított adatbázis létrehozása

### `php bin/console make:entity`
adatmodel osztály létrehozása

### `php bin/console make:migration`
létrehozza az adatmodel osztályhoz a migrációt

### `php bin/console doctrine:migrations:migrate`
lefuttatja a migrációt

### `symfony console make:controller HomeController`
főoldal controllerének létrehozása

### `php bin/console doctrine:migrations:generate`
új migráció készítése<br>
sajnos névvel nem lehet készíteni, csak átnevezni lehet, de csak úgy, ha átírunk valami length beállítást valahol

### `php bin/console doctrine:migrations:migrate`
migrációk futtatása

### `php bin/console doctrine:mapping:import "App\Entity" annotation --path=src/Entity`
összes entity legenerálása az összes táblából (beleértve a doctrine_migration_versions táblát is)

### `composer require rector/rector --dev`  (ha nem lenne feltelepítve)
### `vendor/bin/rector process src`
php annotation -> php 8 attributes

### `php bin/console make:entity --regenerate "App\Entity"`
setter és getter metódusok hozzáadása

---

### `php bin/console doctrine:mapping:import "App\Entity\All" annotation --path=src/Entity/All`
### `vendor/bin/rector process src/Entity/All`
### `php bin/console make:entity --regenerate "App\Entity\All"`
- összes entity legenerálása az All könyvtárba és ez is legyen a namespace vége is
- php annotation -> php 8 attributes az All könyvtárban levő entity-kre
- setter és getter metódusok hozzáadása az All könyvtárban levő entity-khez

---

