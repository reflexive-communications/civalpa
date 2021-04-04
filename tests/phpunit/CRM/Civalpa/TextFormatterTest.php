<?php

/**
 * This is a generic test class for the extension (implemented with PHPUnit).
 */
class CRM_Civalpa_TextFormatterTest extends \PHPUnit\Framework\TestCase
{

  /**
   * The setup() method is executed before the test is executed (optional).
   */
    public function setUp(): void
    {
        parent::setUp();
    }

  /**
   * The tearDown() method is executed after the test was executed (optional)
   * This can be used for cleanup.
   */
    public function tearDown(): void
    {
        parent::tearDown();
    }

  /**
   * format test cases.
   */
    public function testFormat()
    {
        $config = [
        "debug-mode" => true,
        "text-line-width" => [
        "use" => true,
        "value" => 50,
        ],
        "html-line-width" => [
        "use" => true,
        "value" => 50,
        ],
        ];
      // empty values for text and html. config has to be unchanged, debug has to be empty.
        $emptyValue = "";
        $result = CRM_Civalpa_TextFormatter::format($config, $emptyValue, $emptyValue);
        self::assertTrue(array_key_exists("html", $result), "html key is missing from format result.");
        self::assertEquals($result["html"], $emptyValue, "Invalid html in format result.");
        self::assertTrue(array_key_exists("text", $result), "text key is missing from format result.");
        self::assertEquals($result["text"], $emptyValue, "Invalid text in format result.");
        self::assertTrue(array_key_exists("debug", $result), "debug key is missing from format result.");
        self::assertEquals($result["debug"], $emptyValue, "Invalid debug in format result.");
      // short values for text and html. config has to be unchanged, debug has to be empty.
        $shortText = "Something sort text.";
        $shortHtml = "<p>".$shortText."</p>";
        $result = CRM_Civalpa_TextFormatter::format($config, $shortText, $shortHtml);
        self::assertTrue(array_key_exists("html", $result), "html key is missing from format result.");
        self::assertEquals($result["html"], $shortHtml, "Invalid html in format result.");
        self::assertTrue(array_key_exists("text", $result), "text key is missing from format result.");
        self::assertEquals($result["text"], $shortText, "Invalid text in format result.");
        self::assertTrue(array_key_exists("debug", $result), "debug key is missing from format result.");
        self::assertEquals($result["debug"], $emptyValue, "Invalid debug in format result.");
      // long values for text and html. config has to be changed, debug has to be text and html.
        $longText = "Something sort text like árvíztűrőtükörfúrógép. Something sort text like árvíztűrőtükörfúrógép. Something sort text like árvíztűrőtükörfúrógép. Something sort text like árvíztűrőtükörfúrógép. Something sort text like árvíztűrőtükörfúrógép. Something sort text like árvíztűrőtükörfúrógép.";
        $expectedLongText = "Something sort text like\nárvíztűrőtükörfúrógép. Something sort\ntext like árvíztűrőtükörfúrógép.\nSomething sort text like\nárvíztűrőtükörfúrógép. Something sort\ntext like árvíztűrőtükörfúrógép.\nSomething sort text like\nárvíztűrőtükörfúrógép. Something sort\ntext like árvíztűrőtükörfúrógép.";
        $longHtml = "<p>".$longText."</p>";
        $expectedLongHtml = "<p>Something sort text like\nárvíztűrőtükörfúrógép. Something sort\ntext like árvíztűrőtükörfúrógép.\nSomething sort text like\nárvíztűrőtükörfúrógép. Something sort\ntext like árvíztűrőtükörfúrógép.\nSomething sort text like\nárvíztűrőtükörfúrógép. Something sort\ntext like árvíztűrőtükörfúrógép.</p>";
        $result = CRM_Civalpa_TextFormatter::format($config, $longText, $longHtml);
        self::assertTrue(array_key_exists("html", $result), "html key is missing from format result.");
        self::assertEquals($result["html"], $expectedLongHtml, "Invalid html in format result.");
        self::assertTrue(array_key_exists("text", $result), "text key is missing from format result.");
        self::assertEquals($result["text"], $expectedLongText, "Invalid text in format result.");
        self::assertTrue(array_key_exists("debug", $result), "debug key is missing from format result.");
        self::assertEquals($result["debug"], "textWrap,htmlWrap,", "Invalid debug in format result.");
    }
}
