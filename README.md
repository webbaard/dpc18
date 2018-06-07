# DPC18 Workshop Bootstrap

Setup:

```
git clone git@github.com:meandmymonkey/dpc18.git dpc18
cd dpc18
composer install
```

At this point, edit `.env` to match your DB config (both MySQL and SQLite are fine).
With the DB config in place, execute:

```
bin/console doctrine:database:create
bin/console dpc:fixtures
bin/console server:start
```
