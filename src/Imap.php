<?php

namespace unyii2\imap;

use yii\base\Component;
use yii\base\Exception;
use yii\base\InvalidConfigException;


/* 
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
 *              'decodeMimeStr' => false // Return as is, default -> true
 *         ],
 *     ],
 *     ...
 * ],
 * ~~~
**/

class Imap extends Component
{
    
    /** @var array  */
    private $_connectionParams = [];

    /** @var ImapConnection  */
    private $_connection;

    /**
     * @param array $connectionParams
     * @throws InvalidConfigException on invalid argument.
     */
    public function setConnection($connectionParams)
    {
        if (!is_array($connectionParams)) {
            throw new InvalidConfigException('You should set connection params in your config. Please read yii2-imap doc for more info');
        }
        $this->_connectionParams = $connectionParams;
    }

    /**
     * @return ImapConnection
     * @throws Exception
     */
    public function getConnection()
    {
        if(!$this->_connection) {
            $this->_connection = $this->createConnection();
        }
        return $this->_connection;
    }  
    
    /**
     * 
     * @return ImapConnection
     * @throws Exception
     */
    public function createConnection()
    {
        
        $imapConnection = new ImapConnection();
        
        $imapConnection->imapPath = $this->_connectionParams['imapPath'];
        $imapConnection->imapLogin = $this->_connectionParams['imapLogin'];
        $imapConnection->imapPassword = $this->_connectionParams['imapPassword'];
        $imapConnection->serverEncoding = $this->_connectionParams['serverEncoding'];
        $imapConnection->attachmentsDir = $this->_connectionParams['attachmentsDir'];
        //Optional decoding of the MIME-string
        if (isset($this->_connectionParams['decodeMimeStr'])) {
	        $imapConnection->decodeMimeStr = $this->_connectionParams['decodeMimeStr'];
        }

        if($imapConnection->attachmentsDir) {
            if(!is_dir($imapConnection->attachmentsDir)) {
                    throw new Exception('Directory "' . $imapConnection->attachmentsDir . '" not found');
            }
            $imapConnection->attachmentsDir = rtrim(realpath($imapConnection->attachmentsDir), '\\/');
        }
        return $imapConnection;
    }     
}
