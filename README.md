# SendGrid Transport Module for Zend Framework

This module provide SendGrid as a transport for transactional e-mail in Zend Framework 2.


## INSTALLING

`composer require andrebian/sendgrid-transport-module`

After install follow one of these steps:

1) Copy the contents file `vendor/andrebian/sendgrid-transport-module/mail.global.php.dist` and put it in your `config/autoload/mail.global.php`. 

2) If this file does not exists in your application, just copy the entire file and place into your `config/autoload` removing the .dist extension.

Then put your SendGrid API Key. To get your API Key, please visit https://sendgrid.com/docs/Classroom/Send/How_Emails_Are_Sent/api_keys.html

#### Full example

```php
# config/autoload/mail.global.php

return array(
    'mail' => array(
        'sendgrid' => array(
            'api_key' => 'YOUR_API_KEY',
        )
    )
);
```

## USING

### Via Service

By default, when the **SendGridTransportModule** is loaded a service is registered and ready to use.

```php
// In a Controller
$sendGridTransport = $this->getServiceLocator()->get('SendGridTransport');
```

#### Full example with service

```php
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mail;

class SomeController extends AbstractActionController
{
    public function someAction()
    {
        $mail = new Mail\Message();
        $mail->setBody('This is the text of the email.');
        $mail->setFrom(new Mail\Address('test@example.org', 'Sender\'s name'));
        $mail->addTo(new Mail\Address('some@address.com', 'User Name'));
        $mail->setSubject('TestSubject');

        $sendGridTransport = $this->getServiceLocator()->get('SendGridTransport');
        $sendGridTransport->send($mail);

        return new ViewModel();
    }
}
```

### Directly

If you need more control, you can use the library anywhere you want.

```php
use SendGrid;
use SendGridTransportModule\SendGridTransport;

class SomeControllerOrServiceOrHelper 
{
    public function someMethod()
    {
        $mail = new Mail\Message();
        $mail->setBody('This is the text of the email.');
        $mail->setFrom(new Mail\Address('test@example.org', 'Sender\'s name'));
        $mail->addTo(new Mail\Address('some@address.com', 'User Name'));
        $mail->setSubject('TestSubject');

        $sendGrid = new SendGrid('YOUR_API_KEY');
        $sendGridEmail = new SendGrid\Email();
        $sendGridTransport = new SendGridTransport($sendGrid, $sendGridEmail);

        $sendGridTransport->send($mail);
    }
}
```

> Is strongly recommended to use the already registered service.



## CONTRIBUTING

You can contribute with this module suggesting improvements, making tests and reporting bugs. Use [issues](https://github.com/andrebian/sendgrid-transport-module/issues) for that.


## LICENSE

[MIT](https://github.com/andrebian/sendgrid-transport-module/blob/master/LICENSE)


## ERRORS 

Report errors opening [Issues](https://github.com/andrebian/sendgrid-transport-module/issues).
