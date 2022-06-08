<?php
declare(strict_types=1);
/**
 * @name ExToastRequest
 * @main net\mydeacy\ExToastRequest
 * @version 0.0.1
 * @api 4.0.0
 * @author MyDeacy
 */

namespace net\mydeacy {

	use pocketmine\event\Listener;
	use pocketmine\event\player\PlayerJoinEvent;
	use pocketmine\network\mcpe\protocol\ToastRequestPacket;
	use pocketmine\plugin\PluginBase;
	use pocketmine\scheduler\ClosureTask;
	use pocketmine\scheduler\TaskScheduler;

	class ExToastRequest extends PluginBase implements Listener {

		public function onEnable() :void {
			$this->getServer()->getPluginManager()->registerEvents(
				new class($this->getScheduler()) implements Listener {

					public function __construct(private TaskScheduler $scheduler) {
					}

					function onJoin(PlayerJoinEvent $event) {
						$player = $event->getPlayer();
						$this->scheduler->scheduleDelayedTask(
							new ClosureTask(function() use ($player) {
								$packet = ToastRequestPacket::create("Title!", "body!!");
								$player->getNetworkSession()->sendDataPacket($packet);
							}
							), 100);
					}
				}, $this);
		}
	}
}
