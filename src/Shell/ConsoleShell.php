<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Shell;

use Cake\Console\ConsoleOptionParser;
use Cake\Console\Shell;
use Cake\Log\Log;
use Psy\Shell as PsyShell;

use App\Model\Entity\Admin;
use Cake\ORM\TableRegistry;


/**
 * Simple console wrapper around Psy\Shell.
 */
class ConsoleShell extends Shell
{

    /**
     * Start the shell and interactive console.
     *
     * @return int|null
     */
    public function main()
    {
        if (!class_exists('Psy\Shell')) {
            $this->err('<error>Unable to load Psy\Shell.</error>');
            $this->err('');
            $this->err('Make sure you have installed psysh as a dependency,');
            $this->err('and that Psy\Shell is registered in your autoloader.');
            $this->err('');
            $this->err('If you are using composer run');
            $this->err('');
            $this->err('<info>$ php composer.phar require --dev psy/psysh</info>');
            $this->err('');

            return self::CODE_ERROR;
        }

        $this->out("You can exit with <info>`CTRL-C`</info> or <info>`exit`</info>");
        $this->out('');

        Log::drop('debug');
        Log::drop('error');
        $this->_io->setLoggers(false);
        restore_error_handler();
        restore_exception_handler();

        $psy = new PsyShell();
        $psy->run();
    }

    /**
     * Display help for this console.
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = new ConsoleOptionParser('console');
        $parser->setDescription(
            'This shell provides a REPL that you can use to interact ' .
            'with your application in an interactive fashion. You can use ' .
            'it to run adhoc queries with your models, or experiment ' .
            'and explore the features of CakePHP and your application.' .
            "\n\n" .
            'You will need to have psysh installed for this Shell to work.'
        );

        return $parser;
    }

    public function findAdmin() {
        $x = $this->loadModel('Admins');
        $q = $x->find('all')
            ->where(['Admins.id =' => 3]);
        $results = $q->all();

// Once we have a result set we can get all the rows
        $data = $results->toArray();
        var_dump('res count: '. $results->count());
        $a1 = $results->first();
        //$aa = $data[0];
        var_dump('admin: 1 ');
        //var_dump($aa);
        //var_dump('id: '. $aa['id']);
        var_dump('id-res: '. $a1['id']);
        $a1->password = 'banaani123';
        var_dump($a1);

        $admin_new = new Admin();
        $admin_2 = new Admin([
            'name' => 'Admin55',
            'password' => 'banaani123'
        ]);
        if (!$admin_2->isNew()) {
            echo 'This admin was saved already!';
        }

        $q = $x->find('all')
            ->where(['Admins.name =' => 'Admin55']);
        $results = $q->all();
        var_dump('res count(2): '. $results->count());
        $a2 = $results->first();
        var_dump('admin: 1 ');
        var_dump('id-res: '. $a2['id']);
        var_dump($a2);
    }

    public function createAdmin($adminname = '', $password = '')
    {
        $x = $this->loadModel('Admins');

        if ($adminname != '' && $password != '') {
            $adminsTable = TableRegistry::get('Admins');
            //$admin = $adminsTable->newEntity();
            //$article->title = 'A New Article';
            //$article->body = 'This is the body of the article';


            $admin = new Admin([
                'name' => $adminname,
                'password' => $password
            ]);
            echo "admin: name, id: ". $admin->get('name') . ", '". $admin->get('id') ."'\n";
            if (!$admin->isNew()) {
                echo 'This admin was saved already!';
            }
            $id = 'NO ID';
            if ($adminsTable->save($admin)) {
                // The $admin entity contains the id now
                $id = $admin->id;
            }

            $q = $x->find('all')
                ->where(['Admins.name =' => $adminname]);
            $results = $q->all();

            $c = $results->count();
            echo('result count(name=): '. $c);
            if($c == 0) {
                print_r("\nErrors found! Not created admin.");
                $e = $admin->getErrors();
                print_r($e);
            }
            $a1 = $results->first();
            echo("\n". 'id: '. $a1['id'] ."\n");
            print_r($a1);
        } else {
            echo "Anna uusi admin nimi ja salasana...\n esim. 'bin\cake console createAdmin admin666 password1'";
        }
    }

    public function deleteAdmin($adminname = '')
    {
        $x = $this->loadModel('Admins');

        if ($adminname != '') {
            $adminsTable = TableRegistry::get('Admins');

            $id = 'NO ID';
            $q = $x->find('all')
                ->where(['Admins.name =' => $adminname]);
            $results = $q->all();

            $c = $results->count();
            echo('result count(name=): '. $c);
            $a1 = $results->first();
            if($a1 != null) {
                echo("\n" . 'id: ' . $a1['id'] . ", name: " . $a1->name . "\n");
                $adminsTable = TableRegistry::get('Admins');
                $result = $adminsTable->delete($a1);
                print_r('result(delete): '. $result);
            } else {
                echo "\nAdminia nimella '". $adminname ."' ei loytynyt!";
            }
        } else {
            echo "Anna uusi admin nimi ja salasana...\n esim. 'bin\cake console createAdmin admin666 password1'";
        }
    }

    /* UPDATE
        Updating Data
        Updating your data is equally easy, and the save() method is also used for that purpose:
    */
    public function updateAdmin($adminname = '', $new_password = '')
    {
        $x = $this->loadModel('Admins');

        if ($adminname != '' && $new_password != '') {
            $adminsTable = TableRegistry::get('Admins');
            $q = $x->find('all')
                ->where(['Admins.name =' => $adminname]);
            $results = $q->all();


            $c = $results->count();
            echo('result count(name=): '. $c);
            if($c == 0) {
                print_r("\nErrors found! Not found admin.");
            } else {

                $a1 = $results->first();
                echo("\n" . 'id: ' . $a1['id'] . ", name, new_password: " . $a1['name'] . "," . $new_password . "\n");
                $a1->password = $new_password;

                if ($adminsTable->save($a1)) {
                    // The $admin entity contains the id now
                    $id = $a1->id;
                    print_r('Paivitys onnistui!');
                }
            }
        } else {
            echo "Anna admin nimi ja uusi salasana...\n esim. 'bin\cake console updateAdmin admin666 password1'";
        }
    }

}
