<?php
/**
 * mitarbeiterbereich2
 *
 * @author rok
 * @since 15.06.14
 */

namespace Ipunkt\ComposerAbout\Structure\Parser;


use Illuminate\Support\Collection;
use Ipunkt\ComposerAbout\Structure\Data\Package;

/**
 * Class PackagesParser
 *
 * packages section parser
 *
 * @package Ipunkt\ComposerAbout\Structure\Parser
 */
class PackagesParser implements ParserInterface {

	/**
	 * section name within structure
	 *
	 * @var string
	 */
	private $section = 'packages';

	/**
	 * @param string|null $section
	 */
	public function __construct($section = null)
	{
		if (!empty($section))
			$this->section = $section;
	}

	/**
	 * @param \stdClass $json
	 * @return Collection
	 */
	public function parse(\stdClass $json)
	{
		if (!isset($json->{$this->section}) || empty($json->{$this->section}))
			return new Collection([]);

		$packagesRaw = $json->{$this->section};
		$packages = [];

		foreach ($packagesRaw as $stdClass)
		{
			$packages[] = new Package($stdClass);
		}

		return new Collection($packages);
	}
}