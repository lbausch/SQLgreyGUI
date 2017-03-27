<?php

namespace SQLgreyGUI\Api\v1\Transformers;

use SQLgreyGUI\Models\AwlEmail;

class WhitelistEmailTransformer extends WhitelistTransformer
{
    /**
     * Transform.
     *
     * @param AwlEmail $$email
     *
     * @return array
     */
    public function transform(AwlEmail $email)
    {
        return $this->transformModel($email);
    }
}
