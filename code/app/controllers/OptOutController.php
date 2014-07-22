<?php

use Bausch\Repositories\OptOutDomainRepositoryInterface;
use Bausch\Repositories\OptOutEmailRepositoryInterface;

class OptOutController extends \OptController {

    /**
     * domain repository
     * 
     * @var OptOutDomainRepositoryInterface
     */
    private $domain_repo;

    /**
     * email repository
     * 
     * @var OptOutEmailRepositoryInterface
     */
    private $email_repo;

    /**
     * Constructor
     *
     * @param OptOutDomainRepositoryInterface $domain_repo
     * @param OptOutEmailRepositoryInterface $email_repo
     */
    public function __construct(OptOutDomainRepositoryInterface $domain_repo, OptOutEmailRepositoryInterface $email_repo) {
        parent::__construct();

        $this->domain_repo = $domain_repo;
        $this->email_repo = $email_repo;
    }

    /**
     * show emails
     *
     * @return Response
     */
    public function showEmails() {
        $emails = $this->email_repo->findAll();

        return View::make('optout.emails')
                        ->with('emails', $emails);
    }

    /**
     * show domains
     *
     * @return Response
     */
    public function showDomains() {
        $domains = $this->domain_repo->findAll();

        return View::make('optout.domains')
                        ->with('domains', $domains);
    }

}
