<?php
/**
 * mitarbeiterbereich2
 *
 * @author rok
 * @since 15.06.14
 */

namespace Ipunkt\ComposerAbout\Structure;


use Illuminate\Support\Collection;
use Ipunkt\ComposerAbout\Structure\Data\Package;
use Ipunkt\ComposerAbout\Structure\Parser\HashParser;
use Ipunkt\ComposerAbout\Structure\Parser\PackagesParser;
use Ipunkt\ComposerAbout\Structure\Parser\ParserInterface;

class ComposerStructure {

	/**
	 * json decoded structure
	 *
	 * @var \stdClass
	 */
	private $structure;

	/**
	 * parsers to use
	 *
	 * @var array
	 */
	private $parsers = [];

	/**
	 * version hash
	 *
	 * @var string
	 */
	public $hash;

	/**
	 * packages
	 *
	 * @var Collection
	 */
	public $packages;

	/**
	 * development packages
	 *
	 * @var Collection
	 */
	public $devpackages;

	/**
	 * @param \stdClass $jsonDecoded
	 * @param array $parsers
	 */
	public function __construct(\stdClass $jsonDecoded = null, array $parsers = array())
	{
		$this->parsers = array(
			'hash' => new HashParser(),
			'packages' => new PackagesParser(),
			'devpackages' => new PackagesParser('packages-dev'),
		);

		$this->parsers = array_merge($this->parsers, $parsers);

		if ($jsonDecoded !== null)
			$this->parse($jsonDecoded);
	}

	/**
	 * @param \stdClass $jsonDecoded
	 */
	public function parse(\stdClass $jsonDecoded)
	{
		$this->structure = $jsonDecoded;

		$this->parseStructure($jsonDecoded);
	}

	/**
	 * returns all licenses combined
	 *
	 * @param bool $includeDevelopmentPackages
	 * @return array
	 */
	public function licenses($includeDevelopmentPackages = false)
	{
		$licenses = [];

		/** @var Package $package */
		foreach ($this->packages as $package)
		{
			$packageLicenses = $package->getLicenses();
			foreach ($packageLicenses as $license)
			{
				$licenses[$license] = $license;
			}
		}

		if ($includeDevelopmentPackages)
		{
			/** @var Package $package */
			foreach ($this->devpackages as $package)
			{
				$packageLicenses = $package->getLicenses();
				foreach ($packageLicenses as $license)
				{
					$licenses[$license] = $license;
				}
			}
		}

		return $licenses;
	}

	/**
	 * parses whole structure
	 *
	 * @param \stdClass $jsonDecoded
	 */
	private function parseStructure(\stdClass $jsonDecoded)
	{
		foreach ($this->parsers as $property => $parser)
		{
			if ($parser instanceof ParserInterface)
			{
				$this->{$property} = $parser->parse($jsonDecoded);
			}
		}
	}
}