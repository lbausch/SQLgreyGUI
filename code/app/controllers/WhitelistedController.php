<?php

use Bausch\Repositories\FromAwlRepositoryInterface;
use Bausch\Repositories\DomainAwlRepositoryInterface;

class WhitelistedController extends \BaseController {

    /**
     * from repository
     * 
     * @var FromAwlRepositoryInterface
     */
    private $from_repo;

    /**
     * domain repository
     * 
     * @var DomainAwlRepositoryInterface
     */
    private $domain_repo;

    /**
     * Constructor
     * 
     * @param \Bausch\Repositories\FromAwlRepositoryInterface $from_repo
     * @param \Bausch\Repositories\DomainAwlRepositoryInterface $domain_repo
     */
    public function __construct(FromAwlRepositoryInterface $from_repo, DomainAwlRepositoryInterface $domain_repo) {
        $this->from_repo = $from_repo;
        $this->domain_repo = $domain_repo;
        
        Assets::add('dataTable');
    }

    /**
     * show emails
     *
     * @return Response
     */
    public function showEmails() {
        $emails = $this->from_repo->findAll();

        return View::make('whitelisted.emails')
                        ->with('whitelisted_emails', $emails);
    }

    /**
     * show domains
     *
     * @return Response
     */
    public function showDomains() {
        $domains = $this->domain_repo->findAll();

        return View::make('whitelisted.domains')
                        ->with('whitelisted_domains', $domains);
    }

}
