<?php

namespace SQLgreyGUI\Api\v1\Transformers;

use SQLgreyGUI\Models\OptInDomain;

class OptInDomainTransformer extends OptDomainTransformer
{
    /**
     * Transform.
     *
     * @param OptInDomain $domain
     *
     * @return array
     */
    public function transform(OptInDomain $domain)
    {
        return $this->transformDomain($domain);
    }
}
