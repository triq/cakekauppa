<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * Admin Entity
 *
 * @property int $id
 * @property string $name
 * @property string $password
 */
class Admin extends Entity
{

    /*
    protected $_accessible = [
        'name' => true,
        'password' => true
    ];
    */
    protected $_accessible = [*];
    /*
    protected $_hidden = [
        'password'
    ];
    */

    protected function _setPassword($value) {
        if (strlen($value) <= 0) {
            die('Password length failed!');
        }
        $hasher = new DefaultPasswordHasher();
        return $hasher->hash($value);
    }
}
