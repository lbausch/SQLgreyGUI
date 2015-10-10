<?php

namespace SQLgreyGUI\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Assets;
use DB;
use SQLgreyGUI\Repositories\GreylistRepositoryInterface as Greylist;

class GreylistController extends Controller
{
    /**
     * Repository.
     *
     * @var Greylist
     */
    private $repo;

    /**
     * Constructor.
     *
     * @param Greylist $repo
     */
    public function __construct(Greylist $repo)
    {
        parent::__construct();

        $this->repo = $repo;
    }

    /**
     * Index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Assets::add('datetimepicker');

        $carbon = Carbon::now();
        $timestamp = $carbon->getTimestamp();

        $data = $this->repo->findAll();

        $user_repo = app(\SQLgreyGUI\Repositories\UserRepositoryInterface::class);

        $users = $user_repo->findAll();

        $user_emails = [];

        foreach ($users as $key => $val) {
            $user_emails[$val->getEmail()] = $val;
        }

        return view('greylist.index')
            ->with('greylist', $data)
            ->with('timestamp', $timestamp)
            ->with('user_emails', $user_emails);
    }

    /**
     * Delete entries.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete()
    {
        $items = $this->parseEntries('greylist', Greylist::class);

        $message = [];

        foreach ($items as $key => $val) {
            $this->repo->destroy($val);

            $message[] = '<li>'.$val->getSenderName().'@'.$val->getSenderDomain().' from '.$val->getSource().' for '.$val->getRecipient().'</li>';
        }

        return redirect(action('GreylistController@index'))
            ->withSuccess('deleted the following entries:<ul>'.implode(PHP_EOL, $message).'</ul>');
    }

    /**
     * Delete by date.
     *
     * @param Request $req
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteByDate(Request $req)
    {
        $date = $req->input('delete_by_date');

        if (!$date) {
            return redirect(action('GreylistController@index'))
                ->withError('invalid date');
        }

        $carbon = Carbon::createFromFormat('Y-m-d H:i', $date);

        $num = $this->repo->destroyOlderThan($carbon);

        return redirect(action('GreylistController@index'))
            ->withSuccess('deleted entries: '.$num);
    }

    /**
     * Move entries.
     *
     * @return \Illuminate\Http\Response
     */
    public function move()
    {
        $items = $this->parseEntries('greylist', Greylist::class);

        $whitelist = app(\SQLgreyGUI\Repositories\AwlEmailRepositoryInterface::class);

        $messages = [];

        foreach ($items as $key => $val) {
            // convert Greylist to AwlEmail
            $email = $whitelist->instance([
                'sender_name' => $val->getSenderName(),
                'sender_domain' => $val->getSenderDomain(),
                'src' => $val->getSource(),
                'first_seen' => $val->getFirstSeen(),
                'last_seen' => $val->getFirstSeen(),
            ]);

            DB::transaction(function () use (&$val, &$email, &$whitelist) {
                // delete from Greylist
                $this->repo->destroy($val);

                // insert into whitelist
                $whitelist->store($email);
            });

            $messages[] = '<li>'.$email->getSenderName().'@'.$email->getSenderDomain().' from '.$email->getSource().'</li>';
        }

        return redirect(action('GreylistController@index'))
            ->withSuccess('moved the following entries to the Whitelist: <ul>'.implode(PHP_EOL, $messages).'</ul>');
    }

    /**
     * Live.
     *
     * @return \Illuminate\Http\Response
     */
    public function live(Request $req)
    {
        $carbon = Carbon::now();
        $now = $carbon->getTimestamp();

        $timestamp = $req->input('timestamp');

        $new_entries = $this->repo->findBetween($timestamp, $now);

        // debug
//        $new_entries->push($this->repo->instance([
//                    'sender_name' => 'argl',
//                    'first_seen' => $carbon->toDateTimeString(),
//        ]));

        if ($new_entries->count() < 1) {
            return response()->json(['timestamp' => $now]);
        }

        $payload = [];

        $i = 0;
        foreach ($new_entries as $key => $val) {
            $payload[$i] = $val->toArray();
            $payload[$i]['checkbox'] = \Form::checkbox('greylist[]', \Html::cval($val));
            ++$i;
        }

        return response()->json([
            'timestamp' => $now,
            'payload' => $payload,
        ]);
    }
}
