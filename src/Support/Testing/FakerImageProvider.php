<?php

namespace Support\Testing;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;

final class FakerImageProvider extends Base
{
    public function fixturesImage(string $fixturesDir, string $storageDir): string
    {
//        $storage = Storage::disk('images');
//
//        if(!$storage->exists($storageDir)) {
//            $storage->makeDirectory($storageDir);
//        }

       if(!Storage::exists($storageDir)){
           Storage::makeDirectory($storageDir);
       }

       $file = $this->generator->file(
           base_path("tests/Fixtures/images/$fixturesDir"),
           Storage::path($storageDir),
           false
       );

//       return '/storage/' . trim($storageDir, '/') . '/' . $file;
       return '/storage/images' . trim($storageDir, '/') . '/' . $file;
     }

}
