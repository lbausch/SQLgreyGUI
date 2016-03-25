<?php

namespace SQLgreyGUI\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use SQLgreyGUI\Repositories\AwlEmailRepositoryInterface as Emails;
use SQLgreyGUI\Repositories\AwlDomainRepositoryInterface as Domains;
use SQLgreyGUI\Models\AwlEmail as Email;
use SQLgreyGUI\Models\AwlDomain as Domain;

class WhitelistController extends Controller
{
    /**
     * Email repository.
     *
     * @var Emails
     */
    private $emails;

    /**
     * Domain repository.
     *
     * @var Domains
     */
    private $domains;

    /**
     * Constructor.
     *
     * @param Emails  $emails
     * @param Domains $domains
     */
    public function __construct(Emails $emails, Domains $domains)
    {
        parent::__construct();

        $this->emails = $emails;
        $this->domains = $domains;
    }

    /**
     * Show emails.
     *
     * @return \Illuminate\Http\Response
     */
    public function showEmails()
    {
        $emails = $this->emails->findAll();

        return view('whitelist.emails')
            ->with('whitelist_emails', $emails);
    }

    /**
     * Add email.
     *
     * @return \Illuminate\Http\Response
     */
    public function addEmail(Request $req)
    {
        $this->validate($req, Email::$rules);

        $new_email = $this->emails->instance($req->input());
        $new_email->first_seen = Carbon::now();
        $new_email->last_seen = Carbon::now();

        $this->emails->store($new_email);

        return redirect(action('WhitelistController@showEmails'))
            ->withSuccess($new_email->getSenderName().'@'.$new_email->getSenderDomain().' from '.$new_email->getSource().' added');
    }

    /**
     * Delete emails.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteEmails()
    {
        $items = $this->parseEntries('whitelist_emails', \SQLgreyGUI\Repositories\AwlEmailRepositoryInterface::class);

        $message = [];

        foreach ($items as $key => $val) {
            $this->emails->destroy($val);

            $message[] = '<li>'.$val->getSenderName().'@'.$val->getSenderDomain().' from '.$val->getSource().'</li>';
        }

        return redirect(action('WhitelistController@showEmails'))
            ->withSuccess('deleted the following entries:<ul>'.implode(PHP_EOL, $message).'</ul>');
    }

    /**
     * Show domains.
     *
     * @return \Illuminate\Http\Response
     */
    public function showDomains()
    {
        $domains = $this->domains->findAll();

        return view('whitelist.domains')
            ->with('whitelist_domains', $domains);
    }

    /**
     * Add domain.
     *
     * @return \Illuminate\Http\Response
     */
    public function addDomain(Request $req)
    {
        $this->validate($req, Domain::$rules);

        $new_domain = $this->domains->instance($req->input());
        $new_domain->first_seen = Carbon::now();
        $new_domain->last_seen = Carbon::now();

        $this->domains->store($new_domain);

        return redirect(action('WhitelistController@showDomains'))
            ->withSuccess($new_domain->getSenderDomain().' from '.$new_domain->getSource().' added');
    }

    /**
     * Delete domains.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteDomains()
    {
        $items = $this->parseEntries('whitelist_domains', \SQLgreyGUI\Repositories\AwlDomainRepositoryInterface::class);

        $message = [];

        foreach ($items as $key => $val) {
            $this->domains->destroy($val);

            $message[] = '<li>'.$val->getSenderDomain().' from '.$val->getSource().'</li>';
        }

        return redirect(action('WhitelistController@showDomains'))
            ->withSuccess('deleted the following entries:<ul>'.implode(PHP_EOL, $message).'</ul>');
    }
}
