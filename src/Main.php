<?php

declare(strict_types=1);

namespace kingofturkey38\performancetests;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener{

	private static self $instance;

	/** @var array<string, Player> */
	private array $map = [];

	protected function onEnable() : void{
		self::$instance = $this;
		$this->getServer()->getCommandMap()->register("performance", new PerformanceTestCommand("performance"));
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	public function onJoin(PlayerJoinEvent $event): void {
		$this->map[$event->getPlayer()->getName()] = $event->getPlayer();
		$this->getServer()->getLogger()->notice("Added {$event->getPlayer()->getName()}");
	}

	public function getPlayer(string $player): ?Player {
		return $this->map[$player] ?? null;
	}

	/**
	 * @return Main
	 */
	public static function getInstance() : Main{
		return self::$instance;
	}

}
