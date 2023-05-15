# MyForumBuilder 
Step 1:

Add the below content to composer.json in laravel 10

    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/aspectcs/myforumbuilder.git"
        }
    ],

Step 2:

To install package in laravel

Auto

    composer require aspectcs/myforumbuilder
OR

Manual Process

    "require": {
        ....
        "aspectcs/myforumbuilder": "^0.0.1"
    },

use composer update aspectcs/myforumbuilder to update All Packages

    composer update aspectcs/myforumbuilder

Publish Package

    php artisan vendor:publish --tag=my-forum-builder   
