<?php

namespace SQLgreyGUI\Api\v1\Controllers;

use Carbon\Carbon;
use Illuminate\Database\Connection as Database;
use Illuminate\Http\Request;
use SQLgreyGUI\Api\v1\Transformers\GreylistTransformer;
use SQLgreyGUI\Repositories\AwlEmailRepositoryInterface as WhitelistedEmails;
use SQLgreyGUI\Repositories\GreylistRepositoryInterface as Greylisted;

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
            $tmp_item = $this->decodeData($item);

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

    /**
     * Move entries to whitelist.
     *
     * @param Request           $request
     * @param Database          $database
     * @param WhitelistedEmails $whitelistedEmails
     *
     * @return \Illuminate\Http\Response
     */
    public function move(Request $request, Database $database, WhitelistedEmails $whitelistedEmails)
    {
        $move_records = collect();

        $raw_recors = $request->input('items');

        // Try to convert the data
        foreach ($raw_recors as $record) {
            $tmp_record = $this->decodeData($record);

            if ($tmp_record) {
                $move_records->push($this->greylisted->instance($tmp_record));
            }
        }

        foreach ($move_records as $greylisted_record) {
            // Convert Greylist to AwlEmail
            $email = $whitelistedEmails->instance([
                'sender_name' => $greylisted_record->getSenderName(),
                'sender_domain' => $greylisted_record->getSenderDomain(),
                'src' => $greylisted_record->getSource(),
                'first_seen' => $greylisted_record->getFirstSeen(),
                'last_seen' => $greylisted_record->getFirstSeen(),
            ]);

            $database->transaction(function () use ($greylisted_record, $email, $whitelistedEmails) {
                // Delete from Greylist
                $this->greylisted->destroy($greylisted_record);

                // Insert into whitelist
                $whitelistedEmails->store($email);
            });
        }

        return $this->respondSuccess();
    }
}
