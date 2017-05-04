<?php

namespace SQLgreyGUI\Api\v1\Transformers;

use SQLgreyGUI\Models\OptInEmail;

class OptInEmailTransformer extends OptEmailTransformer
{
    /**
     * Transform.
     *
     * @param OptInEmail $email
     *
     * @return array
     */
    public function transform(OptInEmail $email)
    {
        return $this->transformEmail($email);
    }
}
