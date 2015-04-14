<?php

use Ds3\Libraries\Legacy\Loader;

class LoaderTest extends TestCase {
    private $loader;
    private $legacyPath;

    public function setUp()
    {$legacyPath = __DIR__ . '/legacy-loader';
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
        $this->assertEquals($this->loader->getLegacyPath(), $this->legacyPath);
    }

    public function testRequestParams()
    {
        $this->assertEquals($this->loader->getRequestParams(), ['get' => [], 'post' => []]);

        $this->loader->setRequestParams('get', ['first' => 1]);
        $this->assertEquals($this->loader->getRequestParams(), ['get' => [
            'first' => 1
        ], 'post' => []]);

        $this->loader->setRequestParams('get', ['second' => 2]);
        $this->assertEquals($this->loader->getRequestParams(), ['get' => [
            'first' => 1,
            'second' => 2,
        ], 'post' => []]);

        $this->loader->setRequestParams('post', ['third' => 3]);
        $this->assertEquals($this->loader->getRequestParams(), ['get' => [
            'first' => 1,
            'second' => 2,
        ], 'post' => [
            'third' => 3
        ]]);

        $this->loader->setRequestParams('post', ['fourth' => 4, 'fifth' => 5]);
        $this->assertEquals($this->loader->getRequestParams(), ['get' => [
            'first' => 1,
            'second' => 2,
        ], 'post' => [
            'third' => 3,
            'fourth' => 4,
            'fifth' => 5
        ]]);

        $this->loader->setRequestParams('post', ['replaced' => true], true);
        $this->assertEquals($this->loader->getRequestParams(), ['get' => [
            'first' => 1,
            'second' => 2,
        ], 'post' => [
            'replaced' => true
        ]]);
    }

    public function testGetRealPath()
    {
        $this->assertFalse($this->loader->getRealPath('file-does-not-exist.php'));
        $this->assertEquals($this->loader->getRealPath('plain-output.php'), "{$this->legacyPath}/plain-output.php");
    }

    public function testIsLegacyFile()
    {
        $this->assertFalse($this->loader->isLegacyFile('file-does-not-exist'));
        $this->assertFalse($this->loader->isLegacyFile("{$this->legacyPath}/file-does-not-exist", true));

        $this->assertTrue($this->loader->isLegacyFile('plain-output.php'));
        $this->assertTrue($this->loader->isLegacyFile("{$this->legacyPath}/plain-output.php", true));

        $this->assertFalse($this->loader->isLegacyFile('plain-output.php', true));
    }

    public function testGetRedirection()
    {
        $this->assertEquals(Loader::getRedirection([], $this->readFile('plain-output.php'), 'fake-legacy-path/'), '');

        $this->assertEquals(
            Loader::getRedirection([], $this->readFile('redirect-with-javascript.php'), 'fake-legacy-path/'),
            '/fake-legacy-path/redirected.php'
        );

        $this->assertEquals(
            Loader::getRedirection(
                ['location' => '/different-fake-path'],
                $this->readFile('redirect-with-javascript.php'),
                'fake-legacy-path/'
            ),
            '/different-fake-path'
        );

        $this->assertEquals(
            Loader::getRedirection(
                ['Location: /different-fake-path'],
                $this->readFile('redirect-with-javascript.php'),
                'fake-legacy-path/'
            ),
            '/different-fake-path'
        );
    }

    public function testInjectBaseTag()
    {
        $this->assertEquals(Loader::injectBaseTag('', 'legacy/path'), '');
        $this->assertEquals(Loader::injectBaseTag('<head>', 'legacy/path'), '<head><base href="/legacy/path">');

        $this->assertEquals(
            Loader::injectBaseTag('<head meta-tag="abc">', 'legacy/path'),
            '<head meta-tag="abc"><base href="/legacy/path">'
        );

        $this->assertEquals(
            Loader::injectBaseTag('<head meta-tag="abc">', '/'),
            '<head meta-tag="abc"><base href="/">'
        );

        $this->assertEquals(
            Loader::injectBaseTag('<head meta-tag="abc">', '//'),
            '<head meta-tag="abc"><base href="/">'
        );
    }

    public function testLoadWithoutRedirect()
    {
        $response = $this->loader->load('plain-output.php');
        $this->assertInstanceOf('Illuminate\Http\Response', $response);
        $this->assertEquals($response->getContent(), $this->readFile('plain-output.php'));

        $response = $this->loader->load('html-output.php');
        $this->assertInstanceOf('Illuminate\Http\Response', $response);
        $this->assertEquals($response->getContent(), $this->readFile('html-with-root-base-tag.txt'));

        $this->loader->setLegacyPath(__DIR__);

        $response = $this->loader->load('plain-output.php');
        $this->assertInstanceOf('Illuminate\Http\Response', $response);
        $this->assertEquals($response->getContent(), $this->readFile('plain-output.php'));

        $response = $this->loader->load('legacy-loader/html-output.php');
        $this->assertInstanceOf('Illuminate\Http\Response', $response);
        $this->assertEquals($response->getContent(), $this->readFile('html-with-subdir-base-tag.txt'));
    }

    public function testLoadWithRedirect()
    {
        $response = $this->loader->load('redirect-with-javascript.php');
        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $response);
        $this->assertEquals($response->getTargetUrl(), '/redirected.php');

        $response = $this->loader->load('redirect-with-header.php');
        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $response);
        $this->assertEquals($response->getTargetUrl(), '/redirected.php');

        $this->loader->setLegacyPath(__DIR__);

        $response = $this->loader->load('legacy-loader/redirect-with-javascript.php');
        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $response);
        $this->assertEquals($response->getTargetUrl(), '/legacy-loader/redirected.php');

        $response = $this->loader->load('legacy-loader/redirect-with-header.php');
        $this->assertInstanceOf('Illuminate\Http\RedirectResponse', $response);
        $this->assertEquals($response->getTargetUrl(), '/legacy-loader/redirected.php');
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
