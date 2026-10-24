<?php

namespace App\Support;

use Illuminate\Support\Facades\File;
use InvalidArgumentException;
use RuntimeException;

class TranslationFileManager
{
    public function __construct(private readonly ?string $languageDirectory = null)
    {
    }

    public function provisionLocale(string $locale): void
    {
        if (! preg_match('/^[A-Za-z0-9_-]{2,10}$/', $locale)) {
            throw new InvalidArgumentException('The locale code contains unsupported characters.');
        }

        $languageDirectory = $this->languageDirectory ?? lang_path();
        $sourceDirectory = $languageDirectory.DIRECTORY_SEPARATOR.'en';

        if (! File::isDirectory($sourceDirectory)) {
            throw new RuntimeException('The English translation directory does not exist.');
        }

        $targetDirectory = $languageDirectory.DIRECTORY_SEPARATOR.$locale;
        File::ensureDirectoryExists($targetDirectory);

        foreach (File::files($sourceDirectory) as $sourceFile) {
            if ($sourceFile->getExtension() !== 'php') {
                continue;
            }

            $targetFile = $targetDirectory.DIRECTORY_SEPARATOR.$sourceFile->getFilename();

            if (! File::exists($targetFile) && ! File::copy($sourceFile->getPathname(), $targetFile)) {
                throw new RuntimeException("Unable to provision translation file [{$targetFile}].");
            }
        }
    }
}
