<?php

namespace Bausch\Repositories;

interface OptEmailRepositoryInterface extends BaseRepositoryInterface {

    /**
     * destroy email
     * 
     * @param Email $email
     */
    public function destroy($email);
}
