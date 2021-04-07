<?php

use CRM_Civalpa_ExtensionUtil as E;
use Civi\Test\HeadlessInterface;
use Civi\Test\HookInterface;
use Civi\Test\TransactionalInterface;

/**
 * Settings form handler tests
 *
 * @group headless
 */
class CRM_Civalpa_Form_CivalpaSettingsTest extends \PHPUnit\Framework\TestCase implements HeadlessInterface, HookInterface, TransactionalInterface
{
    const TEST_SETTINGS = [
        "debug-mode" => true,
        "text-line-width" => [
            "use" => true,
            "value" => 30,
        ],
        "html-line-width" => [
            "use" => true,
            "value" => 30,
        ],
    ];
    public function setUpHeadless()
    {
        return \Civi\Test::headless()
            ->installMe(__DIR__)
            ->apply();
    }

    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    private function setupTestConfig()
    {
        $config = new CRM_Civalpa_Config(E::SHORT_NAME);
        self::assertTrue($config->update(self::TEST_SETTINGS), "Config update has to be successful.");
    }

    /**
     * PreProcess test case with existing config.
     * Setup test configuration then call the function.
     * It shouldn't throw exception.
     */
    public function testPreProcessExistingConfig()
    {
        $this->setupTestConfig();
        $form = new CRM_Civalpa_Form_CivalpaSettings();
        try {
            self::assertEmpty($form->preProcess(), "PreProcess supposed to be empty.");
        } catch (Exception $e) {
            self::fail("Shouldn't throw exception with valid db.");
        }
    }

    /**
     * PreProcess test case with deleted config.
     * Setup test configuration then call the function.
     * It should throw exception.
     */
    public function testPreProcessMissingConfig()
    {
        $form = new CRM_Civalpa_Form_CivalpaSettings();
        $config = new CRM_Civalpa_Config(E::SHORT_NAME);
        $config->remove();
        self::expectException(CRM_Core_Exception::class, "Invalid exception class.");
        self::expectExceptionMessage(E::SHORT_NAME."_config config invalid.", "Invalid exception message.");
        self::assertEmpty($form->preProcess(), "PreProcess supposed to be empty.");
    }

    /**
     * Build quick form test case.
     * Setup test configuration, preProcess then call the function.
     * It shouldn't throw exception.
     * The title should be set.
     */
    public function testBuildQuickForm()
    {
        $this->setupTestConfig();
        $form = new CRM_Civalpa_Form_CivalpaSettings();
        self::assertEmpty($form->preProcess(), "PreProcess supposed to be empty.");
        try {
            self::assertEmpty($form->buildQuickForm());
        } catch (Exception $e) {
            self::fail("It shouldn't throw exception.");
        }
        self::assertEquals("Civalpa Settings", $form->getTitle(), "Invalid form title.");
    }

    /**
     * Add Rules test case.
     * It shouldn't throw exception.
     */
    public function testAddRules()
    {
        $this->setupTestConfig();
        $form = new CRM_Civalpa_Form_CivalpaSettings();
        try {
            self::assertEmpty($form->addRules());
        } catch (Exception $e) {
            self::fail("It shouldn't throw exception.");
        }
    }

    /**
     * Config Validator test cases.
     */
    public function testConfigValidatorInvalid()
    {
        $testData = [
            [
                "data" => [
                    "textLineWidth" => "100",
                    "htmlLineWidth" => "100",
                ],
                "expectedResult" => true,
            ],
            [
                "data" => [
                    "textLineWidth" => "100tt",
                    "htmlLineWidth" => "100",
                ],
                "expectedResult" => ["textLineWidth" => "Only positiv integer values allowed."],
            ],
            [
                "data" => [
                    "textLineWidth" => "100",
                    "htmlLineWidth" => "100tt",
                ],
                "expectedResult" => ["htmlLineWidth" => "Only positiv integer values allowed."],
            ],
            [
                "data" => [
                    "textLineWidth" => "100tt",
                    "htmlLineWidth" => "100tt",
                ],
                "expectedResult" => ["htmlLineWidth" => "Only positiv integer values allowed.", "textLineWidth" => "Only positiv integer values allowed."],
            ],
        ];
        $this->setupTestConfig();
        $form = new CRM_Civalpa_Form_CivalpaSettings();
        foreach ($testData as $t) {
            self::assertEquals($t["expectedResult"], $form->configValidator($t["data"]), "Should return the expected value.");
        }
    }

    /**
     * Post Process test case. The values are the same.
     */
    public function testPostProcessNotChanged()
    {
        $_POST["debugMode"] = self::TEST_SETTINGS["debug-mode"];
        $_POST["useTextRule"] = self::TEST_SETTINGS["text-line-width"]["use"];
        $_POST["textLineWidth"] = self::TEST_SETTINGS["text-line-width"]["value"];
        $_POST["useHtmlRule"] = self::TEST_SETTINGS["html-line-width"]["use"];
        $_POST["htmlLineWidth"] = self::TEST_SETTINGS["html-line-width"]["value"];
        $this->setupTestConfig();
        $form = new CRM_Civalpa_Form_CivalpaSettings();
        self::assertEmpty($form->preProcess(), "PreProcess supposed to be empty.");
        try {
            self::assertEmpty($form->postProcess());
        } catch (Exception $e) {
            self::fail("It shouldn't throw exception.");
        }
    }

    /**
     * Post Process test case. The values are changed.
     */
    public function testPostProcessChanged()
    {
        $_POST["debugMode"] = !self::TEST_SETTINGS["debug-mode"];
        $_POST["useTextRule"] = self::TEST_SETTINGS["text-line-width"]["use"];
        $_POST["textLineWidth"] = self::TEST_SETTINGS["text-line-width"]["value"];
        $_POST["useHtmlRule"] = self::TEST_SETTINGS["html-line-width"]["use"];
        $_POST["htmlLineWidth"] = self::TEST_SETTINGS["html-line-width"]["value"];
        $this->setupTestConfig();
        $form = new CRM_Civalpa_Form_CivalpaSettings();
        self::assertEmpty($form->preProcess(), "PreProcess supposed to be empty.");
        try {
            self::assertEmpty($form->postProcess());
        } catch (Exception $e) {
            self::fail("It shouldn't throw exception.");
        }
    }

    /**
     * Set Default Values test case.
     */
    public function testSetDefaultValues()
    {
        $expectedDefaults = [
            "debugMode" => self::TEST_SETTINGS["debug-mode"],
            "useTextRule" => self::TEST_SETTINGS["text-line-width"]["use"],
            "textLineWidth" => self::TEST_SETTINGS["text-line-width"]["value"],
            "useHtmlRule" => self::TEST_SETTINGS["html-line-width"]["use"],
            "htmlLineWidth" => self::TEST_SETTINGS["html-line-width"]["value"],
        ];
        $this->setupTestConfig();
        $form = new CRM_Civalpa_Form_CivalpaSettings();
        self::assertEmpty($form->preProcess(), "PreProcess supposed to be empty.");
        self::assertEquals($expectedDefaults, $form->setDefaultValues(), "Invalid default values.");
    }
}
