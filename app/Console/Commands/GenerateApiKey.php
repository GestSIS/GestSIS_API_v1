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
    protected $signature = 'apikey:generate
                            {sis : ID du SIS}';

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
        $sisID =  $this->argument('sis');
        $secret = str_random(40);
        $clientID = sha1(str_random(255));

        $this->info('Informations de la cle API :');
        $this->line('Client ID : '.$clientID);
        $this->line('Client secret : '.$secret);
        $this->line('SQL : INSERT INTO API_Cle (SIS_ID, APC_Client_ID, APC_Client_Secret, APC_Date_Creation)
                           VALUES ('.$sisID.', "'.$clientID.'", "'.encrypt($secret).'", NOW());');
    }
}
