<?php
/**
 * mitarbeiterbereich2
 *
 * @author rok
 * @since 15.06.14
 */

namespace Ipunkt\ComposerAbout\Structure\Parser;


interface ParserInterface {

	/**
	 * parses the whole class and returns necessary value
	 *
	 * @param \stdClass $json
	 * @return mixed
	 */
	public function parse(\stdClass $json);
}