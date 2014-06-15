<?php
/**
 * mitarbeiterbereich2
 *
 * @author rok
 * @since 15.06.14
 */

namespace Ipunkt\ComposerAbout\Structure\Parser;


class HashParser implements ParserInterface {

	/**
	 * @param \stdClass $json
	 * @return null|string
	 */
	public function parse(\stdClass $json)
	{
		return isset($json->hash) ? $json->hash : null;
	}
}