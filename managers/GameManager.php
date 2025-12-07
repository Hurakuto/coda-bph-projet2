<?php

class GameManager extends AbstractManager
{

    public function __construct()
    {
        parent::__construct();
    }

    // public function create(Game $game)
    // {
    //     $query = $this->db->prepare('INSERT INTO games (url, alt) VALUES(:url, :alt)');
    //     $parameters = [
    //         'url' => $media->getUrl(),
    //         'alt' => $media->getAlt()
    //     ];
    //     $query->execute($parameters);
    // }

    // public function update(Media $media) : Media {
    //     $query = $this->db->prepare("UPDATE media SET url=:url, alt=:alt WHERE id=:id");
    //     $parameters = [
    //         'id' => $media->getId(),
    //         'url' => $media->getUrl(),
    //         'alt' => $media->getAlt()
    //     ];

    //     $query->execute($parameters);

    //     $media = new Media($media->getUrl(), $media->getAlr(), $media->getId());

    //     return $media;

    // }

    // public function delete(Media $Media) : void {
    //     $query = $this->db->prepare("DELETE FROM media WHERE id=:id");
    //     $parameters = [
    //         "id" => $media->getId()
    //     ];

    //     $query->execute($parameters);
    // }

    public function findPlayers(int $id)
    {
        $query = $this->db->prepare("SELECT players.id as player_id, players.nickname, players.bio, players.portrait, players.team FROM teams JOIN players ON players.team = teams.id JOIN player_performance ON player_performance.player = players.id JOIN games ON player_performance.game = games.id WHERE games.id=:id ORDER BY teams.name, players.nickname ASC");
        $parameters = [
            "id" => $id
        ];

        $query->execute($parameters);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        $players = [];
        foreach ($results as $result) {
            $players[] = new Player($result['nickname'], $result['bio'], $result['portrait'], $result['team'], $result['player_id']);
        }

        return $players;
    }

    public function findOne(int $id): Game
    {
        $query = $this->db->prepare("SELECT * FROM games WHERE id=:id");
        $parameters = [
            "id" => $id
        ];

        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $game = new Game($result['name'], DateTime::createFromFormat('Y-m-d H:i:s', $result["date"]), $result['team_1'], $result['team_2'], $result['winner'], $result['id']);

        return $game;
    }

    public function findAll(): array
    {
        $query = $this->db->prepare("SELECT * FROM games ORDER BY id DESC");
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }

    public function findLast(): Game
    {
        $query = $this->db->prepare("SELECT * FROM games ORDER BY id DESC LIMIT 1");
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $game = new Game($result['name'], DateTime::createFromFormat('Y-m-d H:i:s', $result["date"]), $result['team_1'], $result['team_2'], $result['winner'], $result['id']);

        return $game;
    }
}