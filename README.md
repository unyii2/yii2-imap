yii2 Imap
==========
This library is a fork of https://github.com/yiioverflow/yii2-imap

Installation by composer
------------
```composer
{
    "require": {
       "unyii2/yii2-imap": "dev-master"
    }
}

Or

$ composer require unyii2/yii2-imap "dev-master"
```

# Use as compnent

Connection details define in component

```php
'components' => [
      ...
      'imap' => [
         'class' => 'unyii2\imap\Imap',
         'connection' => [
              'imapPath' => '{imap.gmail.com:993/imap/ssl}INBOX',
              'imapLogin' => 'username',
              'imapPassword' => 'password',
              'serverEncoding'=>'encoding', // utf-8 default.
              'attachmentsDir'=>'/'
        ],
    ],
    ...
 ],


//4th Param _DIR_ is the location to save attached files 
//Eg: /path/to/application/mail/uploads.
$mailbox = new unyii2\Mailbox(yii::$app->imap->connection);
```

# Usage as library

Connection details set on fly

```php

$imapConnection = new unyii2\imap\ImapConnection

$imapConnection->imapPath = '{imap.gmail.com:993/imap/ssl}INBOX';
$imapConnection->imapLogin = 'username';
$imapConnection->imapPassword = 'password';
$imapConnection->serverEncoding = 'encoding'; // utf-8 default.
$imapConnection->attachmentsDir = '/';


//4th Param _DIR_ is the location to save attached files 
//Eg: /path/to/application/mail/uploads.
$mailbox = new unyii2\Mailbox($imapConnection);
```

#To get all mails and its index
```php
$mailbox->searchMailBox(ALL)// Prints all Mail ids.
print_r($mailIds);
```

#Do not read attachments
$mailbox->readMailParts = false;

#To read Inbox contents
```php
foreach($mailIds as $mailId)
{
    // Returns Mail contents
    $mail = $mailbox->getMail($mailId); 

    if(alreadyProcesedMessage($mail->messageId)){
        continue;
    }

    // Use, if $mailbox->readMailParts = false; 
    // Read mail parts (plain body, html body and attachments
    $mail = $mailbox->getMailParts($mail);

    // Returns mail attachements if any or else empty array
    $attachments = $mail->getAttachments(); 
    foreach($attachments as $attachment){
        echo ' Attachment:' . $attachment->name . PHP_EOL;
        
        // Delete attachment file
        unlink($attachment->filePath);

    }
}
```

#To Mark and delete mail from IMAP server.
```php
//Mark a mail to delete</span></span> 
$mailbox->deleteMail($mailId); // Deletes all marked mails
$mailbox->expungeDeletedMails();
```

# Contribute
Feel free to contribute. If you have ideas for examples, add them to the repo and send in a pull request.

# Apreciate
Dont forgett o Leave me a "star" if you like it. Enjoy coding!
