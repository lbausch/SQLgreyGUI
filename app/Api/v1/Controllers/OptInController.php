<?php

namespace SQLgreyGUI\Api\v1\Controllers;

use SQLgreyGUI\Repositories\OptInEmailRepositoryInterface as Emails;
use SQLgreyGUI\Repositories\OptInDomainRepositoryInterface as Domains;
use SQLgreyGUI\Api\v1\Transformers\OptInEmailTransformer as EmailTransformer;
use SQLgreyGUI\Api\v1\Transformers\OptInDomainTransformer as DomainTransformer;

class OptInController extends OptController
{
    /**
     * OptInController constructor.
     *
     * @param Emails  $emails
     * @param Domains $domains
     */
    public function __construct(Emails $emails, Domains $domains)
    {
        parent::__construct();

        $this->emails = $emails;
        $this->domains = $domains;

        $this->emailTransformer = EmailTransformer::class;
        $this->domainTransformer = DomainTransformer::class;
    }
}
