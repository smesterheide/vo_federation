<?php
/**
 * Nextcloud - VO Federation
 *
 *
 * @author Julien Veyssier <eneiluj@posteo.net>
 * @author Sandro Mesterheide <sandro.mesterheide@extern.publicplan.de>
 * @copyright Julien Veyssier 2020
 */

namespace OCA\VO_Federation\AppInfo;

use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;

/**
 * Class Application
 *
 * @package OCA\VO_Federation\AppInfo
 */
class Application extends App implements IBootstrap {
	public const APP_ID = 'vo_federation';
	/**
	 * Constructor
	 *
	 * @param array $urlParams
	 */
	public function __construct(array $urlParams = []) {
		parent::__construct(self::APP_ID, $urlParams);
	}

	public function register(IRegistrationContext $context): void {
		// Register the composer autoloader for packages shipped by this app, if applicable
		include_once __DIR__ . '/../../vendor/autoload.php';
	}

	public function boot(IBootContext $context): void {
	}
}
