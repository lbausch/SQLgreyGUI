<?php

namespace SQLgreyGUI\Api\v1\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use SQLgreyGUI\Api\v1\Exceptions\ValidationException;
use SQLgreyGUI\Api\v1\Transformers\WhitelistEmailTransformer;
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
    protected $emails;

    /**
     * Domain repository.
     *
     * @var Domains
     */
    protected $domains;

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
     * Get emails.
     *
     * @return \Illuminate\Http\Response
     */
    public function emails()
    {
        $emails = $this->emails->findAll();

        return $this->respondCollection($emails, new WhitelistEmailTransformer());
    }

    /**
     * Add email.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws ValidationException
     */
    public function addEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'source' => [
                'required',
                'regex:/^([0-9]{1,3})(\.[0-9]{1,3})(\.[0-9]{1,3})(\.[0-9]{1,3})?$/',
            ],
        ]);

        $tmp_email = explode('@', $request->input('email'));

        $email = $this->emails->instance([
            'sender_name' => $tmp_email[0],
            'sender_domain' => $tmp_email[1],
            'src' => $request->input('source'),
            'first_seen' => Carbon::now(),
            'last_seen' => Carbon::now(),
        ]);


        if ($this->emails->findByNameDomainSource($email->getSenderName(), $email->getSenderDomain(), $email->getSource())) {
            throw new ValidationException('This combination of email address and source is already whitelisted');
        }

        $this->emails->store($email);

        return $this->respondSuccess();
    }

    /**
     * Delete emails.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteEmails(Request $request)
    {
        $delete_entries = collect();

        $raw_items = $request->input('items');

        // Try to convert the data
        foreach ($raw_items as $item) {
            $tmp_item = $this->convertData($item);

            if ($tmp_item) {
                $delete_entries->push($this->emails->instance($tmp_item));
            }
        }

        foreach ($delete_entries as $item) {
            $this->emails->destroy($item);
        }

        return $this->respondSuccess();
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

        $domain = $this->domains->instance($req->input());
        $domain->first_seen = Carbon::now();
        $domain->last_seen = Carbon::now();

        if ($this->domains->findByDomainSource($domain->getSenderDomain(), $domain->getSource())) {
            return redirect(action('WhitelistController@showDomains'))
                ->withWarning($domain->getSenderDomain().' from '.$domain->getSource().' is already whitelisted');
        }

        $this->domains->store($domain);

        return redirect(action('WhitelistController@showDomains'))
            ->withSuccess($domain->getSenderDomain().' from '.$domain->getSource().' added');
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
