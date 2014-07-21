<?php

App::bind('Bausch\Repositories\ConnectRepositoryInterface', 'Bausch\Repositories\ConnectRepositoryEloquent');
App::bind('Bausch\Repositories\FromAwlRepositoryInterface', 'Bausch\Repositories\FromAwlRepositoryEloquent');
App::bind('Bausch\Repositories\DomainAwlRepositoryInterface', 'Bausch\Repositories\DomainAwlRepositoryEloquent');
