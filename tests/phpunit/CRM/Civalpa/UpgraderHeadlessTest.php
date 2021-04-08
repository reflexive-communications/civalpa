<?php

use CRM_Civalpa_ExtensionUtil as E;
use Civi\Test\HeadlessInterface;
use Civi\Test\HookInterface;
use Civi\Test\TransactionalInterface;

/**
 * Tests for the install, uninstall process.
 *
 * @group headless
 */
class CRM_Civalpa_UpgraderHeadlessTest extends \PHPUnit\Framework\TestCase implements HeadlessInterface
{
    public function setUpHeadless()
    {
        return \Civi\Test::headless()
            ->installMe(__DIR__)
            ->apply();
    }

    public function setUp():void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Create a clean DB before running tests
     *
     * @throws CRM_Extension_Exception_ParseException
     */
    public static function tearDownAfterClass(): void
    {
        \Civi\Test::headless()
            ->uninstallMe(__DIR__)
            ->apply(true);
    }

    /**
     * Test the install process.
     */
    public function testInstall()
    {
        $installer = new CRM_Civalpa_Upgrader("civalpa_test", ".");
        try {
            $this->assertEmpty($installer->install());
        } catch (Exception $e) {
            $this->fail("Should not throw exception.");
        }
    }

    /**
     * Test the uninstall process.
     */
    public function testUninstall()
    {
        $installer = new CRM_Civalpa_Upgrader("civalpa_test", ".");
        $this->assertEmpty($installer->install());
        try {
            $this->assertEmpty($installer->uninstall());
        } catch (Exception $e) {
            $this->fail("Should not throw exception.");
        }
    }

    /**
     * Test the upgrade process.
     */
    public function testUpgrade_5000FreshInstall()
    {
        $installer = new CRM_Civalpa_Upgrader("civalpa_test", ".");
        $this->assertEmpty($installer->install());
        try {
            $this->assertTrue($installer->upgrade_5000());
        } catch (Exception $e) {
            $this->fail("Should not throw exception. ".$e->getMessage());
        }
    }
    public function testUpgrade_5000HasPreviousInstall()
    {
        $origConfig = [
            "debug-mode" => true,
            "text-line-width" => [
                "use" => true,
                "value" => 500,
            ],
            "html-line-width" => [
                "use" => true,
                "value" => 500,
            ],
        ];
        Civi::settings()->add(["civalpa_test_rules" => $origConfig]);
        $installer = new CRM_Civalpa_Upgrader("civalpa_test", ".");
        $this->assertEmpty($installer->install());
        try {
            $this->assertTrue($installer->upgrade_5000());
        } catch (Exception $e) {
            $this->fail("Should not throw exception. ".$e->getMessage());
        }
        $newConfig = Civi::settings()->get("civalpa_test_config");
        $this->assertEquals($origConfig, $newConfig, "Config has to be the same after the migration.");
        $this->assertNull(Civi::settings()->get("civalpa_test_rules"), "The orig config has to be removed.");
    }
}
