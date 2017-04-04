<?php

namespace SQLgreyGUI\Console\Commands;

use Illuminate\Console\Command;
use SQLgreyGUI\Repositories\AwlEmailRepositoryInterface;

class DeleteUndefRecords extends Command
{
    protected $emailWhitelist;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sqlgrey:undef';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all -undef- records';

    /**
     * Create a new command instance.
     */
    public function __construct(AwlEmailRepositoryInterface $emailWhitelist)
    {
        parent::__construct();

        $this->emailWhitelist = $emailWhitelist;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $records = $this->emailWhitelist->findBy([
            'sender_name' => '-undef-',
            'sender_domain' => '-undef-',
        ]);

        foreach ($records as $record) {
            $this->emailWhitelist->destroy($record);
        }
    }
}
