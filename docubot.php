<?php
namespace 1LAW;

class DocubotMessageResponse {

    /**
     * DocubotMessageResponseData
     */
    public $data;
    /**
     * DocubotMessageResponseMeta
     */
    public $meta;

}

class DocubotMessageResponseData {

    /**
     * array<string>
     */
    public $messages;
    /**
     * bool
     */
    public $complete;

}

class DocubotMessageResponseMeta {

    /**
     * string
     */
    public $threadId;
    /**
     * string
     */
    public $userId;

}

class DocubotURLResponse {

    /**
     * DocubotURLResponseData
     */
    public $data;
    /**
     * Associative Array
     */
    public $meta;

}

class DocubotURLResponseData {

    /**
     * string
     */
    public $url;

}

class DocubotError {

    /**
     * array<string>
     */
    public $errors;

}

/**
 * The Docubot class has convenience methods that assist in communicating with the Docubot API.
 */
class Docubot {

    private $APIKey;
    private $APISecret;
    private $APIURLBase;

    /**
     * Creates a new Docubot Instance.
     *
     * @param string $key The API Key for this Docubot Instance.
     * @param string $secret The API Secret for this Docubot Instance.
     * @param string $urlBase The optional base URL for Docubot (if not using live server)
     */
    public function __construct( $key, $secret, $urlBase = "https://docubotapi.1law.com" ) {

        $this->APIKey = $key;
        $this->APISecret = $secret;
        $this->APIURLBase = $urlBase;

    }

    /**
     * Send a message to Docubot.
     *
     * @param string $message The message to send to docubot.
     * @param string $thread The ID of the thread to send the message for.
     *  (blank if starting a new thread)
     * @param string $sender The ID of the user who is sending the message.
     *  (blank if starting a new thread, or a new user)
     *
     * @return DocubotMessageResponse|DocubotError
     */
    public function send_message( $message, $thread, $sender ) {



    }

    /**
     * Retrieve a document from docubot.
     *
     * @param string $thread The ID of the thread to retrieve the document for.
     * @param string $user The ID of the user for whom to get the document.
     * @param FilePointer $fp The file pointer resource to write the resulting document data to.
     *
     * @return null|DocubotError
     */
    public function get_document( $thread, $user, $fp ) {



    }

    /**
     * Retrieve a document URL from Docubot.
     *
     * @param string $thread The ID of the thread to retrieve the document for.
     * @param string $user The ID of the user for whom to get the document.
     * @param int $exp The number of seconds (from now) the URL should last before it expires. (Max 86400)
     *
     * @return DocubotURLResponse|DocubotError
     */
    public function get_document_url( $thread, $user, $exp ) {



    }

}
