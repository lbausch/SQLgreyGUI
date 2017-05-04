<?php

namespace SQLgreyGUI\Api\v1\Transformers;

use SQLgreyGUI\Models\OptOutEmail;

class OptOutEmailTransformer extends OptEmailTransformer
{
    /**
     * Transform.
     *
     * @param OptOutEmail $email
     *
     * @return array
     */
    public function transform(OptOutEmail $email)
    {
        return $this->transformEmail($email);
    }
}
