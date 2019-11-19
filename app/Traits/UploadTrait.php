<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * Class UploadTrait
 * Класс предназначен для контроллеров, что бы загружать изображения
 * @package App\Traits
 */
trait UploadTrait
{
	public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
	{
		$name = !is_null($filename) ? $filename : Str::random(25);

		$file = $uploadedFile->storeAs($folder, $name . '.' . $uploadedFile->getClientOriginalExtension(), $disk);

		return $file;
	}
}
