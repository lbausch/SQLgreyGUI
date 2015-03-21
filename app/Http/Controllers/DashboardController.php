<?php

namespace SQLgreyGUI\Http\Controllers;

use Carbon\Carbon;
use SQLgreyGUI\Repositories\GreylistRepositoryInterface,
    SQLgreyGUI\Repositories\AwlEmailRepositoryInterface,
    SQLgreyGUI\Repositories\AwlDomainRepositoryInterface,
    SQLgreyGUI\Repositories\OptOutEmailRepositoryInterface,
    SQLgreyGUI\Repositories\OptOutDomainRepositoryInterface,
    SQLgreyGUI\Repositories\OptInEmailRepositoryInterface,
    SQLgreyGUI\Repositories\OptInDomainRepositoryInterface;
use Assets,
    View;

class DashboardController extends Controller
{

    private $greylist_repo;
    private $awl_email_repo;
    private $awl_domain_repo;
    private $optout_email_repo;
    private $optout_domain_repo;
    private $optin_email_repo;
    private $optin_domain_repo;

    public function __construct(GreylistRepositoryInterface $greylist_repo, AwlEmailRepositoryInterface $awl_email_repo, AwlDomainRepositoryInterface $awl_domain_repo, OptOutEmailRepositoryInterface $optput_email_repo, OptOutDomainRepositoryInterface $optout_domain_repo, OptInEmailRepositoryInterface $optin_email_repo, OptInDomainRepositoryInterface $optin_domain_repo)
    {
        parent::__construct();

        $this->greylist_repo = $greylist_repo;
        $this->awl_email_repo = $awl_email_repo;
        $this->awl_domain_repo = $awl_domain_repo;
        $this->optout_email_repo = $optput_email_repo;
        $this->optout_domain_repo = $optout_domain_repo;
        $this->optin_email_repo = $optin_email_repo;
        $this->optin_domain_repo = $optin_domain_repo;

        Assets::add('morris');
    }

    /**
     * index
     *
     * @return Response
     */
    public function index()
    {
        $dashboard_data = array(
            'greylist' => $this->greylist_repo->findAll()->count(),
            'awl_emails' => $this->awl_email_repo->findAll()->count(),
            'awl_domains' => $this->awl_domain_repo->findAll()->count(),
            'optout_emails' => $this->optout_email_repo->findAll()->count(),
            'optout_domains' => $this->optout_domain_repo->findAll()->count(),
            'optin_emails' => $this->optin_email_repo->findAll()->count(),
            'optin_domains' => $this->optin_domain_repo->findAll()->count(),
        );

        $greylist_data_tmp = $this->greylist_repo->findByPeriod('30d');
        $greylist_data = array();

        foreach ($greylist_data_tmp as $key => $val) {
            $date = new Carbon($val->getFirstSeen());

            $day = $date->startOfDay()->toDateString();

            if (!isset($greylist_data[$day])) {
                $greylist_data[$day] = 0;
            }

            $greylist_data[$day] ++;
        }

        $dashboard_data['greylist_stats'] = $greylist_data;

        return View::make('dashboard.index')
                        ->with('dashboard', $dashboard_data);
    }

}
