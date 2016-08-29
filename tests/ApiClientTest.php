<?php

namespace IvaoFrance\ApiClient;

class ApiClientTest extends \PHPUnit_Framework_TestCase
{

    private $url = 'http://atcsdev.ivao.fr/api';
    private $apiException = '\IvaoFrance\ApiClient\ApiException';

    public function testInvalidUrl()
    {
        $this->setExpectedException($this->apiException);
        $client = new ApiClient('test', 'secret', 'http://invalid.tld');
        $client->request('test');
    }

    public function testInvalidAccessId()
    {
        $this->setExpectedException($this->apiException);
        $client = new ApiClient('wrong', 'secret', $this->url);
        $client->request('test');
    }

    public function testInvalidSecret()
    {
        $this->setExpectedException($this->apiException);
        $client = new ApiClient('testread', 'wrong', $this->url);
        $client->request('test');
    }

    public function testInvalidEntryPoint()
    {
        $this->setExpectedException($this->apiException);
        $client = new ApiClient('testread', 'secret', $this->url);
        $client->request('testwrong');
    }

    public function testForbiddenAccess()
    {
        $this->setExpectedException($this->apiException);
        $client = new ApiClient('testforbidden', 'secret', $this->url);
        $client->request('test');
    }

    public function testForbiddenGet()
    {
        $this->setExpectedException($this->apiException);
        $client = new ApiClient('testwrite', 'secret', $this->url);
        $client->request('test');
    }

    public function testForbiddenPost()
    {
        $this->setExpectedException($this->apiException);
        $client = new ApiClient('testread', 'secret', $this->url);
        $client->request('test', 'post');
    }

    public function testForbiddenPut()
    {
        $this->setExpectedException($this->apiException);
        $client = new ApiClient('testread', 'secret', $this->url);
        $client->request('test', 'put');
    }

    public function testForbiddenPatch()
    {
        $this->setExpectedException($this->apiException);
        $client = new ApiClient('testread', 'secret', $this->url);
        $client->request('test', 'patch');
    }

    public function testForbiddenDelete()
    {
        $this->setExpectedException($this->apiException);
        $client = new ApiClient('testread', 'secret', $this->url);
        $client->request('test', 'delete');
    }

    public function testGet()
    {
        $client = new ApiClient('testread', 'secret', $this->url);
        $contents = $client->request('test');
        $this->assertEquals($contents->testStatus, 'success');
    }

    public function testPost()
    {
        $client = new ApiClient('testwrite', 'secret', $this->url);
        $contents = $client->request('test', 'post');
        $this->assertEquals($contents->testStatus, 'success');
    }

    public function testPut()
    {
        $client = new ApiClient('testwrite', 'secret', $this->url);
        $contents = $client->request('test', 'put');
        $this->assertEquals($contents->testStatus, 'success');
    }

    public function testPatch()
    {
        $client = new ApiClient('testwrite', 'secret', $this->url);
        $contents = $client->request('test', 'patch');
        $this->assertEquals($contents->testStatus, 'success');
    }

    public function testDelete()
    {
        $client = new ApiClient('testwrite', 'secret', $this->url);
        $contents = $client->request('test', 'delete');
        $this->assertEquals($contents->testStatus, 'success');
    }

    public function testGetBoth()
    {
        $client = new ApiClient('testboth', 'secret', $this->url);
        $contents = $client->request('test');
        $this->assertEquals($contents->testStatus, 'success');
    }

    public function testPostBoth()
    {
        $client = new ApiClient('testboth', 'secret', $this->url);
        $contents = $client->request('test', 'post');
        $this->assertEquals($contents->testStatus, 'success');
    }

    public function testPutBoth()
    {
        $client = new ApiClient('testboth', 'secret', $this->url);
        $contents = $client->request('test', 'put');
        $this->assertEquals($contents->testStatus, 'success');
    }

    public function testPatchBoth()
    {
        $client = new ApiClient('testboth', 'secret', $this->url);
        $contents = $client->request('test', 'patch');
        $this->assertEquals($contents->testStatus, 'success');
    }

    public function testDeleteBoth()
    {
        $client = new ApiClient('testboth', 'secret', $this->url);
        $contents = $client->request('test', 'delete');
        $this->assertEquals($contents->testStatus, 'success');
    }
}
