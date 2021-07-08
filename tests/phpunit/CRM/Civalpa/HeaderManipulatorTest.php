<?php

/**
 * This is a generic test class for the extension (implemented with PHPUnit).
 */
class CRM_Civalpa_HeaderManipulatorTest extends \PHPUnit\Framework\TestCase
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
     * Update test case.
     */
    public function testUpdateSetEmptyDebugFlag()
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
        "headers" => [],
        ];
        $params = [
        "text" => "test text",
        "html" => "<p>test html</p>",
        ];
        $debugMessage = "";
        CRM_Civalpa_HeaderManipulator::update($params, $config, $debugMessage);
        self::assertTrue(array_key_exists("headers", $params), "headers key is missing after header update.");
        self::assertTrue(array_key_exists("X-CIVALPA-DEBUG", $params["headers"]), "X-CIVALPA-DEBUG header is missing after header update.");
        self::assertEquals("", $params["headers"]["X-CIVALPA-DEBUG"], "Header value supposed to be empty.");
    }
    public function testUpdateSetDebugFlag()
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
        "headers" => [],
        ];
        $params = [
        "text" => "test text",
        "html" => "<p>test html</p>",
        ];
        $debugMessage = "existingMessage,";
        CRM_Civalpa_HeaderManipulator::update($params, $config, $debugMessage);
        self::assertTrue(array_key_exists("headers", $params), "headers key is missing after header update.");
        self::assertTrue(array_key_exists("X-CIVALPA-DEBUG", $params["headers"]), "X-CIVALPA-DEBUG header is missing after header update.");
        self::assertEquals($debugMessage, $params["headers"]["X-CIVALPA-DEBUG"], "Header value supposed to be empty.");
    }
    public function testUpdateDebugModeOffNoDebugFlagNoHeaders()
    {
        $config = [
        "debug-mode" => false,
        "text-line-width" => [
        "use" => true,
        "value" => 50,
        ],
        "html-line-width" => [
        "use" => true,
        "value" => 50,
        ],
        "headers" => [],
        ];
        $params = [
        "text" => "test text",
        "html" => "<p>test html</p>",
        ];
        $debugMessage = "existingError,";
        CRM_Civalpa_HeaderManipulator::update($params, $config, $debugMessage);
        self::assertFalse(array_key_exists("headers", $params), "headers key is set after header update.");
    }
    public function testUpdateDebugModeOffNoDebugFlagWithHeaders()
    {
        $config = [
        "debug-mode" => false,
        "text-line-width" => [
        "use" => true,
        "value" => 50,
        ],
        "html-line-width" => [
        "use" => true,
        "value" => 50,
        ],
        "headers" => [],
        ];
        $params = [
        "text" => "test text",
        "html" => "<p>test html</p>",
        "headers" => [
        "X-Something" => "1",
        ],
        ];
        $debugMessage = "existingError,";
        CRM_Civalpa_HeaderManipulator::update($params, $config, $debugMessage);
        self::assertTrue(array_key_exists("headers", $params), "headers key has to be set.");
        self::assertFalse(array_key_exists("X-CIVALPA-DEBUG", $params["headers"]), "headers shouldn't be set after header update.");
    }
    public function testUpdateDeleteFromParamHeader()
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
        "headers" => [
        [
          "name" => "X-ToDelete",
          "unset" => true,
          "set" => false,
          "value" => "",
        ],
        ],
        ];
        $params = [
        "text" => "test text",
        "html" => "<p>test html</p>",
        "X-ToDelete" => "myValue",
        "headers" => [
        "X-Something" => "1",
        ],
        ];
        $debugMessage = "existingError,";
        CRM_Civalpa_HeaderManipulator::update($params, $config, $debugMessage);
        self::assertTrue(array_key_exists("headers", $params), "headers key has to be set.");
        self::assertTrue(array_key_exists("X-CIVALPA-DEBUG", $params["headers"]), "X-CIVALPA-DEBUG header should be set after header update.");
        self::assertEquals($debugMessage."headerUnset:X-ToDelete,", $params["headers"]["X-CIVALPA-DEBUG"], "Header value supposed to be expected value.");
        self::assertFalse(array_key_exists("X-ToDelete", $params), "header shouldn't be set after header update.");
    }
    public function testUpdateDeleteFromHeader()
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
        "headers" => [
        [
          "name" => "X-Something",
          "unset" => true,
          "set" => false,
          "value" => "",
        ],
        ],
        ];
        $params = [
        "text" => "test text",
        "html" => "<p>test html</p>",
        "X-ToDelete" => "myValue",
        "headers" => [
        "X-Something" => "1",
        ],
        ];
        $debugMessage = "existingError,";
        CRM_Civalpa_HeaderManipulator::update($params, $config, $debugMessage);
        self::assertTrue(array_key_exists("headers", $params), "headers key has to be set.");
        self::assertTrue(array_key_exists("X-CIVALPA-DEBUG", $params["headers"]), "X-CIVALPA-DEBUG header should be set after header update.");
        self::assertEquals($debugMessage."headerUnset:X-Something,", $params["headers"]["X-CIVALPA-DEBUG"], "Header value supposed to be expected value.");
        self::assertFalse(array_key_exists("X-ToDelete", $params["headers"]), "header shouldn't be set after header update.");
    }
    public function testUpdateSetInParamHeader()
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
        "headers" => [
        [
          "name" => "X-ToDelete",
          "unset" => false,
          "set" => true,
          "value" => "Blah",
        ],
        ],
        ];
        $params = [
        "text" => "test text",
        "html" => "<p>test html</p>",
        "X-ToDelete" => "myValue",
        "headers" => [
        "X-Something" => "1",
        ],
        ];
        $debugMessage = "existingError,";
        CRM_Civalpa_HeaderManipulator::update($params, $config, $debugMessage);
        self::assertTrue(array_key_exists("headers", $params), "headers key has to be set.");
        self::assertTrue(array_key_exists("X-CIVALPA-DEBUG", $params["headers"]), "X-CIVALPA-DEBUG header should be set after header update.");
        self::assertEquals($debugMessage."headerSet:X-ToDelete,", $params["headers"]["X-CIVALPA-DEBUG"], "Header value supposed to be expected value.");
        self::assertTrue(array_key_exists("X-ToDelete", $params), "header should be set after header update.");
        self::assertEquals($config["headers"][0]["value"], $params["X-ToDelete"], "Header value supposed to be expected value.");
    }
    public function testUpdateSetInHeader()
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
        "headers" => [
        [
          "name" => "X-Something",
          "unset" => false,
          "set" => true,
          "value" => "Blah",
        ],
        ],
        ];
        $params = [
        "text" => "test text",
        "html" => "<p>test html</p>",
        "X-ToDelete" => "myValue",
        ];
        $debugMessage = "existingError,";
        CRM_Civalpa_HeaderManipulator::update($params, $config, $debugMessage);
        self::assertTrue(array_key_exists("headers", $params), "headers key has to be set.");
        self::assertTrue(array_key_exists("X-CIVALPA-DEBUG", $params["headers"]), "X-CIVALPA-DEBUG header should be set after header update.");
        self::assertEquals($debugMessage."headerSet:X-Something,", $params["headers"]["X-CIVALPA-DEBUG"], "Header value supposed to be expected value.");
        self::assertTrue(array_key_exists("X-Something", $params["headers"]), "header shouldn't be set after header update.");
        self::assertEquals($config["headers"][0]["value"], $params["headers"]["X-Something"], "Header value supposed to be expected value.");
    }
    public function testUpdateUpdateInHeader()
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
        "headers" => [
        [
          "name" => "X-Something",
          "unset" => false,
          "set" => true,
          "value" => "Blah",
        ],
        ],
        ];
        $params = [
        "text" => "test text",
        "html" => "<p>test html</p>",
        "X-ToDelete" => "myValue",
        "headers" => [
        "X-Something" => "1",
        ],
        ];
        $debugMessage = "existingError,";
        CRM_Civalpa_HeaderManipulator::update($params, $config, $debugMessage);
        self::assertTrue(array_key_exists("headers", $params), "headers key has to be set.");
        self::assertTrue(array_key_exists("X-CIVALPA-DEBUG", $params["headers"]), "X-CIVALPA-DEBUG header should be set after header update.");
        self::assertEquals($debugMessage."headerSet:X-Something,", $params["headers"]["X-CIVALPA-DEBUG"], "Header value supposed to be expected value.");
        self::assertTrue(array_key_exists("X-Something", $params["headers"]), "header shouldn't be set after header update.");
        self::assertEquals($config["headers"][0]["value"], $params["headers"]["X-Something"], "Header value supposed to be expected value.");
    }
    public function testUpdateMissingConfig()
    {
        $config = [];
        $params = [
            "text" => "test text",
            "html" => "<p>test html</p>",
            "X-ToDelete" => "myValue",
            "headers" => [
                "X-Something" => "1",
            ],
        ];
        $debugMessage = "existingError,";
        CRM_Civalpa_HeaderManipulator::update($params, $config, $debugMessage);
        self::assertTrue(array_key_exists("headers", $params), "headers key has to be set.");
        self::assertFalse(array_key_exists("X-CIVALPA-DEBUG", $params["headers"]), "X-CIVALPA-DEBUG header shouldn't be set if the config is missing.");
        self::assertTrue(array_key_exists("X-Something", $params["headers"]), "header shouldn't be set after header update.");
        self::assertEquals("1", $params["headers"]["X-Something"], "Header value supposed to be expected value.");
    }
}
