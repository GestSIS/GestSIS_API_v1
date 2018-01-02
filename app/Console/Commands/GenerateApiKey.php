<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateApiKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apikey:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Génération d\'une clé API aléatoire';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $secret = str_random(40);

        $this->info('Informations de la cle API :');
        $this->line('Client ID : '.sha1(str_random(255)));
        $this->line('Client secret : '.$secret);
        $this->line('Encrypted client secret : '.encrypt($secret));
    }
}
