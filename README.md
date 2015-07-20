# ds3-private03
Laravel 5.1 Installation for DS3 API

NOTE* - Every function or line of code added this repo must have a test package or it will not be accepted for merging, any pull request that does not also include a test package
will be deleted. The new testing API rolled into Laravel 5.1 makes testing pretty easy, so writing tests are no longer a nightmare.

See: http://laravel.com/docs/5.1/testing

Writing tests have become pretty easy.

Initial Steps for getting this setup. Post GIT Pull of course.

1. ssh into the vagrant box
2. open gulpfile.js and make sure phpUnit is included as a mix - mix.phpUnit();
3. and run
$npm install
This will install gulp and laravel-elixer.
4. once this install has finished you can run a sample test to make sure testing works as follows:
$ gulp tdd

That's pretty much it to get started. All tests will reside on the default tests folder. There are a few examples pre-loaded in the folder.

