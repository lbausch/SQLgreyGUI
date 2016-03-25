<?php

namespace SQLgreyGUI\Http\Controllers;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SQLgreyGUI\Repositories\GreylistRepositoryInterface as Greylisted;
use SQLgreyGUI\Repositories\AwlEmailRepositoryInterface as WhitelistedEmails;

class GreylistController extends Controller
{
    /**
     * Repository.
     *
     * @var Greylisted
     */
    private $greylisted;

    /**
     * Constructor.
     *
     * @param Greylisted $greylisted
     */
    public function __construct(Greylisted $greylisted)
    {
        parent::__construct();

        $this->greylisted = $greylisted;
    }

    /**
     * Show greylisted entries.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->greylisted->findAll();

        return view('greylist.index')
            ->with('greylist', $data);
    }

    /**
     * Delete entries.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete()
    {
        $items = $this->parseEntries('greylist', Greylisted::class);

        $message = [];

        foreach ($items as $key => $val) {
            $this->greylisted->destroy($val);

            $message[] = '<li>'.$val->getSenderName().'@'.$val->getSenderDomain().' from '.$val->getSource().' for '.$val->getRecipient().'</li>';
        }

        return redirect(action('GreylistController@index'))
            ->withSuccess('deleted the following entries:<ul>'.implode(PHP_EOL, $message).'</ul>');
    }

    /**
     * Delete by date.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteByDate(Request $request)
    {
        $date = $request->input('delete_by_date');

        if (!$date) {
            return redirect(action('GreylistController@index'))
                ->withError('invalid date');
        }

        $carbon = Carbon::createFromFormat('Y-m-d H:i:s', $date);

        $this->greylisted->destroyOlderThan($carbon);

        return redirect(action('GreylistController@index'))
            ->withSuccess('deleted entries older than '.$carbon->toDateTimeString());
    }

    /**
     * Move entries to whitelist.
     *
     * @return \Illuminate\Http\Response
     */
    public function move(WhitelistedEmails $whitelistedEmails)
    {
        $items = $this->parseEntries('greylist', Greylisted::class);

        $messages = [];

        foreach ($items as $key => $val) {
            // Convert Greylist to AwlEmail
            $email = $whitelistedEmails->instance([
                'sender_name' => $val->getSenderName(),
                'sender_domain' => $val->getSenderDomain(),
                'src' => $val->getSource(),
                'first_seen' => $val->getFirstSeen(),
                'last_seen' => $val->getFirstSeen(),
            ]);

            DB::transaction(function () use ($val, $email, $whitelistedEmails) {
                // Delete from Greylist
                $this->greylisted->destroy($val);

                // Insert into whitelist
                $whitelistedEmails->store($email);

            });

            $messages[] = '<li>'.$email->getSenderName().'@'.$email->getSenderDomain().' from '.$email->getSource().'</li>';
        }

        return redirect(action('GreylistController@index'))
            ->withSuccess('moved the following entries to the Whitelist: <ul>'.implode(PHP_EOL, $messages).'</ul>');
    }
}
