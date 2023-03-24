<?php

declare(strict_types=1);

/**
 * @copyright Copyright (c) 2020 Joas Schilling <coding@schilljs.com>
 *
 * @author Joas Schilling <coding@schilljs.com>
 * @author Sandro Mesterheide <sandro.mesterheide@extern.publicplan.de>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */
namespace OCA\VO_Federation\Listeners;

use OCA\VO_Federation\Backend\GroupBackend;
use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;
use OCP\Group\Events\UserRemovedEvent;
use OCA\VO_Federation\FederatedGroupShareProvider;

/**
 * @template-implements IEventListener<UserRemovedEvent>
 */
class UserRemovedListener implements IEventListener {
	protected FederatedGroupShareProvider  $federatedGroupShareProvider;
	protected GroupBackend $voGroupBackend;

	public function __construct(FederatedGroupShareProvider $federatedGroupShareProvider,
		GroupBackend $voGroupBackend) {
		$this->federatedGroupShareProvider = $federatedGroupShareProvider;
		$this->voGroupBackend = $voGroupBackend;
	}

	public function handle(Event $event): void {
		if (!$event instanceof UserRemovedEvent) {
			return;
		}

		$uid = $event->getUser()->getUID();
		$gid = $event->getGroup()->getGID();

		if (!$this->voGroupBackend->groupExists($gid)) {
			return;
		}

		$this->federatedGroupShareProvider->userDeletedFromGroup($uid, $gid);

		if (empty($event->getGroup()->getUsers())) {
			$event->getGroup()->delete();
		}
	}
}
