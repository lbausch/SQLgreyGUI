<?php

namespace SQLgreyGUI\Api\v1\Controllers;

use SQLgreyGUI\Api\v1\Transformers\OptOutDomainTransformer as DomainTransformer;
use SQLgreyGUI\Api\v1\Transformers\OptOutEmailTransformer as EmailTransformer;
use SQLgreyGUI\Repositories\OptOutDomainRepositoryInterface as Domains;
use SQLgreyGUI\Repositories\OptOutEmailRepositoryInterface as Emails;

class OptOutController extends OptController
{
    /**
     * OptOutController constructor.
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
