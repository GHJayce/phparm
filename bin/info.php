<?php

declare(strict_types=1);

error_reporting(E_ALL);

$baseDir = dirname(__DIR__);

require "$baseDir/vendor/autoload.php";

$const = file_get_contents("$baseDir/docs/info.json");
$const = json_decode($const, true);

if (!$const || !is_array($const)) {
    throw new \RuntimeException('const file is invalid.');
}

function writeToComposer(string $composerFilePath, array $const): void
{
    $composer = file_get_contents($composerFilePath);
    $composer = json_decode($composer, true);
    if (!$composer || !is_array($composer)) {
        throw new \RuntimeException(sprintf('composer file "%s" is invalid.', $composerFilePath));
    }
    if (isset($composer['authors'][0])) {
        $composer['authors'][0]['homepage'] = $const['author']['homepage'];
        $composer['authors'][0]['name'] = $const['author']['name'];
        $composer['authors'][0]['email'] = $const['author']['email'];
    }
    if (isset($composer['homepage'])) {
        $composer['homepage'] = $const['githubUrl'];
    }
    if (isset($composer['support']['docs'])) {
        $composer['support']['docs'] = $const['docUrl'];
    }
    if (isset($composer['support']['issues'])) {
        $composer['support']['issues'] = $const['issueUrl'];
    }

    $composerContent = json_encode(
        $composer,
        JSON_PRETTY_PRINT | // 人类可读格式
        JSON_UNESCAPED_UNICODE | // 不转义 Unicode 字符
        JSON_UNESCAPED_SLASHES    // 不转义斜杠
    );
    file_put_contents($composerFilePath, $composerContent);
}

$composerFilePath = "$baseDir/composer.json";
writeToComposer($composerFilePath, $const);

$packageDirPath = "$baseDir/src";
$dirObject = opendir($packageDirPath);
while (($fileFullName = readdir($dirObject)) !== false) {
    if ($fileFullName !== '.' && $fileFullName !== '..') {
        writeToComposer($packageDirPath . "/" . $fileFullName . "/composer.json", $const);
    }
}
closedir($dirObject);