<?php

namespace App\Http\Controllers;

use App\System;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    public function generateConfigsForNewCity(Request $request)
    {
        $oknaConfig = file_get_contents(config_path() . '/database.php');
        $newCityConfig = "'" . mb_strtolower($request->fullTranslitName) . "' => [\r\n";
        $newCityConfig .= "\t\t\t'driver' => 'mysql',\r\n";
        $newCityConfig .= "\t\t\t'host' => '127.0.0.1',\r\n";
        $newCityConfig .= "\t\t\t'port' => '3306',\r\n";
        $newCityConfig .= "\t\t\t'database' => 'smartcrm_" . $request->shortName . "',\r\n";
        $newCityConfig .= "\t\t\t'username' => 'adminsmartcrm',\r\n";
        $newCityConfig .= "\t\t\t'password' => '0H0u7K1u',\r\n";
        $newCityConfig .= "\t\t\t'unix_socket' => env('DB_SOCKET', ''),\r\n";
        $newCityConfig .= "\t\t\t'charset' => 'utf8mb4',\r\n";
        $newCityConfig .= "\t\t\t'collation' => 'utf8mb4_unicode_ci',\r\n";
        $newCityConfig .= "\t\t\t'prefix' => '',\r\n";
        $newCityConfig .= "\t\t\t'strict' => true,\r\n";
        $newCityConfig .= "\t\t\t'engine' => null,\r\n";
        $newCityConfig .= "\t\t\t'timezoneSettings' => '" . $request->timezone . "',\r\n";
        $newCityConfig .= "\t\t\t'shortName' => '" . $request->shortName . "',\r\n";
        $newCityConfig .= "        ],\r\n\r\n";
        $newOknaConfig = preg_replace('/(.*?)(\/\/\@preg_city_config_path)(.*)/m', '$1' . $newCityConfig . '        $2$3', $oknaConfig);
        exec("sudo chmod -R 0777 " . base_path() . "/config/database.php", $output, $return);
        $file = fopen(base_path() . '/config/database.php', 'w');
        $firstWrite = fwrite($file, $newOknaConfig);
        fclose($file);
        exec("sudo chmod -R 0644 " . base_path() . "/config/database.php", $output, $return);

        if(!$firstWrite)
            echo false;

        if(!empty($request->background)) {
            $system = new System();
            $background = $system->uploadCityBackground($request->background, $request->fullTranslitName);
            if(!$background['success'])
                echo false;
        }

        $oknaConstants = file_get_contents(config_path() . '/constants.php');
        $newCityConstants = "'" . mb_strtolower($request->fullTranslitName) . "' => [\r\n";
        $newCityConstants .= "\t\t'phone' => '<span class=\"callibri_" . $request->shortName . " main-phone\">" . preg_replace('/(\d{1})(\d{3})(\d{3})(\d{2})(\d{2})/', '+$1 ($2) $3-$4-$5', $request->phone) . "</span>',\r\n";
        $newCityConstants .= "\t\t'email' => '" . $request->email . "',\r\n";
        $newCityConstants .= "\t\t'address' => '" . $request->address . "',\r\n";
        $newCityConstants .= "\t\t'geo_coords' => '[" . $request->latitude . ", " . $request->longitude . "]',\r\n";
        $newCityConstants .= "\t\t'company_name' => '" . $request->company_name . "',\r\n";
        $newCityConstants .= "\t\t'legal_company_name' => '" . $request->legal_company_name . "',\r\n";
        $newCityConstants .= "\t\t'instagram' => '" . $request->instagram . "',\r\n";
        $newCityConstants .= "\t\t'vk' => '" . $request->vk . "',\r\n";
        $newCityConstants .= "\t\t'ok' => '" . $request->ok . "',\r\n";
        $newCityConstants .= "\t\t'facebook' => '" . $request->facebook . "',\r\n";
        $newCityConstants .= "\t\t'cityNameForms' => ['" . $request->cityNameForms_0 . "', '" . $request->cityNameForms_1 . "', '" . $request->cityNameForms_2 . "', '" . $request->cityNameForms_3 . "', '" . $request->cityNameForms_4 . "', '" . $request->cityNameForms_5 . "'],\r\n";
        $newCityConstants .= "\t\t'yandexMetrika' => '" . $request->yandexMetrika . "',\r\n";
        $newCityConstants .= "\t\t'background' => '" . $background['result'] . "',\r\n";
        $newCityConstants .= "    ],\r\n";

        $newCityMailable = "'" . mb_strtolower($request->fullTranslitName) . "' => [\r\n";
        $mailable = json_decode($request->mailable, true);
        foreach($mailable as $key => $value) {
            $newCityMailable .= "\t\t'" . $key . "' => '" . $value . "',\r\n";
        }
        $newCityMailable .= "    ],\r\n";

        $newCityMailFrom = "'" . mb_strtolower($request->fullTranslitName) . "' => [\r\n";
        $newCityMailFrom .= "\t\t'email' => '" . $request->mailfrom . "',\r\n";
        $newCityMailFrom .= "\t\t'mailName' => '" . $request->mailfromName . "',\r\n";
        $newCityMailFrom .= "    ],\r\n";

        $newOknaConstants = preg_replace('/(.*?)(\/\/\@preg_city_config_path)(.*)/m', '$1' . $newCityConstants . '    $2$3', $oknaConstants);
        $newOknaConstants = preg_replace('/(.*?)(\/\/\@preg_city_config_mailable)(.*)/m', '$1' . $newCityMailable . '    $2$3', $newOknaConstants);
        $newOknaConstants = preg_replace('/(.*?)(\/\/\@preg_city_config_mailfrom)(.*)/m', '$1' . $newCityMailFrom . '    $2$3', $newOknaConstants);
        exec("sudo chmod -R 0777 " . base_path() . "/config/constants.php", $output, $return);
        $file = fopen(base_path() . '/config/constants.php', 'w');
        $secondWrite = fwrite($file, $newOknaConstants);
        fclose($file);
        exec("sudo chmod -R 0644 " . base_path() . "/config/constants.php", $output, $return);

        if(!$secondWrite)
            echo false;

        echo true;
    }
}
