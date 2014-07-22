<?php

App::bind('Bausch\Repositories\ConnectRepositoryInterface', 'Bausch\Repositories\ConnectRepositoryEloquent');
App::bind('Bausch\Repositories\FromAwlRepositoryInterface', 'Bausch\Repositories\FromAwlRepositoryEloquent');
App::bind('Bausch\Repositories\DomainAwlRepositoryInterface', 'Bausch\Repositories\DomainAwlRepositoryEloquent');

App::bind('Bausch\Repositories\OptOutDomainRepositoryInterface', 'Bausch\Repositories\OptOutDomainRepositoryEloquent');
App::bind('Bausch\Repositories\OptInDomainRepositoryInterface', 'Bausch\Repositories\OptInDomainRepositoryEloquent');

App::bind('Bausch\Repositories\OptOutEmailRepositoryInterface', 'Bausch\Repositories\OptOutEmailRepositoryEloquent');
App::bind('Bausch\Repositories\OptInEmailRepositoryInterface', 'Bausch\Repositories\OptInEmailRepositoryEloquent');