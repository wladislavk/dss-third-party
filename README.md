# ds3-private03
Laravel 5.1 Installation for DS3 API

NOTE* - Every function or line of code added this repo must have a test package or it will not be accepted for merging, any pull request that does not also include a test package
will be deleted. The new testing API rolled into Laravel 5.1 makes testing pretty easy, so writing tests are no longer a nightmare.

See: http://laravel.com/docs/5.1/testing

Writing tests have become pretty easy.

Initial Steps for getting this setup. Post GIT Pull of course.

1. ssh into the vagrant box
2. composer install if you've not already done so.
3. running vendor/bin/phpunit does not work out of the box for some reason.
   Fix* - sudo apt-get install phpunit - this will throw an error, ignore the error and run sudo apt-get update --fix-missing
        - then run sudo apt-get install phpunit a 2nd time, also ignore the fact that it will try to start apache...
        Now just run phpunit without vendor/bin/phpunit and all works fine.

Note* - Laracasts integrated package is no longer required, its all backed into 5.1

That's pretty much it to get started. All tests will reside in the default tests folder. There are a few examples pre-loaded in the folder.

