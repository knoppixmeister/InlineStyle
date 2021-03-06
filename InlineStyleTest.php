<?php
require_once 'PHPUnit/Framework.php';

require_once 'CSSQuery.php';
require_once 'InlineStyle.php';

/**
 * Test class for InlineStyle.
 * Generated by PHPUnit on 2010-03-10 at 21:52:44.
 */
class InlineStyleTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var InlineStyle
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new InlineStyle("testfiles/test.html");
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    	unset($this->object);
    }
    
    public function testGetHTML()
    {
    	$this->assertEquals($this->object->getHTML(),
			file_get_contents("testfiles/testGetHTML.html"));
    }

    public function testApplyStyleSheet()
    {
		$this->object->applyStyleSheet("p:not(.p2) { color: red }");
		$this->assertEquals($this->object->getHTML(),
			file_get_contents("testfiles/testApplyStylesheet.html"));
    }

    public function testApplyRule()
    {
    	$this->object->applyRule("p:not(.p2)", "color: red");
    	$this->assertEquals($this->object->getHTML(),
			file_get_contents("testfiles/testApplyStylesheet.html"));
    }

    public function testExtractStylesheets()
    {
        $stylesheets = $this->object->extractStylesheets(null, "testfiles");
        $this->assertEquals($stylesheets, array(
'p{
	margin:0;
	padding:0 0 10px 0;
	background-image: url("someimage.jpg");
}
a:hover{
	color:Red;
}
p:hover{
	color:blue;
}
',
'
			h1{
				color:yellow
			}
			p {
				color:yellow !important;
			}
			p {
				color:blue
			}
		',
));
    }

	public function testApplyExtractedStylesheet()
	{
		$stylesheets = $this->object->extractStylesheets(null, "testfiles");
		$this->object->applyStylesheet($stylesheets);

		$this->assertEquals($this->object->getHTML(),
			file_get_contents("testfiles/testApplyExtractedStylesheet.html"));
	}

    public function testParseStyleSheet()
    {
    	$parsed = $this->object->parseStylesheet("p:not(.p2) { color: red }");
    	$this->assertEquals($parsed, array(array("p:not(.p2)", "color: red")));
    }
}
