<?php

define('START_URL', getenv('START_URL'));
define('API_URL', getenv('API_URL'));

define('BROWSER', getenv('BEHAT_BROWSER'));
define('SUT_HOST', getenv('SUT_HOST'));
define('CAPTCHA_PASSPHRASE', getenv('CAPTCHA_PASSPHRASE'));
// php artisan jwt:token user 1 --expire="2022-12-31 23:59:59"
define('VALID_TOKEN', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJEZW50YWxTbGVlcFNvbHV0aW9ucyIsInN1YiI6IjEiLCJhdWQiOiJBUEkiLCJqdGkiOiIzNmIzMzlkNThmZGFjNjZhMWIxNTljNmEzNjk3M2JhYyIsImlhdCI6MTUyODAwMzY2MiwiZXhwIjoxNjcyNTQ5MTk5LCJuYmYiOjE1MjgwMDM2NjIsInJvbGUiOiJ1c2VyIiwiaWQiOiIxIn0.ErgaQ2sVSerSxgxwl9KuFR2cVYKUm0xIWsD4jJUzqWk');

define('MEDIUM_WAIT_TIME', getenv('MEDIUM_WAIT_TIME'));
define('SHORT_WAIT_TIME', getenv('SHORT_WAIT_TIME'));
define('VERY_SHORT_WAIT_TIME', getenv('VERY_SHORT_WAIT_TIME'));
