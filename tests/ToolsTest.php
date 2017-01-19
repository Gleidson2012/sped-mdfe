<?php

namespace Tests\NFePHP\MDFe;

/**
 * @author Roberto L. Machado <linux.rlm at gmail dot com>
 */
use NFePHP\Common\Exception\InvalidArgumentException;
use NFePHP\Common\Files\FilesFolders;
use NFePHP\MDFe\Tools;
use PHPUnit_Framework_TestCase;

class ToolsTest extends PHPUnit_Framework_TestCase
{
    public $mdfe;
    private $xmlFilepath;
    private $xmlContent;

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInstanciar()
    {
        $configJson = dirname(__FILE__) . '/fixtures/config/fakeconfig.json';
        $this->mdfe = new Tools($configJson);
    }

    public function testDeveRetornarArrayVazioSeXmlForValido()
    {
        $retorno = Tools::validarXmlMdfe($this->xmlContent, Tools::$PL_MDFe_300);
        $this->assertInternalType('array', $retorno);
        $this->assertEmpty($retorno);
    }

    public function testDeveRetornarArrayComErrosDeValizacaoSeXmlForInvalido()
    {
        $invalidXmlContent = str_replace('<cUF>41</cUF>', '', $this->xmlContent);
        $retorno = Tools::validarXmlMdfe($invalidXmlContent, Tools::$PL_MDFe_300);
        $this->assertInternalType('array', $retorno);
        $this->assertNotEmpty($retorno);
    }

    protected function setUp()
    {
        parent::setUp();

        $this->xmlFilepath = implode(DIRECTORY_SEPARATOR, [
            __DIR__, 'fixtures', 'xml', 'MDFe35353535353535353535353535353535353535353535.xml'
        ]);
        $this->xmlContent = FilesFolders::readFile($this->xmlFilepath);
    }

    protected function tearDown()
    {
        parent::tearDown();

        unset($this->xmlFilepath, $this->xmlContent);
    }


}
