<?php

namespace SQLgreyGUI\Api\v1\Transformers;

use SQLgreyGUI\Models\OptDomain;

abstract class OptDomainTransformer extends Transformer
{
    /**
     * Transform.
     *
     * @param OptDomain $domain
     *
     * @return array
     */
    protected function transformDomain(OptDomain $domain)
    {
        $data = $domain->toArray();
        $data['id'] = $domain->domain;

        return $data;
    }
}
