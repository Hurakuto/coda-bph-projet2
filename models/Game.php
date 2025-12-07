<?php

class Game
{

    private int $loser;

    public function __construct(private string $name, private DateTime $date, private int $team_1, private int $team_2, private int $winner, private int $id)
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getWinner(): int
    {
        return $this->winner;
    }

    public function setWinner($winner)
    {
        $this->winner = $winner;
    }

    public function getLoser(): int
    {
        return $this->loser;
    }

    public function setLoser()
    {

        if ($this->winner !== $this->team_1) {
            $this->loser = $this->team_1;
        } else {
            $this->loser = $this->team_2;
        }
    }

    public function getTeam1(): int
    {
        return $this->team_1;
    }

    public function setTeam1($team)
    {
        $this->team_1 = $team;
    }

    public function getTeam2(): int
    {
        return $this->team_2;
    }

    public function setTeam2($team)
    {
        $this->team_2 = $team;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }
}