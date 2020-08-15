<?php
 
 # namespace 
namespace shop;

# use's
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI\CustomForm;
use jojoe77777\FormAPI;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;
use onebone\economyapi\EconomyAPI;
use muqsit\invmenu\{InvMenu, InvMenuHandler};
use pocketmine\item\Item;
use pocketmine\item\ItemBlock;

# Main class
class Main extends PluginBase implements Listener
{

    public $config;

    public function onLoad()
    {
        $this->saveResource("config.yml");
        $this->config = new Config($this->getDataFolder() . "config.yml" , Config::YAML);
    }
    # onEnable
    public function onEnable()
    {
		if (!InvMenuHandler::isRegistered()) {
			InvMenuHandler::register($this);
        }
        $this->getLogger()->info("on");
        $this->saveResource("config.yml");
        $this->config = new Config($this->getDataFolder() . "config.yml" , Config::YAML);
    }
    # command
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool
    {
        $this->config = new Config($this->getDataFolder() . "config.yml" , Config::YAML);
        if($cmd->getName() === "rshop"){
            $this->rshop($sender);
            return true;
        }

        if($cmd->getName() === "rshopgui"){
            $this->GUI($sender);
            return true;
        }

        if($cmd->getName() === "rshopui"){
            $this->UI($sender);
            return true;
        }
    }
    # UI
    public function rshop($player)
    {

        $this->config = new Config($this->getDataFolder() . "config.yml" , Config::YAML);
        $form = new SimpleForm(function (Player $player, $data = null) {
            $result = $data;

            if ($result === null) {
                return true;
            }
            switch ($result) {
                case 0:
                    $this->GUI($player);
                        break;
                    case 1:
                    $this->UI($player);
                        break;
                    case 2:
                    $this->info($player);
                       break;
                    case 3:
                        break;
            }
        });
        $form->setTitle("§brshop");
        $form->setContent("rshop command");
        $form->addButton("§bGUI");
        $form->addButton("§bUI");
        $form->addButton("§6Info");
        $form->addButton("§cClose");
        $form->sendToPlayer($player);
        return $form;
    }

    public function info($player)
    {

        $this->config = new Config($this->getDataFolder() . "config.yml" , Config::YAML);
        $form = new SimpleForm(function (Player $player, $data = null) {
            $result = $data;

            if ($result === null) {
                return true;
            }
            switch ($result) {
                case 0:
                        break;
            }
        });
        $form->setTitle("§a[§6INFO§a]");
        $form->setContent("§5The plugin was progammed by §eAleondev");
        $form->addButton("§cClose");
        $form->sendToPlayer($player);
        return $form;
    }

    public function UI($player)
    {

        $this->config = new Config($this->getDataFolder() . "config.yml" , Config::YAML);
        $form = new SimpleForm(function (Player $player, $data = null) {
            $result = $data;

            if ($result === null) {
                return true;
            }
            switch ($result) {
                case 0:
                    $this->rang1($player);
                        break;
                    case 1:
                    $this->rang2($player);
                        break;
                    case 2:
                    $this->rang3($player);
                        break;
                    case 3:
                    $this->rang4($player);
                        break;
                    case 4:
                    $this->rang5($player);
                        break;
                    case 5:
                        break;
            }
        });
        $form->setTitle($this->getConfig()->get("title"));
        $form->setContent($this->getConfig()->get("content"));
        $form->addButton("§6" . $this->getConfig()->get("rank1") . "\n" . $this->getConfig()->get("rank1price") . $this->getConfig()->get("$"));
        $form->addButton("§6" . $this->getConfig()->get("rank2") . "\n" . $this->getConfig()->get("rank2price") . $this->getConfig()->get("$"));
        $form->addButton("§6" . $this->getConfig()->get("rank3") . "\n" . $this->getConfig()->get("rank3price") . $this->getConfig()->get("$"));
        $form->addButton("§6" . $this->getConfig()->get("rank4") . "\n" . $this->getConfig()->get("rank4price") . $this->getConfig()->get("$"));
        $form->addButton("§6" . $this->getConfig()->get("rank5") . "\n" . $this->getConfig()->get("rank5price") . $this->getConfig()->get("$"));
        $form->addButton($this->getConfig()->get("button"));
        $form->sendToPlayer($player);
        return $form;
    }
    # invmenu
    public function GUI($player)
	{
        $config = new Config($this->getDataFolder() . "config.yml" , Config::YAML);
		$menu = InvMenu::create(InvMenu::TYPE_HOPPER);
		$menu->setName("§bRankShop");
		$menu->readonly();

		$inv = $menu->getInventory();
		$menu->setListener([$this, "GUIListener"]);
		$menu->send($player);
        $item1 = Item::get(299, 0, 1)->setCustomName("§6" . $this->getConfig()->get("rank1") . "\n" . $this->getConfig()->get("rank1price") . $this->getConfig()->get("$"));
        $item2 = Item::get(303, 0, 1)->setCustomName("§6" . $this->getConfig()->get("rank2") . "\n" . $this->getConfig()->get("rank2price") . $this->getConfig()->get("$"));
        $item3 = Item::get(307, 0, 1)->setCustomName("§6" . $this->getConfig()->get("rank3") . "\n" . $this->getConfig()->get("rank3price") . $this->getConfig()->get("$"));
        $item4 = Item::get(315, 0, 1)->setCustomName("§6" . $this->getConfig()->get("rank4") . "\n" . $this->getConfig()->get("rank4price") . $this->getConfig()->get("$"));
        $item5 = Item::get(311, 0, 1)->setCustomName("§6" . $this->getConfig()->get("rank5") . "\n" . $this->getConfig()->get("rank5price") . $this->getConfig()->get("$"));


		$inv->setItem(0, $item1);
		$inv->setItem(1, $item2);
        $inv->setItem(2, $item3);
        $inv->setItem(3, $item4);
        $inv->setItem(4, $item5);

    }
    # invmenu listener
    public function GUIListener(Player $player, Item $itemClicked)
	{

		if ($itemClicked->getId() == 299) {
            $this->rang1($player);
			return true;
		}

		if ($itemClicked->getId() == 303){
            $this->rang2($player);

			return true;
		}

		if ($itemClicked->getId() == 307) {
            $this->rang3($player);
			return true;
        }
        
        if ($itemClicked->getId() == 315){
            $this->rang4($player);
        }
    }
    # api
        public function rang1($player)
        {
            $this->config = new Config($this->getDataFolder() . "config.yml" , Config::YAML);
            $money = EconomyAPI::getInstance()->myMoney($player);
            if ($money >= $this->getConfig()->get("rank1price")){
                EconomyAPI::getInstance()->reduceMoney($player, $this->getConfig()->get("rank1price"));
                $purePerms = $this->getServer()->getPluginManager()->getPlugin("PurePerms");
                $group = $purePerms->getGroup($this->getConfig()->get("rank1"));
                $purePerms->setGroup($player, $group);
                $player->sendMessage($this->getConfig()->get("prefix") . $this->getConfig()->get("buy"));
            } else {
                $player->sendMessage($this->getConfig()->get("prefix") . $this->getConfig()->get("nomoney"));
            }
        }

