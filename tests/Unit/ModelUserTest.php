<?php

namespace Tests\Unit;

use App\Model\DB\Users as DBUsers;
use Tests\TestCase;

class ModelUserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testIsUserExisted()
    {
        $db = new DBUsers();
        $this->assertEquals(true, $db->IsUserExisted('admin'));
        $this->assertEquals(false, $db->IsUserExisted('', 'Adm'));
        $this->assertEquals(true, $db->IsUserExisted('', 'Administrator'));
    }
}
