<?php
/**
 * mitarbeiterbereich2
 *
 * @author rok
 * @since 15.06.14
 */

namespace Ipunkt\ComposerAbout;


use Ipunkt\ComposerAbout\Structure\ComposerStructure;

class ComposerLockFileReader {

	/**
	 * full path to composer lock file
	 *
	 * @var string
	 */
	private $composerLockFile;

	/**
	 * @param string $composerLockFile
	 */
	public function __construct($composerLockFile)
	{
		$this->composerLockFile = $composerLockFile;
	}

	/**
	 * @return ComposerStructure
	 */
	public function read()
	{
		return new ComposerStructure(json_decode(file_get_contents($this->composerLockFile)));
	}
}