## DS3 Software

[THIS PAGE SHOULD BE MIGRATED TO REPO -03 FOR API WORK]
REPO -02 IS LEGACY AND DEPRECATED

#### 1 Master branch is PRODUCTION code
#### 2 Develop branch is STAGING code, where Unit Tests and final QA are performed
#### 3 'Feature' branches used to develop each component
##### Workflow
1 Develop each feature in separate branch with prefix related to Jira issue like "DSS-544-new-feature".

2 Run Unit tests on Develop branch, perform QA testing.

3 If tests pass and QA good, merge Develop in Master. Deploy to Staging. [TO DO]


#### How to Install
#### Instructions

[TO DO - UPDATE WITH DOCKER INSTRUCTIONS]

1 Install composer from https://getcomposer.org/download

2 Open terminal and run this command where you want to place your code -> ```git clone    
   git@github.com:dentalsleepsolutions/ds3-private03.git```
   
3 cd into ds3-private03 folder and run this command -> composer update

NOTE: The first time you do this, if you get an error, you should run ```composer update --no-scripts```
[link to solution](https://stackoverflow.com/questions/28468625/laravel-5-failed-opening-required-bootstrap-vendor-autoload-php)

4 create file under config folder -> database.php and use contents of this gist in database.php   
   https://gist.github.com/unknownArtist/e26091bac90bbb905060  [NEED TO UPDATE]
   
5 In database.php under connections set your database credientials for mysql [FIX WITH DOCKER]

6 Open terminal and run php artisan migrate

7 Open terminal and run php artisan db:seed

NEW: Configuring your IDE to interpret Laravel can be setup [here](https://www.dunebook.com/5-best-ide-laravel-ide-with-laravel-ide-helper/) and Laracast tutorial [here](https://laracasts.com/series/how-to-be-awesome-in-phpstorm/episodes/15) and Github link [here](https://github.com/barryvdh/laravel-ide-helper).
