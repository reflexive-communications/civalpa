<?php

use CRM_Civalpa_ExtensionUtil as E;
use Civi\Test\HeadlessInterface;
use Civi\Test\HookInterface;
use Civi\Test\TransactionalInterface;

/**
 * FIXME - Add test description.
 *
 * Tips:
 *  - With HookInterface, you may implement CiviCRM hooks directly in the test class.
 *    Simply create corresponding functions (e.g. "hook_civicrm_post(...)" or similar).
 *  - With TransactionalInterface, any data changes made by setUp() or test****() functions will
 *    rollback automatically -- as long as you don't manipulate schema or truncate tables.
 *    If this test needs to manipulate schema or truncate tables, then either:
 *       a. Do all that using setupHeadless() and Civi\Test.
 *       b. Disable TransactionalInterface, and handle all setup/teardown yourself.
 *
 * @group headless
 */
class CRM_Civalpa_ConfigHeadlessTest extends \PHPUnit\Framework\TestCase implements HeadlessInterface, HookInterface, TransactionalInterface {

    public function setUpHeadless() {
        // Civi\Test has many helpers, like install(), uninstall(), sql(), and sqlFile().
        // See: https://docs.civicrm.org/dev/en/latest/testing/phpunit/#civitest
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
     * It checks that the create function works well.
     */
    public function testCreate() {
        $config = new CRM_Civalpa_Config("civalpa_test");
        self::assertTrue($config->create(), "Create config has to be successful.");
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

        self::assertTrue($config->create(), "Create config has to be successful multiple times.");
    }

    /**
     * It checks that the remove function works well.
     */
    public function testRemove() {
        $config = new CRM_Civalpa_Config("civalpa_test");
        self::assertTrue($config->create(), "Create config has to be successful.");
        self::assertTrue($config->remove(), "Remove config has to be successful.");
    }

    /**
     * It checks that the get function works well.
     */
    public function testGet() {
        $config = new CRM_Civalpa_Config("civalpa_test");
        self::assertTrue($config->create(), "Create config has to be successful.");
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

        self::assertTrue($config->remove(), "Remove config has to be successful.");
        self::assertException(CRM_Core_Exception::class, "Invalid exception class.");
        self::expectExceptionMessage("civalpa_test_rules config is missing.", "Invalid exception message.");
        $cfg = $config->get();
    }

    /**
     * It checks that the get function works well.
     */
    public function testUpdate() {
        $config = new CRM_Civalpa_Config("civalpa_test");
        self::assertTrue($config->create(), "Create config has to be successful.");
        $cfg = $config->get();
        $cfg["debug-mode"] = false;
        self::assertTrue($config->update($cfg), "Update config has to be successful.");
        $cfgUpdated = $config->get();
        self::assertEquals($cfg, $cfgUpdated, "Invalid updated configuration.");
    }

    /**
     * It checks that the get function works well.
     */
    public function testLoad() {
        $config = new CRM_Civalpa_Config("civalpa_test");
        self::assertTrue($config->create(), "Create config has to be successful.");
        $cfg = $config->get();
        $cfg["debug-mode"] = false;
        self::assertTrue($config->update($cfg), "Update config has to be successful.");
        $cfgUpdated = $config->get();
        self::assertEquals($cfg, $cfgUpdated, "Invalid updated configuration.");
        $otherConfig = new CRM_Civalpa_Config("civalpa_test");
        self::assertEmpty($otherConfig->load(), "Load result supposed to be empty.");

        $cfgLoaded = $otherConfig->get();
        self::assertEquals($cfg, $cfgLoaded, "Invalid loaded configuration.");
    }
}
