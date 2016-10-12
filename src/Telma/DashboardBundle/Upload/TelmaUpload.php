<?php

namespace Telma\DashboardBundle\Upload; 

use Symfony\Component\HttpFoundation\File\UploadedFile;


class TelmaUpload
{
	private $targetDir;

	public function __construct($targetDir)
	{
		$this->targetDir = $targetDir;
	}

	public function upload(UploadedFile $file)
	{
		$fileName = md5(uniqid()).'.'.$file->guessExtension();

		$file->move($this->targetDir, $fileName);

		return $fileName;

	}
}
