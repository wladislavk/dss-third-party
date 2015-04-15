<?php

use Ds3\Libraries\Legacy\Loader;

class LoaderTest extends TestCase {
    private $loader;
    private $legacyPath;

    public function setUp()
    {
        $this->legacyPath = __DIR__ . '/legacy-loader';
        $this->loader = new Loader();
        $this->loader->setLegacyPath($this->legacyPath);
    }

    public function tearDown()
    {
        unset($this->loader);
    }

    public function testSetInvalidLegacyPath()
    {
        $this->setExpectedException('Ds3\Libraries\Legacy\LoaderException');
        $this->loader->setLegacyPath('/this/folder/does/not/exist');
    }

    public function testGetLegacyPath()
    {
        $this->assertEquals($this->legacyPath, $this->loader->getLegacyPath());
    }

    public function testRequestParams()
    {
        $this->assertEquals(['get' => [], 'post' => []], $this->loader->getRequestParams());

        $this->loader->setRequestParams('get', ['first' => 1]);
        $this->assertEquals(
            [
                'get' => [
                    'first' => 1
                ],
                'post' => []
            ],
            $this->loader->getRequestParams()
        );

        $this->loader->setRequestParams('get', ['second' => 2]);
        $this->assertEquals(
            [
                'get' => [
                    'first' => 1,
                    'second' => 2,
                ],
                'post' => []
            ],
            $this->loader->getRequestParams()
        );

        $this->loader->setRequestParams('post', ['third' => 3]);
        $this->assertEquals(
            [
                'get' => [
                    'first' => 1,
                    'second' => 2,
                ],
                'post' => [
                    'third' => 3
                ]
            ],
            $this->loader->getRequestParams()
        );

        $this->loader->setRequestParams('post', ['fourth' => 4, 'fifth' => 5]);
        $this->assertEquals(
            [
                'get' => [
                    'first' => 1,
                    'second' => 2,
                ],
                'post' => [
                    'third' => 3,
                    'fourth' => 4,
                    'fifth' => 5
                ]
            ],
            $this->loader->getRequestParams()
        );

        $this->loader->setRequestParams('post', ['replaced' => true], true);
        $this->assertEquals(
            [
                'get' => [
                    'first' => 1,
                    'second' => 2,
                ],
                'post' => [
                    'replaced' => true
                ]
            ],
            $this->loader->getRequestParams()
        );
    }

    public function testGetRealPath()
    {
        $this->assertFalse($this->loader->getRealPath('file-does-not-exist.php'));
        $this->assertEquals("{$this->legacyPath}/plain-output.php", $this->loader->getRealPath('plain-output.php'));
    }

    public function testIsLegacyFile()
    {
        $this->assertFalse($this->loader->isLegacyFile('file-does-not-exist', true));
        $this->assertFalse($this->loader->isLegacyFile("{$this->legacyPath}/file-does-not-exist"));

        $this->assertTrue($this->loader->isLegacyFile('plain-output.php', true));
        $this->assertTrue($this->loader->isLegacyFile("{$this->legacyPath}/plain-output.php"));

        $this->assertFalse($this->loader->isLegacyFile('plain-output.php', false));
    }

    public function testGetRedirection()
    {
        $this->assertEquals('', Loader::getRedirection([], $this->readFile('plain-output.php'), 'fake-legacy-path/index.php'));

        $this->assertEquals(
            '/fake-legacy-path/redirected.php',
            Loader::getRedirection([], $this->readFile('redirect-with-javascript.php'), 'fake-legacy-path/index.php')
        );

        $this->assertEquals(
            '/different-fake-path',
            Loader::getRedirection(
                ['location' => '/different-fake-path'],
                $this->readFile('redirect-with-javascript.php'),
                'fake-legacy-path/index.php'
            )
        );

        $this->assertEquals(
            '/fake-legacy-path/redirected.php',
            Loader::getRedirection(
                ['Location: /different-fake-path'],
                $this->readFile('redirect-with-javascript.php'),
                'fake-legacy-path/index.php'
            )
        );
    }

    public function testInjectBaseTag()
    {
        $this->assertEquals('', Loader::injectBaseTag('', 'legacy/path'));
        $this->assertEquals('<head><base href="/legacy/path">', Loader::injectBaseTag('<head>', 'legacy/path'));

        $this->assertEquals(
            '<head meta-tag="abc"><base href="/legacy/path">',
            Loader::injectBaseTag('<head meta-tag="abc">', 'legacy/path')
        );

        $this->assertEquals(
            '<head meta-tag="abc"><base href="/">',
            Loader::injectBaseTag('<head meta-tag="abc">', '/')
        );

        $this->assertEquals(
            '<head meta-tag="abc"><base href="/">',
            Loader::injectBaseTag('<head meta-tag="abc">', '//')
        );
    }

    public function testLoadWithoutRedirect()
    {
        $response = $this->loader->load('plain-output.php');
        $this->assertInstanceOf('Illuminate\Http\Response', $response);
        $this->assertEquals($this->readFile('plain-output.php'), $response->getContent());

        $response = $this->loader->load('html-output.php');
        $this->assertInstanceOf('Illuminate\Http\Response', $response);
        $this->assertEquals($this->readFile('html-with-root-base-tag.txt'), $response->getContent());

        $this->loader->setLegacyPath(__DIR__);

        $response = $this->loader->load('legacy-loader/plain-output.php');
        print_r($response);
        $this->assertInstanceOf('Illuminate\Http\Response', $response);
        $this->assertEquals($this->readFile('plain-output.php'), $response->getContent());

        $response = $this->loader->load('legacy-loader/html-output.php');
        $this->assertInstanceOf('Illuminate\Http\Response', $response);
        $this->assertEquals($this->readFile('html-with-subdir-base-tag.txt'), $response->getContent());
    }

    public function testLoadWithRedirect()
    {
        $response = $this->loader->load('redirect-with-javascript.php');
        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $response);
        $this->assertEquals('/redirected.php', $response->getTargetUrl());

        $response = $this->loader->load('redirect-with-header.php');
        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $response);
        $this->assertEquals('/redirected.php', $response->getTargetUrl());

        $this->loader->setLegacyPath(__DIR__);

        $response = $this->loader->load('legacy-loader/redirect-with-javascript.php');
        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $response);
        $this->assertEquals('/legacy-loader/redirected.php', $response->getTargetUrl());

        $response = $this->loader->load('legacy-loader/redirect-with-header.php');
        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $response);
        $this->assertEquals('/legacy-loader/redirected.php', $response->getTargetUrl());
    }

    private function readFile($fileName)
    {
        $output = '';

        if (is_file("{$this->legacyPath}/$fileName")) {
            $output = file_get_contents("{$this->legacyPath}/$fileName");
        }

        return $output;
    }
}
