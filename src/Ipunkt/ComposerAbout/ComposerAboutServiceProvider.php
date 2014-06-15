<?php namespace Ipunkt\ComposerAbout;

use Illuminate\Support\ServiceProvider;

class ComposerAboutServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('ipunkt/composer-about');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('composer-about', function () {
			$reader = new ComposerLockFileReader(realpath(app_path('../composer.lock')));

			//	return an instance
			return $reader->read();
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
