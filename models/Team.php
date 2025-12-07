<?php

class Team
{

    private array $players = [];

    public function __construct(private string $name, private string $description, private int $logo, private int $id)
    {
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getLogo()
    {
        return $this->logo;
    }

    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getPlayers(): array
    {
        return $this->players;
    }

    public function setPlayers(array $players)
    {
        $this->players = $players;
    }

    public function addPlayer(Player $player)
    {
        $this->players[] = $player;
    }

    public function removePlayer(Player $player_to_remove)
    {
        foreach ($this->players as $player) {
            if ($player->getId() === $player_to_remove->getId()) {
                unset($this->players[$player]);
            }
        }
    }
}