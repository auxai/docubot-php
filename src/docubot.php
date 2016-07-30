<?php
namespace OneLaw;

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
    public function send_message( $message, $thread = "", $sender = "" ) {

        $ch = curl_init( $this->APIURLBase );
        $data = [ 'message' => $message, 'thread' => $thread, 'sender' => $sender ];
        $data = json_encode( $data );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
        curl_setopt( $ch, CURLOPT_USERPWD, $this->APIKey . ':' . $this->APISecret );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type:application/json' ) );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $result = curl_exec( $ch );
        if ( $result === false) {

            $err = new DocubotError();
            $err->errors = [ 'errors' => curl_error( $ch ) ];
            curl_close( $ch );
            return $err;

        }
        $info = curl_getinfo( $ch );
        curl_close( $ch );
        $result = json_decode( $result, true );
        if ( $info['http_code'] < 200 || $info['http_code'] > 299 ) {

            $err = new DocubotError();
            $err->errors = [ 'errors' => $result['errors'] ];
            return $err;

        }
        $rData = $result['data'];
        $docuData = new DocubotMessageResponseData();
        $docuData->messages = $rData['messages'];
        $docuData->complete = $rData['complete'];
        $rMeta = $result['meta'];
        $docuMeta = new DocubotMessageResponseMeta();
        $docuMeta->threadId = $rMeta['threadId'];
        $docuMeta->userId = $rMeta['userId'];
        $docuResponse = new DocubotMessageResponse();
        $docuResponse->data = $docuData;
        $docuResponse->meta = $docuMeta;
        return $docuResponse;
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

        $ch = curl_init( $this->APIURLBase . '/api/v1/docubot/' . $thread . '/doc/download?' . http_build_query( ['user' => $user] ) );
        curl_setopt( $ch, CURLOPT_USERPWD, $this->APIKey . ':' . $this->APISecret );
        curl_setopt( $ch, CURLOPT_FILE, $fp );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type:application/x-www-form-urlencoded' ) );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $result = curl_exec( $ch );
        if ( $result === false ) {

            $err = new DocubotError();
            $err->errors = [ 'errors' => curl_error( $ch ) ];
            curl_close( $ch );
            return $err;

        }
        $info = curl_getinfo( $ch );
        curl_close( $ch );
        $result = json_decode( $result, true );
        if ( $info['http_code'] < 200 || $info['http_code'] > 299 ) {

            $err = new DocubotError();
            $err->errors = [ 'errors' => $result['errors'] ];
            return $err;

        }

        return;

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
    public function get_document_url( $thread, $user, $exp = 3600 ) {

        $ch = curl_init( $this->APIURLBase . '/api/v1/docubot/' . $thread . '/doc/url?' . http_build_query( ['user' => $user] ) );
        curl_setopt( $ch, CURLOPT_USERPWD, $this->APIKey . ':' . $this->APISecret );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type:application/x-www-form-urlencoded' ) );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $result = curl_exec( $ch );
        if ( $result === false ) {

            $err = new DocubotError();
            $err->errors = [ 'errors' => curl_error( $ch ) ];
            curl_close( $ch );
            return $err;

        }
        $info = curl_getinfo( $ch );
        curl_close( $ch );
        $result = json_decode( $result, true );
        if ( $info['http_code'] < 200 || $info['http_code'] > 299 ) {

            $err = new DocubotError();
            $err->errors = [ 'errors' => $result['errors'] ];
            return $err;

        }
        $rData = $result['data'];
        $docuUrlData = new DocubotURLResponseData();
        $docuUrlData->url = $rData['url'];
        $docuUrl = new DocubotURLResponse();
        $docuUrl->data = $docuUrlData;
        $docuUrl->meta = $results['meta'];
        return $docuUrl;


    }

}