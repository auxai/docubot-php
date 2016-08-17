<?php
namespace OneLaw;
use PHPUnit\Framework\TestCase;


class DocubotTest extends TestCase {

    //Environment vaiables used for testing
    private $key;
    private $secret;
    private $thread;
    private $user;

    function __construct() {

        $this->key = getenv( 'KEY' );
        $this->secret = getenv( 'SECRET' );
        $this->thread = getenv( 'THREAD' );
        $this->user = getenv( 'USER' );

    }

    /***SEND_MESSAGE TESTING***/
    public function testInvalidUrlSendMessage(){

        $docubot = new Docubot( $this->key, $this->secret, 'RAWR.RAWR' );
        $test = $docubot->send_message( 'Test' );
        $this->assertInstanceOf( DocubotError::class, $test );
        $this->assertArrayHasKey( 'errors', $test->errors );
        $this->assertInternalType( 'string', $test->errors['errors'] );

    }

    public function testInvalidApiKeySendMessage() {

        $docubot = new Docubot( 'RAWR key', $this->secret );
        $test = $docubot->send_message( 'Test' );
        $this->assertInstanceOf( DocubotError::class, $test );
        $this->assertArrayHasKey( 'errors', $test->errors );

    }

    public function testInvalidApiSecretSendMessage() {

        $docubot = new Docubot( $this->key, 'RAWR secret' );
        $test = $docubot->send_message( 'Test' );
        $this->assertInstanceOf( DocubotError::class, $test );
        $this->assertArrayHasKey( 'errors', $test->errors );

    }

    public function testSuccessfulFirstMessageSendMessage() {

        //Test to ensure the message goes through, and returns a non-empty response
        $docubot = new Docubot( $this->key, $this->secret);
        $test = $docubot->send_message( 'Test' );
        $this->assertInstanceOf( DocubotMessageResponse::class, $test );
        $this->assertInstanceOf( DocubotMessageResponseData::class, $test->data );
        $this->assertInstanceOf( DocubotMessageResponseMeta::class, $test->meta );
        $this->assertContainsOnly( 'string', $test->data->messages );
        $this->assertInternalType( 'bool', $test->data->complete );
        $this->assertInternalType( 'string', $test->meta->threadId );
        $this->assertInternalType( 'string', $test->meta->userId );


    }

    public function testSuccessfulNotFirstMessageSendMessage() {

        //Test to ensure we get back the same threadId and userId we put into it
        $docubot = new Docubot( $this->key, $this->secret);
        $test = $docubot->send_message( 'Test', $this->thread, $this->user );
        $this->assertEquals( $this->thread, $test->meta->threadId );
        $this->assertEquals( $this->user, $test->meta->userId );


    }
    /***END SEND_MESSAGE TESTING***/

    /***GET_DOCUMENT_URL TESTING***/
    public function testInvalidUrlPathGetDocUrl(){

        $docubot = new Docubot( $this->key, $this->secret );
        $test = $docubot->get_document_url( 'RAWR thread', '$this->user' );
        $this->assertInstanceOf( DocubotError::class, $test );
        $this->assertArrayHasKey( 'errors', $test->errors );

    }

    public function testInvalidApiKeyGetDocUrl() {

        $docubot = new Docubot( 'RAWR key', $this->secret );
        $test = $docubot->get_document_url( $this->thread, $this->user );
        $this->assertInstanceOf( DocubotError::class, $test );
        $this->assertArrayHasKey( 'errors', $test->errors );

    }

    public function testSuccessfulGetDocUrl() {

        $docubot = new Docubot( $this->key, $this->secret );
        $test = $docubot->get_document_url( $this->thread, $this->user );
        $this->assertInstanceOf( DocubotURLResponse::class, $test );
        $this->assertInstanceOf( DocubotURLResponseData::class, $test->data );
        $this->assertInternalType( 'array', $test->meta );
        $this->assertInternalType( 'string', $test->data->url );

    }
    /***END GET_DOCUMENT_URL TESTING***/

    /***GET_DOCUMENT TESTING***/
    public function testInvalidUrlPathGetDoc(){

        $fp = tmpfile();
        $docubot = new Docubot( $this->key, $this->secret );
        $test = $docubot->get_document( 'RAWR thread', '$this->user', $fp );
        $this->assertInstanceOf( DocubotError::class, $test );
        $this->assertArrayHasKey( 'errors', $test->errors );
        $tempfile = stream_get_contents( $fp );
        $this->assertEquals( '', $tempfile );
        fclose( $fp );

    }

    public function testInvalidApiKeyGetDoc() {

        $fp = tmpfile();
        $docubot = new Docubot( 'RAWR key', $this->secret );
        $test = $docubot->get_document( $this->thread, $this->user, $fp );
        $this->assertInstanceOf( DocubotError::class, $test );
        $this->assertArrayHasKey( 'errors', $test->errors );
        $tempfile = stream_get_contents( $fp );
        $this->assertEquals( '', $tempfile );
        fclose( $fp );

    }

    public function testSuccessfulGetDoc() {

        $fp = tmpfile();
        $docubot = new Docubot( $this->key, $this->secret );
        $test = $docubot->get_document( $this->thread, $this->user, $fp );
        $this->assertNull( $test );
        $tempfile = stream_get_contents( $fp );
        //assert that the file is not empty
        $this->assertNotNull( $tempfile );
        fclose( $fp );

    }
    /***END GET_DOCUMENT TESTING***/

}
