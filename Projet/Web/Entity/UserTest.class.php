<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 13/10/2015
 * Time: 20:34
 */

namespace Entity;

require("./User.class.php");

class UserTest extends \PHPUnit_Framework_TestCase {

    public function testConstructor()
    {

        $user = new User(array(
            "UserName" => "Flavian",
        ));

        $this->assertEquals("Flavian", $user->getUserName());
    }
    public function testHashMdp()
    {
        $user = new User(array(
            "Mdp" => "blop",
        ));
        $mdpHashCmd = hash("sha256", $user->getMdp());

        $user->setHashMdp();
        $this->assertEquals($mdpHashCmd, $user->getMdp());
    }
}
