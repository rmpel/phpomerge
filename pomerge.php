<?php

use Gettext\Loader\PoLoader;
use Gettext\Generator\PoGenerator;
use Gettext\Merge;
use Gettext\Translation;
use Gettext\Translations;

require_once __DIR__ .'/vendor/autoload.php';

do_merge($argv[1], array_slice($argv, 2));

function do_merge($work_file, $merge_files) {
	
	$strategy = Merge::TRANSLATIONS_OVERRIDE | Merge::HEADERS_OURS;

	$loader = new PoLoader();
    /**
     * @var Translations $translations
     */
	$translations = $loader->loadFile( $work_file );

	foreach ($merge_files as $merge_file) {
		$translations = $translations->mergeWith( $loader->loadFile( $merge_file ), $strategy );
	}

    // Validate translations
    foreach ($translations as $translation) {
        /**
         * @var Translation $translation
         */
        if (preg_match( '/(.+)([: \n\r\t;]+)$/', $translation->getOriginal(), $m)) {
            $ending = $m[2];
            $l = strlen($ending);
            $t = $translation->getTranslation();
            if (substr($t, -$l, $l) !== $ending) {
                echo "Translation has wrong ending;\n\tSource:      ". inline_encode( $translation->getOriginal() ) ."\n\tTranslation: " . inline_encode( $translation->getTranslation() ) ."\n";
                $t = rtrim($t, ":;\n\t \r");
                echo "\tNew:         ". inline_encode( $t . $ending ) ."\n";
                $translation->translate($t . $ending);
            }

        }
    }

	$poGenerator = new PoGenerator();
	$poGenerator->generateFile($translations, $work_file);
}

function inline_encode( $string ) {
    return strtr($string, [
        "\t" => "\\t",
        "\n" => "\\n",
        "\r" => "\\e",
        " " => "•",
    ]);
}