<?php

use Bausch\Repositories\AwlEmailRepositoryInterface;
use Bausch\Repositories\AwlDomainRepositoryInterface;

class WhitelistController extends \BaseController {

    /**
     * email repository
     * 
     * @var AwlEmailRepositoryInterface
     */
    private $email_repo;

    /**
     * domain repository
     * 
     * @var AwlDomainRepositoryInterface
     */
    private $domain_repo;

    /**
     * Constructor
     * 
     * @param \Bausch\Repositories\AwlEmailRepositoryInterface $email_repo
     * @param \Bausch\Repositories\AwlDomainRepositoryInterface $domain_repo
     */
    public function __construct(AwlEmailRepositoryInterface $email_repo, AwlDomainRepositoryInterface $domain_repo) {
        parent::__construct();

        $this->email_repo = $email_repo;
        $this->domain_repo = $domain_repo;

        Assets::add('dataTable');
    }

    /**
     * show emails
     *
     * @return Response
     */
    public function showEmails() {
        $emails = $this->email_repo->findAll();
        
        return View::make('whitelist.emails')
                        ->with('whitelist_emails', $emails);
    }

    /**
     * show domains
     *
     * @return Response
     */
    public function showDomains() {
        $domains = $this->domain_repo->findAll();

        return View::make('whitelist.domains')
                        ->with('whitelist_domains', $domains);
    }

}
