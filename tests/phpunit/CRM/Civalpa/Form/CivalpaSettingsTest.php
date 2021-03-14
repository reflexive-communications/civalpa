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
class CRM_Civalpa_Form_CivalpaSettingsTest extends \PHPUnit\Framework\TestCase implements HeadlessInterface, HookInterface, TransactionalInterface {

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
    public function setUpHeadless() {
        return \Civi\Test::headless()
            ->installMe(__DIR__)
            ->apply();
    }

    public function setUp(): void {
        parent::setUp();
    }

    public function tearDown(): void {
        parent::tearDown();
    }

    /**
     * PreProcess test case with existing config.
     * Setup test configuration then call the function.
     * It shouldn't throw exception.
     */
    public function testPreProcessExistingConfig() {
        $this->markTestIncomplete("This test has not been implemented yet.");
    }

    /**
     * PreProcess test case with deleted config.
     * Setup test configuration then call the function.
     * It should throw exception.
     */
    public function testPreProcessMissingConfig() {
        $this->markTestIncomplete("This test has not been implemented yet.");
    }

    /**
     * Build quick form test case.
     * Setup test configuration then call the function.
     * It shouldn't throw exception.
     * The number of form elements should be fine.
     * The number of buttons should be fine.
     * The title should be set.
     */
    public function testBuildQuickForm() {
        $this->markTestIncomplete("This test has not been implemented yet.");
    }

    /**
     * Add Rules test case.
     * It shouldn't throw exception.
     */
    public function testAddRules() {
        $this->markTestIncomplete("This test has not been implemented yet.");
    }

    /**
     * Config Validator test case with valid values.
     */
    public function testConfigValidatorValid() {
        $this->markTestIncomplete("This test has not been implemented yet.");
    }

    /**
     * Config Validator test case with invalid values.
     */
    public function testConfigValidatorInvalid() {
        $this->markTestIncomplete("This test has not been implemented yet.");
    }

    /**
     * Post Process test case. The values are the same.
     */
    public function testPostProcessNotChanged() {
        $this->markTestIncomplete("This test has not been implemented yet.");
    }

    /**
     * Post Process test case. The values are changed.
     */
    public function testPostProcessChanged() {
        $this->markTestIncomplete("This test has not been implemented yet.");
    }

    /**
     * Set Default Values test case.
     */
    public function testSetDefaultValues() {
        $this->markTestIncomplete("This test has not been implemented yet.");
    }
}
