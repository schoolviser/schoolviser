<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Mail\TestMail as TestMailing;
use Illuminate\Support\Facades\Mail;

class TestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:mail {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test email to the specified address';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        Mail::to($email)->send(new TestMailing('Hello, this is a test email!'));

        $this->info('Test email sent to ' . $email);
    }
}
