<?php

/**
 * This is a generic test class for the extension (implemented with PHPUnit).
 */
class CRM_Civalpa_ConfigTest extends \PHPUnit\Framework\TestCase
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
     * Default configuration test case.
     *
     */
    public function testConfigAfterConstructor()
    {
        $config = new CRM_Civalpa_Config("civalpa_test");
        $cfg = $config->get();
        self::assertTrue(array_key_exists("debug-mode", $cfg), "debug-mode key is missing from the config.");
        self::assertTrue($cfg["debug-mode"], "Invalid debug mode initial value.");
        self::assertTrue(array_key_exists("text-line-width", $cfg), "text-line-width key is missing from the config.");
        self::assertTrue(array_key_exists("use", $cfg["text-line-width"]), "text-line-width.use key is missing from the config.");
        self::assertTrue($cfg["text-line-width"]["use"], "Invalid text-line-width.use initial value.");
        self::assertTrue(array_key_exists("value", $cfg["text-line-width"]), "text-line-width.value key is missing from the config.");
        self::assertEquals($cfg["text-line-width"]["value"], CRM_Civalpa_Config::DEFAULT_TEXT_LINE_WIDTH, "Invalid text-line-width.value value.");
        self::assertTrue(array_key_exists("html-line-width", $cfg), "html-line-width key is missing from the config.");
        self::assertTrue(array_key_exists("use", $cfg["html-line-width"]), "html-line-width.use key is missing from the config.");
        self::assertTrue($cfg["html-line-width"]["use"], "Invalid html-line-width.use initial value.");
        self::assertTrue(array_key_exists("value", $cfg["html-line-width"]), "html-line-width.value key is missing from the config.");
        self::assertEquals($cfg["html-line-width"]["value"], CRM_Civalpa_Config::DEFAULT_HTML_LINE_WIDTH, "Invalid html-line-width.value value.");
    }
}
