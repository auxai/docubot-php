Docubot
======================

What is Docubot?
----
Docubot™ is artificial intelligence, designed specifically for legal websites. This handy, document-generating plug-in, is looking to tap into the estimated $45 billion dollars of unspent revenue by people not currently participating in the legal market. It is an augmented legal service that gives consumers access to legal services without having to sit down with a lawyer, they simply log in, select the document to be generated, and Docubot™ guides them through the process. If the consumer needs help, at any time during the document-generating process, they can type ‘help’ and Docubot’s On-Demand video or chat will connect them to a legal professional in your office for assistance.

Why Docubot™ For Legal Professionals?
----
* Allows legal professionals to efficiently and effectively help more individuals
* Creates opportunity to build a personal connection with consumers for future 		legal help
* Fully customizable to offer the services most requested by legal professional
* Expands legal professional’s reach by being available from anywhere
* Reduces appointments for smaller services, allowing more time for larger cases
* Taps into an estimated $45 billion of unspent revenue by people not currently participating in the legal market.

Why Docubot™ For Legal Consumers?
----
* Receive legal services at a reduced rate or even free.
* Perfect for those lacking a personal connection to a lawyer
* Simple, step-by-step guidance reduces legal system anxieties
* Easy access for consumers hampered with geographical constraints
* Good fit for consumer that fall into the justice gap—have too much for pro bono 		work, but unable to afford traditional private legal services

How To Use
----
To use this PHP plugin for Docubot™ simply add the src/docubot.php plugin to your project (Composer Support Coming Soon).

Once the file has been added to your project, and you've included the file in your source code, you can utilize the plugin in the following manner:

```php
<?php
$key = ''/* Your API Key */;
$secret = ''/* Your API Secret */;
$server = new \OneLaw\Docubot($key, $secret);
$thread; // The thread that this message is being sent from
$sender; // The id of the sender that this message is being sent from
$message = ''/* The message text to send docubot */;
if ( isset($thread) && isset($sender) ) {

    $results = $server->send_message( $message, $thread, $sender );

} else {

    $results = $server->send_message( $message );

}
if ( isset($results->errors) ) {

    // Handle errors in sending message

}
if ($results->data->complete) {

    $url_response = $server->get_document_url( $thread, $sender );

    if ( isset($url_response->errors) ) {

        // Handle Errors in Getting Document URL

    } else {

        // Handle Document URL {$url_response->data->url}

    }

}
// Handle Docubot response {$results->data->messages}
```

Reporting bugs
----
We try to fix as many bugs we can. If you find an issue, [let us know here](https://github.com/auxai/docubot-php/issues/new).

Contributions
-------------
Anyone is welcome to contribute to Docubot. Just issue a pull request.

There are various ways you can contribute:

* [Raise an issue](https://github.com/auxai/docubot-php/issues) on GitHub.
* Send us a Pull Request with your bug fixes and/or new features.
* Provide feedback and [suggestions on enhancements](https://github.com/auxia/docubot-php/issues?direction=desc&labels=Enhancement&page=1&sort=created&state=open).
* Provide us with a new document for Docubot to generate.
