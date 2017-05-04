<?php

namespace SQLgreyGUI\Api\v1\Transformers;

use SQLgreyGUI\Models\User;

class UserTransformer extends Transformer
{
    /**
     * Transform.
     *
     * @param User $user
     *
     * @return array
     */
    public function transform(User $user)
    {
        $data = $user->toArray();

        return $data;
    }
}
