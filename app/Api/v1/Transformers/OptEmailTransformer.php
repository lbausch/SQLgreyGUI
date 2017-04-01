<?php

namespace SQLgreyGUI\Api\v1\Transformers;

use SQLgreyGUI\Models\OptEmail;

abstract class OptEmailTransformer extends Transformer
{
    /**
     * Transform.
     *
     * @param OptEmail $email
     *
     * @return array
     */
    protected function transformEmail(OptEmail $email)
    {
        $data = $email->toArray();
        $data['id'] = $email->email;

        return $data;
    }
}
