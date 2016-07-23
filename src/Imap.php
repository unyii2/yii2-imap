<?php

namespace unyii2\imap;

use Yii;
use yii\base\Component;
use unyii2\imap\ImapConnection;


/* 
 * 
 * Copyright (c) 2015 by Roopan Valiya Veetil <yiioverflow@gmail.com>.
 * All rights reserved.
 * Date : 29-07-2015
 * Time : 5:20 PM
 * Class can be used for connecting and extracting Email messages.
 * 
 */

/**
 * Imap Component
 *
 * To use Imap, you should configure it in the application configuration like the following,
 *
 * ~~~
 * 'components' => [
 *     ...
 *     'imap' => [
 *         'class' => 'vendor\roopz\yii2-imap\Imap',
 *         'connection' => [
 *             'imapPath' => '{imap.gmail.com:993/imap/ssl}INBOX',
 *             'imapLogin' => 'username',
 *             'imapPassword' => 'password',
 *             'serverEncoding'=>'encoding' // utf-8 default.
 *         ],
 *     ],
 *     ...
 * ],
 * ~~~
**/

class Imap extends component
{
    
    private $_connection = [];    

    /**
     * @param array
     * @throws InvalidConfigException on invalid argument.
     */
    public function setConnection($connection)
    {
        if (!is_array($connection)) {
            throw new InvalidConfigException('You should set connection params in your config. Please read yii2-imap doc for more info');
        }
        $this->_connection = $connection;
    }

    /**
     * @return array
     */
    public function getConnection()
    {
        $this->_connection = $this->createConnection($this->_connection );
        return $this->_connection;
    }  
    
    /**
     * 
     * @return \mgermani\imap\ImapConnection
     * @throws Exception
     */
    public function createConnection()
    {
        
        $imapConnection = new ImapConnection();
        
        $imapConnection->imapPath = $this->_connection['imapPath'];
        $imapConnection->imapLogin = $this->_connection['imapLogin'];
        $imapConnection->imapPassword = $this->_connection['imapPassword'];
        $imapConnection->serverEncoding = $this->_connection['serverEncoding'];
        $imapConnection->attachmentsDir = $this->_connection['attachmentsDir'];
        if($imapConnection->attachmentsDir) {
                if(!is_dir($imapConnection->attachmentsDir)) {
                        throw new Exception('Directory "' . $imapConnection->attachmentsDir . '" not found');
                }
                $imapConnection->attachmentsDir = rtrim(realpath($imapConnection->attachmentsDir), '\\/');
        }
        return $imapConnection;
    }     
}
