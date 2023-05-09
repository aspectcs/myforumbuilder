# MyForumBuilder 

Add the below content to composer.json in laravel 10

    "require": {
        ....
        "aspectcs/myforumbuilder": "1.0.0"
    },
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/aspectcs/myforumbuilder.git"
        }
    ],

Publish Package

    php artisan vendor:publish --tag=my-forum-builder   