        public function rang2($player)
        {
            $this->config = new Config($this->getDataFolder() . "config.yml" , Config::YAML);
            $money = EconomyAPI::getInstance()->myMoney($player);
            if ($money >= $this->getConfig()->get("rank2price")){
                EconomyAPI::getInstance()->reduceMoney($player, $this->getConfig()->get("rank2price"));
                $purePerms = $this->getServer()->getPluginManager()->getPlugin("PurePerms");
                $group = $purePerms->getGroup($this->getConfig()->get("rank2"));
                $purePerms->setGroup($player, $group);
                $player->sendMessage($this->getConfig()->get("prefix") . $this->getConfig()->get("buy"));
            } else {
                $player->sendMessage($this->getConfig()->get("prefix") . $this->getConfig()->get("nomoney"));
            }
        }

        public function rang3($player)
        {
            $this->config = new Config($this->getDataFolder() . "config.yml" , Config::YAML);
            $money = EconomyAPI::getInstance()->myMoney($player);
            if ($money >= $this->getConfig()->get("rank3price")){
                EconomyAPI::getInstance()->reduceMoney($player, $this->getConfig()->get("rank3price"));
                $purePerms = $this->getServer()->getPluginManager()->getPlugin("PurePerms");
                $group = $purePerms->getGroup($this->getConfig()->get("rank3"));
                $purePerms->setGroup($player, $group);
                $player->sendMessage($this->getConfig()->get("prefix") . $this->getConfig()->get("buy"));
            } else {
                $player->sendMessage($this->getConfig()->get("prefix") . $this->getConfig()->get("nomoney"));
            }
        }

        public function rang4($player)
        {
            $this->config = new Config($this->getDataFolder() . "config.yml" , Config::YAML);
            $money = EconomyAPI::getInstance()->myMoney($player);
            if ($money >= $this->getConfig()->get("rank4price")){
                EconomyAPI::getInstance()->reduceMoney($player, $this->getConfig()->get("rank4price"));
                $purePerms = $this->getServer()->getPluginManager()->getPlugin("PurePerms");
                $group = $purePerms->getGroup($this->getConfig()->get("rank4"));
                $purePerms->setGroup($player, $group);
                $player->sendMessage($this->getConfig()->get("prefix") . $this->getConfig()->get("buy"));
            } else {
                $player->sendMessage($this->getConfig()->get("prefix") . $this->getConfig()->get("nomoney"));
            }
        }

        public function rang5($player)
        {
            $this->config = new Config($this->getDataFolder() . "config.yml" , Config::YAML);
            $money = EconomyAPI::getInstance()->myMoney($player);
            if ($money >= $this->getConfig()->get("rank5price")){
                EconomyAPI::getInstance()->reduceMoney($player, $this->getConfig()->get("rank5price"));
                $purePerms = $this->getServer()->getPluginManager()->getPlugin("PurePerms");
                $group = $purePerms->getGroup($this->getConfig()->get("rank5"));
                $purePerms->setGroup($player, $group);
                $player->sendMessage($this->getConfig()->get("prefix") . $this->getConfig()->get("buy"));
            } else {
                $player->sendMessage($this->getConfig()->get("prefix") . $this->getConfig()->get("nomoney"));
            }
        }
    }