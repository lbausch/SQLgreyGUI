<?php

namespace SQLgreyGUI\Api\v1\Transformers;

use SQLgreyGUI\Models\OptOutDomain;

class OptOutDomainTransformer extends OptDomainTransformer
{
    /**
     * Transform.
     *
     * @param OptOutDomain $domain
     *
     * @return array
     */
    public function transform(OptOutDomain $domain)
    {
        return $this->transformDomain($domain);
    }
}
