<?php

namespace SQLgreyGUI\Console\Commands;

use Illuminate\Console\Command;
use SQLgreyGUI\Repositories\AwlEmailRepositoryInterface;
use SQLgreyGUI\Repositories\GreylistRepositoryInterface;

class DeleteUndefRecords extends Command
{
    /**
     * @var AwlEmailRepositoryInterface
     */
    protected $whitelistedEmails;

    /**
     * @var GreylistRepositoryInterface
     */
    protected $greylisted;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sqlgreygui:undef';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all -undef- records';

    /**
     * Create a new command instance.
     *
     * @param AwlEmailRepositoryInterface $whitelistedEmails
     * @param GreylistRepositoryInterface $greylisted
     */
    public function __construct(AwlEmailRepositoryInterface $whitelistedEmails, GreylistRepositoryInterface $greylisted)
    {
        parent::__construct();

        $this->whitelistedEmails = $whitelistedEmails;
        $this->greylisted = $greylisted;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach ($this->whitelistedEmails->findUndef() as $record) {
            $this->whitelistedEmails->destroy($record);
        }

        foreach ($this->greylisted->findUndef() as $record) {
            $this->greylisted->destroy($record);
        }
    }
}
