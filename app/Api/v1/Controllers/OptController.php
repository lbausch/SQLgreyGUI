<?php

namespace SQLgreyGUI\Api\v1\Controllers;

use Illuminate\Http\Request;
use SQLgreyGUI\Api\v1\Exceptions\ValidationException;
use SQLgreyGUI\Api\v1\Transformers\OptDomainTransformer;
use SQLgreyGUI\Api\v1\Transformers\OptEmailTransformer;

class OptController extends Controller
{
    /**
     * Domain repository.
     *
     * @var \SQLgreyGUI\Repositories\OptDomainRepositoryInterface
     */
    protected $domains;

    /**
     * Email repository.
     *
     * @var \SQLgreyGUI\Repositories\OptEmailRepositoryInterface
     */
    protected $emails;

    /**
     * Email transformer class.
     *
     * @var OptEmailTransformer
     */
    protected $emailTransformer;

    /**
     * Domain transformer class.
     *
     * @var OptDomainTransformer
     */
    protected $domainTransformer;

    /**
     * Get emails.
     *
     * @return \Illuminate\Http\Response
     */
    public function emails()
    {
        $emails = $this->emails->findAll();

        return $this->respondCollection($emails, new $this->emailTransformer());
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
        ]);

        $email = $this->emails->instance($request->input());

        if ($this->emails->findByEmail($email->getEmail())) {
            throw new ValidationException('This email is already present');
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

        // Convert the data
        foreach ($raw_items as $item) {
            $delete_entries->push($this->emails->instance([
                'email' => $item,
            ]));
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

        return $this->respondCollection($domains, new $this->domainTransformer());
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
        ]);

        $domain = $this->domains->instance($request->input());

        if ($this->domains->findByDomain($domain->getDomain())) {
            throw new ValidationException('This domain is already present');
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

        // Convert the data
        foreach ($raw_items as $item) {
            $delete_entries->push($this->domains->instance([
                'domain' => $item,
            ]));
        }

        foreach ($delete_entries as $item) {
            $this->domains->destroy($item);
        }

        return $this->respondSuccess();
    }
}
