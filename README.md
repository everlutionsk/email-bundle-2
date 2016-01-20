# Email Bundle

This Symfony bundle provides mechanism for sending and receiving email messages through various mail systems.


# Installation

```sh
composer require everlutionsk/email-bundle-2
```


### Enable the bundle

```php
// app/AppKernel.php
public function registerBundles()
{
    return array(
        // ...
        new Everlution\EmailBundle\EverlutionEmailBundle()
    );
}
```


### Configure the bundle

Following configuration snippet describes how to configure the bundle. Configuration requires a names of services, which implements corresponding interfaces. Only exception is *doman_name*, where you should set something like *appdomain.com*

```yml
# app/config/config.yml

# Doctrine Configuration
doctrine:
    orm:
        entity_managers:
            default:
                mappings:
                    EverlutionEmailBundle: ~

# EmailBundle Configuration
everlution_email:
    domain_name: APP_DOMAIN
    enforced_delivery_address: EMAIL_ADDRESS|NULL
    mail_system: Implementation of Outbound\MailSystem\MailSystem
    async_stream: Implementation of Support\Stream\Stream
    attachment_swappers:
        inbound: Implementation of Inbound\Attachment\AttachmentSwapper
        outbound: Implementation of Outbound\Attachment\AttachmentSwapper
    request_processors:
        inbound: Implementation of Inbound\RequestProcessor
        outbound_message_event: Implementation of Outbound\MessageEvent\RequestProcessor
```

**mail_system** - Name of service, which will be used for sending email messages. This service usually comunicate with SMTP server or with some transactional email platform like [Mandrill](https://www.mandrill.com/).

**enforced_delivery_address** - [Optional] Email address, which will be used to override recipient address in every outbound message.

**async_stream** - Bundle allows to send email messages asynchronously. Email messages is stored in memory unil some value is added into this Stream. Good example is a Stream of Symfony's [kernel.terminate](http://symfony.com/doc/current/components/http_kernel/introduction.html#the-kernel-terminate-event) events.

**attachment_swappers** - After sending or receiving a message, bundle try to save the message's attachments by using this *attachment swappers*. This swappers can save attachments in various ways.

**request_processors** - Bundle provide common mechanism to handle *inbound messages* and *outbound message events*. This events may occur for example when external *mail system* try to send scheduled messages. However, different *mail systems* sending data in different format. Request processors transform this data into format, which is known for this bundle.

### Routing

Bundle provides controllers for handling *inbound messages* and *outbound message events*.

```yml
# Handle outbound message events.
everlution.email.outbound_message_event:
    pattern: CUSTOM_PATTERN
    defaults: { _controller: everlution.email.outbound.message_event.controller:handleMessageEvent }
    methods: POST

# Handle inbound messages.
everlution.email.inbound:
    pattern: CUSTOM_PATTERN
    defaults: { _controller: everlution.email.inbound.controller:handleInbound }
    methods: POST
```

# Basic Usage

### Create new outbound message

```php
$message = new OutboundMessage();
$message->setSubject('Subject');
$message->setText('Message text.');             // Text for basic insight in email client.
$message->setHtml('<img src="cid:logo">');      // Email body.
$message->setFromEmail('support@example.com');
$message->setFromName('Sender name');
$message->setReplyTo('reply@example.com');
$message->setRecipients([
    new ToRecipient('recipient@mail.com', 'Recipient name'),
    new CcRecipient('cc-recipient@mail.com', 'Cc recipient name'),
    new BccRecipient('bcc-recipient@mail.com', 'Bcc recipient name'),
]);

$image = new BasicAttachment('image/png', 'logo', file_get_contents('logo.png'));
$attachment = new BasicAttachment('application/pdf', 'document.pdf', file_get_contents('document.pdf'));

$message->setImages([$image]);            // Images included into email body. 
$message->setAttachments([$attachment]);
```

### Get mailer

**Synchronous mailer** - Mail system is called immediately.
```php
$mailer = $this->get('everlution.email.outbound.synchronous_mailer');
```

**Asynchronous mailer** - Mail system is called after adding value into corresponding Stream.
```php
$mailer = $this->get('everlution.email.outbound.asynchronous_mailer');
```

### Send / Schedule message
```php
$mailer->sendMessage($message);
```

```php
$mailer->scheduleMessage($message, new \DateTime('+ 30 minutes'));
```

# Advanced usage

### Message transformers
Every message could be modified before it is forwarded into *mail system*.

**Transforming outbound messages**<br>
Register service, which implements [OutboundMessageTransformer](Outbound/Message/OutboundMessageTransformer.php) and add following tag:
```
everlution.email.outbound.message_transformer
```

**Transforming inbound messages**<br>
Register service, which implements [InboundMessageTransformer](Inbound/Message/InboundMessageTransformer.php) and add following tag:
```
everlution.email.inbound.message_transformer
```
### Message templates
Some *mail systems* supports message templates, which are defined in this systems. The following code shows how to use this templates.
```php
$parameter = new Parameter('PARAMETER_NAME', 'PARAMETER_VALUE');
$template = new Template('TEMPLATE_NAME', [$parameter]);

$message->setTemplate($template);
```

### Handle Inbound messages
Inbound messages can be handled by listeners, which listening to ```everlution.email.inbound``` events.
Events are instances of [InboundEvent](Inbound/InboundEvent) and contains information about [Inbound message](Inbound/Message/InboundMessage) and about
its [storable version](Entity/StorableInboundMessage), which has been saved into database.

<br>

***Caution**: If application doesn't need to create associations with inbound message in database, then storable version of message should be ignored.*


### Mock a mail system
Use ```everlution.email.mock.mail_system``` service as mail system (see *Configure the bundle* section).

# Supported mail systems
[**Mandrill**](https://github.com/everlutionsk/MandrillBundle)