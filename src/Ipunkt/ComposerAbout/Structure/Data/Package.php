<?php
/**
 * mitarbeiterbereich2
 *
 * @author rok
 * @since 15.06.14
 */

namespace Ipunkt\ComposerAbout\Structure\Data;

/**
 * Class Package
 *
 * Package entry within composer.lock
 *
 * @package Ipunkt\ComposerAbout\Structure\Data
 */
class Package
{
	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @return array
	 */
	public function getAuthors()
	{
		return $this->authors;
	}

	/**
	 * @return mixed
	 */
	public function getLicenses()
	{
		return $this->licenses;
	}

	/**
	 * @return mixed
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @return mixed
	 */
	public function getVersion()
	{
		return $this->version;
	}

	/**
	 * package name
	 *
	 * @var string
	 */
	private $name;

	/**
	 * package version
	 *
	 * @var string
	 */
	private $version;

	/**
	 * package type: library or whatever
	 *
	 * @var string
	 */
	private $type;

	/**
	 * all licenses
	 *
	 * @var array
	 */
	private $licenses;

	/**
	 * all authors with name and email
	 *
	 * @var array
	 */
	private $authors;

	/**
	 * package description
	 *
	 * @var string
	 */
	private $description;

	/**
	 * @param \stdClass $json
	 */
	public function __construct(\stdClass $json)
	{
		$this->name = $this->readName($json);
		$this->version = $this->readVersion($json);
		$this->type = $this->readType($json);
		$this->licenses = $this->readLicenses($json);
		$this->authors = $this->readAuthors($json);
		$this->description = $this->readDescription($json);
	}

	/**
	 * @param \stdClass $json
	 * @return string|null
	 */
	private function readName($json)
	{
		return $this->_readStdClassProperty($json, 'name');
	}

	/**
	 * @param \stdClass $json
	 * @return string|null
	 */
	private function readVersion($json)
	{
		return $this->_readStdClassProperty($json, 'version');
	}

	/**
	 * @param \stdClass $json
	 * @return string|null
	 */
	private function readType($json)
	{
		return $this->_readStdClassProperty($json, 'type');
	}

	/**
	 * @param \stdClass $json
	 * @return array
	 */
	private function readLicenses($json)
	{
		$licenses = $this->_readStdClassProperty($json, 'license', []);
		if (empty($licenses))
		{
			return $licenses;
		}

		$resultingLicenses = [];
		foreach ($licenses as $license)
		{
			if (starts_with($license, '(') && ends_with($license, ')'))
			{
				$license = str_replace('OR', 'or', $license);
				$license = strtr($license, array(
					'OR' => 'or',
					'(' => '',
					')' => '',
				));
				$multiLicense = explode(' or ', $license);
				unset($license);

				foreach ($multiLicense as $lic)
				{
					$resultingLicenses[] = trim($lic);
				}
			}
			else
			{
				$resultingLicenses[] = $license;
			}
		}


		return $resultingLicenses;
	}

	/**
	 * @param \stdClass $json
	 * @return string
	 */
	private function readDescription($json)
	{
		return $this->_readStdClassProperty($json, 'description', '');
	}


	/**
	 * @param \stdClass $json
	 * @return array
	 */
	private function readAuthors($json)
	{
		$authorsRaw = $this->_readStdClassProperty($json, 'authors', []);
		$authors = [];
		foreach ($authorsRaw as $stdClass) {
			$name = $this->_readStdClassProperty($stdClass, 'name');
			$email = $this->_readStdClassProperty($stdClass, 'email');

			$authors[] = array(
				'name' => $name,
				'email' => $email,
			);
		}

		return $authors;
	}

	/**
	 * @param \stdClass $class
	 * @param string $property
	 * @param mixed $default
	 * @return mixed
	 */
	private function _readStdClassProperty(\stdClass $class, $property, $default = null)
	{
		return isset($class->{$property}) ? $class->{$property} : $default;
	}
}