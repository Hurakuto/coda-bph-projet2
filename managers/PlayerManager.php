<?php

class PlayerManager extends AbstractManager
{

    public function __construct()
    {
        parent::__construct();
    }

    // public function create(Player $player)
    // {
    //     $query = $this->db->prepare('INSERT INTO players (nickname, bio, portrait, team) VALUES(:nickname, :bio, :portrait, :team)');
    //     $parameters = [
    //         'nickname' => $player->getNickname(),
    //         'bio' => $player->getBio(),
    //         'portrait' => $player->getPortrait(),
    //         'team' => $player->getTeam()
    //     ];
    //     $query->execute($parameters);
    // }

    // public function update(Player $player) : Player {
    //     $query = $this->db->prepare("UPDATE players SET nickname=:nickname, bio=:bio, portrait=:portrait, team=:team WHERE id=:id");
    //     $parameters = [
    //         'id' => $player->getId(),
    //         'nickname' => $player->getNickname(),
    //         'bio' => $player->getBio(),
    //         'portrait' => $player->getPortrait(),
    //         'team' => $player->getTeam()
    //     ];

    //     $query->execute($parameters);

    //     $player = new Player($player->getNickname(), $player->getBio(), $player->getPortrait(), $player->getTeam(), $player->getId());

    //     return $player;

    // }

    // public function delete(player $player) : void {
    //     $query = $this->db->prepare("DELETE FROM players WHERE id=:id");
    //     $parameters = [
    //         "id" => $player->getId()
    //     ];

    //     $query->execute($parameters);
    // }

    public function addPerformances(Player $player, int $id_game)
    {
        $query = $this->db->prepare("SELECT game, points, assists FROM player_performance JOIN players ON player_performance.player = players.id WHERE players.id=:id AND player_performance.game=:id_game");
        $parameters = [
            "id" => $player->getId(),
            "id_game" => $id_game
        ];

        $query->execute($parameters);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $result) {
            $player->addStats(['game' => $result['game'], 'points' => $result['points'], 'assists' => $result['assists']]);
        }
    }

    public function findOne(int $id): Player
    {
        $query = $this->db->prepare("SELECT * FROM players WHERE id=:id");
        $parameters = [
            "id" => $id
        ];

        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $player = new Player($result['nickname'], $result['bio'], $result['portrait'], $result['team'], $result['id']);

        return $player;
    }

    public function findAll(): array
    {
        $query = $this->db->prepare("SELECT * FROM players ORDER BY nickname ASC");
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }
}