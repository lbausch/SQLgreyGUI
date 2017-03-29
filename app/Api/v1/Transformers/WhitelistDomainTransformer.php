<?php

namespace SQLgreyGUI\Api\v1\Transformers;

use SQLgreyGUI\Models\AwlDomain;

class WhitelistDomainTransformer extends WhitelistTransformer
{
    /**
     * Transform.
     *
     * @param AwlDomain $domain
     *
     * @return array
     */
    public function transform(AwlDomain $domain)
    {
        return $this->transformModel($domain);
    }
}
