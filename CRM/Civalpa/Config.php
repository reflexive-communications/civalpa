<?php

class CRM_Civalpa_Config {
  const DEFAULT_TEXT_LINE_WIDTH = 990;
  const DEFAULT_HTML_LINE_WIDTH = 990;

  public static function getConfig() {
    return [
      "debug-mode" => true,
      "text-line-width" => [
        "use" => true,
        "value" => self::DEFAULT_TEXT_LINE_WIDTH,
      ],
      "html-line-width" => [
        "use" => true,
        "value" => self::DEFAULT_HTML_LINE_WIDTH,
      ],
    ];
  }
}
