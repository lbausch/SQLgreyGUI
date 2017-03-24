<?php

namespace SQLgreyGUI\Api\v1\Transformers;

use SQLgreyGUI\Models\Greylist;

class GreylistTransformer extends Transformer
{
    /**
     * Transform.
     *
     * @param Greylist $greylist
     *
     * @return array
     */
    public function transform(Greylist $greylist)
    {
        $id = base64_encode($greylist->toJson());

        $data = $greylist->toArray();
        $data['id'] = $id;

        return $data;
    }
}
