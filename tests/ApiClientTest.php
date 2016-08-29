<?php

namespace IvaoFrance\ApiClient;

use PHPUnit\Framework\TestCase;


class ApiClientTest extends TestCase
{

    private $url = 'http://atcsdev.ivao.fr/api';

    public function testInvalidUrl()
    {
        $this->expectException(ApiException::class);
        $client = new ApiClient('test', 'secret', 'http://invalid.tld');
        $client->request('test');
    }

    public function testInvalidAccessId()
    {
        $this->expectException(ApiException::class);
        $client = new ApiClient('wrong', 'secret', $this->url);
        $client->request('test');
    }

    public function testInvalidSecret()
    {
        $this->expectException(ApiException::class);
        $client = new ApiClient('testread', 'wrong', $this->url);
        $client->request('test');
    }

    public function testInvalidEntryPoint()
    {
        $this->expectException(ApiException::class);
        $client = new ApiClient('testread', 'secret', $this->url);
        $client->request('testwrong');
    }

    public function testForbiddenAccess()
    {
        $this->expectException(ApiException::class);
        $client = new ApiClient('testforbidden', 'secret', $this->url);
        $client->request('test');
    }

    public function testForbiddenGet()
    {
        $this->expectException(ApiException::class);
        $client = new ApiClient('testwrite', 'secret', $this->url);
        $client->request('test');
    }

    public function testForbiddenPost()
    {
        $this->expectException(ApiException::class);
        $client = new ApiClient('testread', 'secret', $this->url);
        $client->request('test', 'post');
    }

    public function testForbiddenPut()
    {
        $this->expectException(ApiException::class);
        $client = new ApiClient('testread', 'secret', $this->url);
        $client->request('test', 'put');
    }

    public function testForbiddenPatch()
    {
        $this->expectException(ApiException::class);
        $client = new ApiClient('testread', 'secret', $this->url);
        $client->request('test', 'patch');
    }

    public function testForbiddenDelete()
    {
        $this->expectException(ApiException::class);
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
