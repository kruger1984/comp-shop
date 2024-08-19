<?php

namespace Support\Testing;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;

final class FakerImageProvider extends Base
{
    public function fixturesImage(string $fixturesDir, string $storageDir): string
    {
        $storage = Storage::disk('images');

        if(!$storage->exists($storageDir)) {
            $storage->makeDirectory($storageDir);
        }


       $file = $this->generator->file(
           base_path("tests/Fixtures/images/$fixturesDir"),
           Storage::disk('images')->path($storageDir),
           false
       );

       return '/' . trim($storageDir, '/') . '/' . $file;
//       return '/storage/images/' . trim($storageDir, '/') . '/' . $file;
     }

}
