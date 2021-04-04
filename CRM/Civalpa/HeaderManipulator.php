<?php

class CRM_Civalpa_HeaderManipulator
{

    public static function update(&$params, array $config, string $debugMessage = "")
    {
        foreach ($config["headers"] as $headerConfig) {
            $headerName = $headerConfig["name"];
            if ($headerConfig["unset"]) {
                if (isset($params[$headerName])) {
                    unset($params[$headerName]);
                    $debugMessage .= "headerUnset:".$headerName.",";
                } elseif (isset($params["headers"]) && isset($params["headers"][$headerName])) {
                    unset($params["headers"][$headerName]);
                    $debugMessage .= "headerUnset:".$headerName.",";
                }
            } elseif ($headerConfig["set"]) {
                if (isset($params[$headerName])) {
                    $params[$headerName] = $headerConfig["value"];
                    $debugMessage .= "headerSet:".$headerName.",";
                } else {
                    if (!isset($params["headers"])) {
                        $params["headers"] = [];
                    }
                    $params["headers"][$headerName] = $headerConfig["value"];
                    $debugMessage .= "headerSet:".$headerName.",";
                }
            }
        }
        if ($config["debug-mode"]) {
            if (!isset($params["headers"])) {
                $params["headers"] = [];
            }
            $params["headers"]["X-CIVALPA-DEBUG"] = $debugMessage;
        }
    }
}
