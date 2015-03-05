## DS3 Software

##### 1 Master branch is PRODUCTION code
##### 2 Develop branch is STAGING code, where Unit Tests and final QA are performed
##### 3 'Feature' branches used to develop each component
###### Workflow
1 Develop each feature in separate branch with prefix "feature-".  For example "feature-email".

2 Merge 'feature' branch into "develop"

3 Run Unit tests on Develop branch, perform QA testing.

4 If tests pass and QA good, merge Develop in Master. Deploy to Production.


#### How to Install
##### Prerequisite
#######  Vagrant + Homestead ( kindly follow this link https://laracasts.com/lessons/say-hello-to-laravel-homestead-two )
#### Instructions
1 Install composer from https://getcomposer.org/download

2 Open terminal and run this command where you want to place your code -> git clone    
   git@github.com:dentalsleepsolutions/ds3-private02.git
   
3 cd into ds3-private02 folder and run this command -> composer update

4 create file under config folder -> database.php and use contents of this gist in database.php   
   https://gist.github.com/unknownArtist/e26091bac90bbb905060
   
5 In database.php under connections set your database credientials for mysql

6 Open terminal and run php artisan migrate

7 Open terminal and run php artisan db:seed

