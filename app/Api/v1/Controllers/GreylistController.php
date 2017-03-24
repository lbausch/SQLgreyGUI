<?php

namespace SQLgreyGUI\Api\v1\Controllers;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SQLgreyGUI\Api\v1\Repositories\GreylistRepositoryInterface as Greylisted;
use SQLgreyGUI\Api\v1\Repositories\AwlEmailRepositoryInterface as WhitelistedEmails;
use SQLgreyGUI\Api\v1\Transformers\GreylistTransformer;

class GreylistController extends Controller
{
    /**
     * Repository.
     *
     * @var Greylisted
     */
    protected $greylisted;

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

        return $this->respondCollection($data, new GreylistTransformer());
    }

    /**
     * Delete entries.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $delete_entries = collect();

        $raw_items = $request->input('items');

        // Try to convert the data
        foreach ($raw_items as $item) {
            $tmp_item = $this->convertData($item);

            if ($tmp_item) {
                $delete_entries->push($this->greylisted->instance($tmp_item));
            }
        }

        foreach ($delete_entries as $item) {
            $this->greylisted->destroy($item);
        }

        return $this->respondSuccess();
    }

    /*
     * Delete by date.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    /*public function deleteByDate(Request $request)
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
    }*/

    /*
     * Move entries to whitelist.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function move(WhitelistedEmails $whitelistedEmails)
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
    }*/
}
