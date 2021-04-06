<?php

class CRM_Civalpa_TextFormatter
{
    public static function format(array $config, string $text = "", string $html = ""): array
    {
        $response = [
        "text" => $text,
        "html" => $html,
        "debug" => "",
        ];
        // format the text if the format flag is set and the value is gt 0.
        if ($config["text-line-width"]["use"] && $config["text-line-width"]["value"] > 0) {
            $wrappedText = wordwrap($text, $config["text-line-width"]["value"]);
            if ($wrappedText !== $text) {
                $response["debug"] .= "textWrap,";
                $response["text"] = $wrappedText;
            }
        }
        // format the html if the format flag is set and the value is gt 0.
        if ($config["html-line-width"]["use"] && $config["html-line-width"]["value"] > 0) {
            $wrappedText = wordwrap($html, $config["html-line-width"]["value"]);
            if ($wrappedText !== $html) {
                $response["debug"] .= "htmlWrap,";
                $response["html"] = $wrappedText;
            }
        }
        return $response;
    }
}
