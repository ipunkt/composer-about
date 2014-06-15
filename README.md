Retrieve Information from composer.lock
=======================================

Parses composer.lock and returns informations about the used packages

Usage
-----

Mainly developed for Laravel, but can still be used in all other Frameworks or Vanilla PHP applications.

1. Add service provider to app.config

	'Ipunkt\ComposerAbout\ComposerAboutServiceProvider',

2. Use it in your routes.php or Controller action

	/** @var \Ipunkt\ComposerAbout\Structure\ComposerStructure $composerAbout */
	$composerAbout = App::make('composer-about');


API
---

### ComposerStructure::$hash

Hash of the current installed packages.

### ComposerStructure::$packages

A Collection of Package object instances for the packages used.

### ComposerStructure::$devpackages

A Collection of Package object instances for the dev packages used.

### ComposerStructure::licenses()

An array of all unique licenses for all required packages. Perhaps for a summary of used licenses. Can be very useful,
if you want to check, that there is a defined license that you do not want to have.

### Package

For current methods please see Ipunkt\ComposerAbout\Structure\Data\Package.php

### Package::getName()

Returns the name of the package.

### Package::getVersion()

Returns the version of the package.

### Package::getDescription()

Returns the description of the package.

### Package::getAuthors()

Returns an array of alle Authors...each author has 'name' and 'email' set, if possible.

### Package::getLicenses()

Returns the licenses of the package.

### Package::getType()

Returns the type of the package. E.g. library

### Package::getName()

Returns the name of the package.

