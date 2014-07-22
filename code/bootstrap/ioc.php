<?php

App::bind('Bausch\Repositories\UserRepositoryInterface', 'Bausch\Repositories\UserRepositoryEloquent');

App::bind('Bausch\Repositories\GreylistRepositoryInterface', 'Bausch\Repositories\GreylistRepositoryEloquent');
App::bind('Bausch\Repositories\AwlEmailRepositoryInterface', 'Bausch\Repositories\AwlEmailRepositoryEloquent');
App::bind('Bausch\Repositories\AwlDomainRepositoryInterface', 'Bausch\Repositories\AwlDomainRepositoryEloquent');

App::bind('Bausch\Repositories\OptOutDomainRepositoryInterface', 'Bausch\Repositories\OptOutDomainRepositoryEloquent');
App::bind('Bausch\Repositories\OptInDomainRepositoryInterface', 'Bausch\Repositories\OptInDomainRepositoryEloquent');

App::bind('Bausch\Repositories\OptOutEmailRepositoryInterface', 'Bausch\Repositories\OptOutEmailRepositoryEloquent');
App::bind('Bausch\Repositories\OptInEmailRepositoryInterface', 'Bausch\Repositories\OptInEmailRepositoryEloquent');