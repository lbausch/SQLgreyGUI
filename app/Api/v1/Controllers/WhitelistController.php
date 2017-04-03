<?php

namespace SQLgreyGUI\Api\v1\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use SQLgreyGUI\Api\v1\Exceptions\ValidationException;
use SQLgreyGUI\Api\v1\Transformers\WhitelistDomainTransformer;
use SQLgreyGUI\Api\v1\Transformers\WhitelistEmailTransformer;
use SQLgreyGUI\Repositories\AwlEmailRepositoryInterface as Emails;
use SQLgreyGUI\Repositories\AwlDomainRepositoryInterface as Domains;

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
        ], [], ['source' => 'IP Address']);

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
            $tmp_item = $this->decodeData($item);

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
     * Get domains.
     *
     * @return \Illuminate\Http\Response
     */
    public function domains()
    {
        $domains = $this->domains->findAll();

        return $this->respondCollection($domains, new WhitelistDomainTransformer());
    }

    /**
     * Add domain.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws ValidationException
     */
    public function addDomain(Request $request)
    {
        $this->validate($request, [
            'domain' => 'required',
            'source' => [
                'required',
                'regex:/^([0-9]{1,3})(\.[0-9]{1,3})(\.[0-9]{1,3})(\.[0-9]{1,3})?$/',
            ],
        ], [], ['source' => 'IP Address']);

        $domain = $this->domains->instance([
            'sender_domain' => $request->input('domain'),
            'src' => $request->input('source'),
            'first_seen' => Carbon::now(),
            'last_seen' => Carbon::now(),
        ]);

        if ($this->domains->findByDomainSource($domain->getSenderDomain(), $domain->getSource())) {
            throw new ValidationException('Domain and Source IP is alread whitelisted');
        }

        $this->domains->store($domain);

        return $this->respondSuccess();
    }

    /**
     * Delete domains.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteDomains(Request $request)
    {
        $delete_entries = collect();

        $raw_items = $request->input('items');

        // Try to convert the data
        foreach ($raw_items as $item) {
            $tmp_item = $this->decodeData($item);

            if ($tmp_item) {
                $delete_entries->push($this->domains->instance($tmp_item));
            }
        }

        foreach ($delete_entries as $item) {
            $this->domains->destroy($item);
        }

        return $this->respondSuccess();
    }
}
