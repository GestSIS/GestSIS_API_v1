<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AddDatabaseSQL extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:add
                            {sis : ID du SIS}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Génération du SQL pour ajouter les infos de la base de données dans la DB DBA';

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
        $host = $this->ask('Hote', 'localhost');
        $port = $this->ask('Port', '3306');
        $database = $this->ask('Base de donnees');
        $user = $this->ask('Utilisateur');

        if($this->confirm('Mot de passe requis ?', true))
            $password = $this->secret('Mot de passe');
        else
            $password = '';

        $this->line('SQL : INSERT INTO Base_Donnees (BDO_Host, BDO_Port, BDO_User, BDO_PWD, BDO_Nom, BDO_Charset, BDO_Collation) '."\n".
                    '      VALUES ("'.$host.'", '.$port.', "'.encrypt($user).'", "'.encrypt($password).'", "'.$database.'", "utf8mb4", "utf8mb4_unicode_ci"); '."\n".
                    '      UPDATE SIS SET BDO_ID = LAST_INSERT_ID() WHERE SIS_ID = '.$sisID.' AND BDO_ID IS NULL;');
    }
}
