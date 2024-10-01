<?php

declare(strict_types=1);

namespace Support\Trait\Models;

use Illuminate\Support\Facades\File;

trait HasThumbnail
{
    abstract protected function thumbnailDir(): string;
    public function makeThumbnail(string $size, string $method = 'resize'): string
    {

//        $thumbnailPath = $this->thumbnailDir() . '/' . $size . '/' . File::basename($this->{$this->thumbnailColumn()});
//
//        if (File::exists(public_path($thumbnailPath))) {
//            return asset($thumbnailPath);
//        }

        return route('thumbnail', [
            'size'   => $size,
            'dir'    => $this->thumbnailDir(),
            'method' => $method,
            'file'   => File::basename($this->{$this->thumbnailColumn()})
        ]);
    }

    protected function thumbnailColumn(): string
    {
        return 'thumbnail';
    }
}
