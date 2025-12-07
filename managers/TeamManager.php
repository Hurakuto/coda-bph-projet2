<?php

class TeamManager extends AbstractManager
{

    public function __construct()
    {
        parent::__construct();
    }

    // public function create(Team $team)
    // {
    //     $query = $this->db->prepare('INSERT INTO teams (name, description, logo) VALUES(:name, :desc, :logo)');
    //     $parameters = [
    //         'name' => $team->getName(),
    //         'desc' => $team->getDescription(),
    //         'logo' => $team->getLogo()
    //     ];
    //     $query->execute($parameters);
    // }

    // public function update(Team $team) : Team {
    //     $query = $this->db->prepare("UPDATE teams SET name=:name, description=:desc, logo=:logo WHERE id=:id");
    //     $parameters = [
    //         'id' => $team->getId(),
    //         'name' => $team->getName(),
    //         'desc' => $team->getDescription(),
    //         'logo' => $team->getLogo()
    //     ];

    //     $query->execute($parameters);

    //     $team = new Team($team->getName(), $team->getDescription(), $team->getLogo(), $team->getId());

    //     return $team;

    // }

    // public function delete(Team $team) : void {
    //     $query = $this->db->prepare("DELETE FROM teams WHERE id=:id");
    //     $parameters = [
    //         "id" => $team->getId()
    //     ];

    //     $query->execute($parameters);
    // }

    public function addPlayers(Team $team)
    {
        $query = $this->db->prepare("SELECT players.id, players.nickname, players.bio, players.portrait, players.team FROM teams JOIN players ON teams.id = players.team WHERE teams.id=:id");
        $parameters = [
            "id" => $team->getId()
        ];

        $query->execute($parameters);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $player) {
            $team->addPlayer(new Player($player['nickname'], $player['bio'], $player['portrait'], $player['team'], $player['id']));
        }
    }

    public function findOne(int $id): Team
    {
        $query = $this->db->prepare("SELECT * FROM teams WHERE id=:id");
        $parameters = [
            "id" => $id
        ];

        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $team = new Team($result['name'], $result['description'], $result['logo'], $result['id']);

        return $team;
    }

    public function findAll(): array
    {
        $query = $this->db->prepare("SELECT * FROM teams ORDER BY name ASC");
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }
}