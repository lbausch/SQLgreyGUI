<?php

namespace SQLgreyGUI\Api\v1\Transformers;

use League\Fractal\TransformerAbstract;

abstract class Transformer extends TransformerAbstract
{
    /**
     * Generate ID.
     *
     * @param string $json
     *
     * @return string
     */
    protected function generateId($json)
    {
        return base64_encode($json);
    }

    /**
     * Transform Model.
     *
     * @param $model
     *
     * @return array
     */
    protected function transformModel($model)
    {
        $data = $model->toArray();
        $data['id'] = $this->generateId($model->toJson());

        return $data;
    }
}
