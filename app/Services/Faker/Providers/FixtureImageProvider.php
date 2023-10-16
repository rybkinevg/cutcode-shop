<?php

declare(strict_types=1);

namespace App\Services\Faker\Providers;

use Faker\Provider\Base;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

class FixtureImageProvider extends Base
{
    public function fixtureImage(string $dirTo, ?string $dirFrom = null): string
    {
        $dirFrom = $dirFrom ?? $dirTo;

        /** @var FilesystemAdapter $fixtureStorage */
        $fixtureStorage = Storage::disk('tests');

        $files = $fixtureStorage->files('/Fixtures/images/' . $dirFrom);

        if (empty($files)) {
            $message = sprintf('Directory [%s] is empty or does not exists', $dirFrom);

            throw new InvalidArgumentException($message);
        }

        $path = $fixtureStorage->path($files[array_rand($files)]);
        $name = basename($path);

        Storage::put($dirTo . DIRECTORY_SEPARATOR . $name, $path);

        return '/storage/' . $dirTo . DIRECTORY_SEPARATOR . $name;
    }
}
