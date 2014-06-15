<?php

namespace Prewk;

use \PHPUnit_Framework_TestCase;
use \Mockery;

class XmlStringStreamerIntegrationTest extends PHPUnit_Framework_TestCase
{
    public function test_createStringWalkerParser_convenience_method_with_pubmed_xml()
    {
        $file = __dir__ . "/../../xml/pubmed-example.xml";

        $streamer = XmlStringStreamer::createStringWalkerParser($file);

        $expectedPMIDs = array("24531174", "24529294", "24449586");
        $foundPMIDs = array();

        while ($node = $streamer->getNode()) {
            $xmlNode = simplexml_load_string($node);
            $foundPMIDs[] = (string)$xmlNode->MedlineCitation->PMID;
        }
        
        $this->assertEquals($expectedPMIDs, $foundPMIDs, "The PMID nodes should be as expected");
    }

    public function test_createStringWalkerParser_convenience_method_with_orphanet_xml_and_custom_captureDepth()
    {
        $file = __dir__ . "/../../xml/orphanet-xml-example.xml";

        $streamer = XmlStringStreamer::createStringWalkerParser($file, array(
            "captureDepth" => 2,
        ));

        $expectedOrphaNumbers = array("166024", "166032", "58");
        $foundOrphaNumbers = array();

        while ($node = $streamer->getNode()) {
            $xmlNode = simplexml_load_string($node);
            $foundOrphaNumbers[] = (string)$xmlNode->OrphaNumber;
        }
        
        $this->assertEquals($expectedOrphaNumbers, $foundOrphaNumbers, "The OrphaNumber nodes should be as expected");
    }

    public function test_createUniqueNodeParser_convenience_method_with_pubmed_xml()
    {
        $file = __dir__ . "/../../xml/pubmed-example.xml";

        $streamer = XmlStringStreamer::createUniqueNodeParser($file, array(
            "uniqueNode" => "PubmedArticle"
        ));

        $expectedPMIDs = array("24531174", "24529294", "24449586");
        $foundPMIDs = array();

        while ($node = $streamer->getNode()) {
            $xmlNode = simplexml_load_string($node);
            $foundPMIDs[] = (string)$xmlNode->MedlineCitation->PMID;
        }
        
        $this->assertEquals($expectedPMIDs, $foundPMIDs, "The PMID nodes should be as expected");
    }

    public function test_createUniqueNodeParser_convenience_method_with_orphanet_xml_and_custom_captureDepth()
    {
        $file = __dir__ . "/../../xml/orphanet-xml-example.xml";

        $streamer = XmlStringStreamer::createUniqueNodeParser($file, array(
            "uniqueNode" => "Disorder"
        ));

        $expectedOrphaNumbers = array("166024", "166032", "58");
        $foundOrphaNumbers = array();

        while ($node = $streamer->getNode()) {
            $xmlNode = simplexml_load_string($node);
            $foundOrphaNumbers[] = (string)$xmlNode->OrphaNumber;
        }
        
        $this->assertEquals($expectedOrphaNumbers, $foundOrphaNumbers, "The OrphaNumber nodes should be as expected");
    }
}