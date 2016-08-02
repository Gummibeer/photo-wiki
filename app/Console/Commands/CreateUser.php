<?php
namespace App\Console\Commands;

use App\Console\Command;
use App\Models\User;

class CreateUser extends Command
{
    protected $signature = 'user:create';
    protected $description = 'Creates a new user.';

    public function handle()
    {
        $data = [];
        $data['identity'] = $this->ask('Username');
        $data['email'] = $this->ask('E-Mail');
        $data['first_name'] = $this->ask('Firstname');
        $data['last_name'] = $this->ask('Lastname');
        $data['language'] = config('app.locale');
        $data['is_root'] = $this->confirm('Admin? [y|N]');
        $data['password'] = bcrypt($this->secret('Password'));

        $user = User::create($data);
        if(!is_null($user)) {
            $this->info('user created: #'.$user->getKey());
        } else {
            $this->error('user not created');
        }
    }
}
