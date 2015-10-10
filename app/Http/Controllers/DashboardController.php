<?php

namespace SQLgreyGUI\Http\Controllers;

use SQLgreyGUI\Repositories\GreylistRepositoryInterface as Greylist;
use SQLgreyGUI\Repositories\AwlEmailRepositoryInterface as AwlEmail;
use SQLgreyGUI\Repositories\AwlDomainRepositoryInterface as AwlDomain;
use SQLgreyGUI\Repositories\OptOutEmailRepositoryInterface as OptOutEmail;
use SQLgreyGUI\Repositories\OptOutDomainRepositoryInterface as OptOutDomain;
use SQLgreyGUI\Repositories\OptInEmailRepositoryInterface as OptInEmail;
use SQLgreyGUI\Repositories\OptInDomainRepositoryInterface as OptInDomain;

class DashboardController extends Controller
{
    /**
     * Repository.
     *
     * @var Greylist
     */
    private $greylist;

    /**
     * Repository.
     *
     * @var AwlEmail
     */
    private $awl_email;

    /**
     * Repository.
     *
     * @var AwlDomain
     */
    private $awl_domain;

    /**
     * Repository.
     *
     * @var OptOutEmail
     */
    private $optout_email;

    /**
     * Repository.
     *
     * @var OptOutDomain
     */
    private $optout_domain;

    /**
     * Repository.
     *
     * @var OptInEmail
     */
    private $optin_email;

    /**
     * Repository.
     *
     * @var OptInDomain
     */
    private $optin_domain;

    /**
     * Constructor.
     *
     * @param Greylist     $greylist
     * @param AwlEmail     $awl_email
     * @param AwlDomain    $awl_domain
     * @param OptOutEmail  $optput_email
     * @param OptOutDomain $optout_domain
     * @param OptInEmail   $optin_email
     * @param OptInDomain  $optin_domain
     */
    public function __construct(
        Greylist $greylist,
        AwlEmail $awl_email,
        AwlDomain $awl_domain,
        OptOutEmail $optput_email,
        OptOutDomain $optout_domain,
        OptInEmail $optin_email,
        OptInDomain $optin_domain
    ) {
        parent::__construct();

        $this->greylist = $greylist;
        $this->awl_email = $awl_email;
        $this->awl_domain = $awl_domain;
        $this->optout_email = $optput_email;
        $this->optout_domain = $optout_domain;
        $this->optin_email = $optin_email;
        $this->optin_domain = $optin_domain;
    }

    /**
     * Index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dashboard_data = [
            'greylist' => $this->greylist->findAll()->count(),
            'awl_emails' => $this->awl_email->findAll()->count(),
            'awl_domains' => $this->awl_domain->findAll()->count(),
            'optout_emails' => $this->optout_email->findAll()->count(),
            'optout_domains' => $this->optout_domain->findAll()->count(),
            'optin_emails' => $this->optin_email->findAll()->count(),
            'optin_domains' => $this->optin_domain->findAll()->count(),
        ];

        return view('dashboard.index')
            ->with('dashboard', $dashboard_data);
    }
}
