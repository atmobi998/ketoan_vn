<?php
namespace App\Command;
use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
class SeedTestDataCommand extends Command
{
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser { $parser->setDescription('Seed test data'); return $parser; }
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $io->out('Seed VAS...');
        $users = $this->fetchTable('Users');
        $users->deleteAll(['1=1']);
        $users->saveMany([
            $users->newEntity(['username'=>'superadmin','email'=>'superadmin@ketoan.vn','password'=>password_hash('superadmin123', PASSWORD_DEFAULT),'full_name'=>'Super Admin','role'=>'superadmin','is_active'=>1]),
            $users->newEntity(['username'=>'admin','email'=>'admin@ketoan.vn','password'=>password_hash('admin123', PASSWORD_DEFAULT),'full_name'=>'Admin','role'=>'admin','is_active'=>1]),
            $users->newEntity(['username'=>'user','email'=>'user@ketoan.vn','password'=>password_hash('user123', PASSWORD_DEFAULT),'full_name'=>'User','role'=>'user','is_active'=>1]),
        ]);
        $io->out('Done');
        return Command::CODE_SUCCESS;
    }
}
