<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Right;

class TicketsRightsSeeder extends Seeder {
    public function run(){
        Model::unguard();

        Right::create(array('name' => 'Create Kanban Ticket'));
        Right::create(array('name' => 'Modify Kanban Ticket'));
        Right::create(array('name' => 'Delete Kanban Ticket'));
        Right::create(array('name' => 'Move own tickets'));
        Right::create(array('name' => 'Take tickets from Backglog'));
        Right::create(array('name' => 'Drop tickets in Backglog'));
        Right::create(array('name' => 'Move all tickets'));

        Model::reguard();
    }
}