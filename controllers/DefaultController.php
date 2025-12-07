<?php

class DefaultController extends AbstractController
{

    public function home()
    {

        $media_m = new MediaManager();
        $player_m = new PlayerManager();
        $team_m = new TeamManager();
        $game_m = new GameManager();


        // Partie Team à la une
        $id = 1;

        $team = $team_m->findOne($id);

        $team_m->addPlayers($team);

        $team_players = [];
        foreach ($team->getPlayers() as $player) {
            $team_players[] = [
                "name" => mb_strtoupper($player->getNickname(), 'UTF-8'),
                "portrait_url" => $media_m->findOne($player->getPortrait())->getUrl(),
                "portrait_alt" => $media_m->findOne($player->getPortrait())->getAlt()
            ];
        }
        // 

        // Partie Joueurs à la une
        $joueurs = [3, 14, 12];
        $top_players = [];
        foreach ($joueurs as $id_joueur) {
            $joueur = $player_m->findOne($id_joueur);
            $top_players[] = [
                "name" => mb_strtoupper($joueur->getNickname(), "UTF-8"),
                "portrait_url" => $media_m->findOne($joueur->getPortrait())->getUrl(),
                "portrait_alt" => $media_m->findOne($joueur->getPortrait())->getAlt(),
                "team_name" => $team_m->findOne($joueur->getTeam())->getName()
            ];
        }
        //

        // Partie Dernier Match
        $last_game = $game_m->findLast();
        $last_game->setLoser();
        // 



        $this->render(
            '_home',
            [
                'team' => [
                    'name' => $team->getName(),
                    'logo_url' => $media_m->findOne($team->getLogo())->getUrl(),
                    'logo_alt' => $media_m->findOne($team->getLogo())->getAlt(),
                    'players' => $team_players
                ],
                'players' => $top_players,
                'match' => [
                    'name' => mb_strtoupper($last_game->getName(), "UTF-8"),
                    'date' => $last_game->getDate()->format("d/m/Y"),
                    'teams' => [
                        'winner' => [
                            'logo_url' => $media_m->findOne($team_m->findOne($last_game->getWinner())->getLogo())->getUrl(),
                            'logo_alt' => $media_m->findOne($team_m->findOne($last_game->getWinner())->getLogo())->getAlt()
                        ],
                        'loser' => [
                            'logo_url' => $media_m->findOne($team_m->findOne($last_game->getLoser())->getLogo())->getUrl(),
                            'logo_alt' => $media_m->findOne($team_m->findOne($last_game->getLoser())->getLogo())->getAlt()
                        ]
                    ]
                ]
            ]
        );
    }

    public function teams()
    {
        $media_m = new MediaManager();
        $player_m = new PlayerManager();
        $team_m = new TeamManager();
        $game_m = new GameManager();

        // 
        $teams = $team_m->findAll();
        $all_teams = [];
        foreach ($teams as $team) {
            $all_teams[] =
                [
                    "id" => $team['id'],
                    "name" => mb_strtoupper($team['name'], 'UTF-8'),
                    "desc" => $team['description'],
                    'logo_url' => $media_m->findOne($team_m->findOne($team['id'])->getLogo())->getUrl(),
                    'logo_alt' => $media_m->findOne($team_m->findOne($team['id'])->getLogo())->getAlt()
                ];
        }
        // 

        $this->render('_teams', $all_teams);
    }

    public function team()
    {
        $media_m = new MediaManager();
        $player_m = new PlayerManager();
        $team_m = new TeamManager();
        $game_m = new GameManager();

        // 
        $id = $_GET['id'];

        $team = $team_m->findOne($id);
        $team_m->addPlayers($team);

        $players = [];

        foreach ($team->getPlayers() as $player) {
            $players[] = [
                "id" => $player->getId(),
                "name" => mb_strtoupper($player->getNickname(), 'UTF-8'),
                "portrait_url" => $media_m->findOne($player->getPortrait())->getUrl(),
                "portrait_alt" => $media_m->findOne($player->getPortrait())->getAlt()
            ];
        }
        // 

        $this->render(
            '_team',
            [
                "name" => mb_strtoupper($team->getName(), 'UTF-8'),
                "players" => $players
            ]
        );
    }

    public function players()
    {
        $media_m = new MediaManager();
        $player_m = new PlayerManager();
        $team_m = new TeamManager();
        $game_m = new GameManager();

        // 
        $players = $player_m->findAll();

        $all_players = [];
        foreach ($players as $player) {
            $all_players[] = [
                "id" => $player['id'],
                "name" => mb_strtoupper($player['nickname'], 'UTF-8'),
                "portrait_url" => $media_m->findOne($player['portrait'])->getUrl(),
                "portrait_alt" => $media_m->findOne($player['portrait'])->getAlt(),
                "team_name" => mb_strtoupper($team_m->findOne($player['team'])->getName(), 'UTF-8')
            ];
        }
        // 

        $this->render('_players', $all_players);
    }

    public function player()
    {
        $media_m = new MediaManager();
        $player_m = new PlayerManager();
        $team_m = new TeamManager();
        $game_m = new GameManager();

        // 
        $player_id = $_GET['id'];
        $_player = $player_m->findOne($player_id);

        $player_games = [];

        $games = $game_m->findAll();

        $equipe = NULL;
        $var = '';

        foreach ($games as $game) {

            if ($game['team_1'] === $game['winner']) {
                $equipe = 1;
            } else {
                $equipe = 2;
            }

            if ($game['team_1'] === $_player->getTeam()) {
                $player_m->addPerformances($_player, $game['id']);

                if ($equipe === 1) {
                    $var = 'Oui';
                } else {
                    $var = 'Non';
                }

                $stats = $_player->getStats();
                $current_stats = end($stats);

                $player_games[] =
                    [
                        "adverse" => $team_m->findOne($game['team_2'])->getName(),
                        "points" => $current_stats['points'],
                        "assists" => $current_stats['assists'],
                        "win" => $var
                    ];
            } elseif ($game['team_2'] === $_player->getTeam()) {
                $player_m->addPerformances($_player, $game['id']);

                if ($equipe === 1) {
                    $var = 'Non';
                } else {
                    $var = 'Oui';
                }

                $stats = $_player->getStats();
                $current_stats = end($stats);

                $player_games[] =
                    [
                        "adverse" => $team_m->findOne($game['team_1'])->getName(),
                        "points" => $current_stats['points'],
                        "assists" => $current_stats['assists'],
                        "win" => $var
                    ];
            }
        }

        $player_team = $team_m->findOne($_player->getTeam());
        $team_m->addPlayers($player_team);

        $mates = [];

        foreach ($player_team->getPlayers() as $player) {
            $mates[] =
                [
                    "id" => $player->getId(),
                    "name" => mb_strtoupper($player->getNickname(), 'UTF-8'),
                    "portrait_url" => $media_m->findOne($player->getPortrait())->getUrl(),
                    "portrait_alt" => $media_m->findOne($player->getPortrait())->getAlt()
                ];
        }
        // 

        $player_info =
            [
                "id" => $_player->getId(),
                "name" => mb_strtoupper($_player->getNickname(), 'UTF-8'),
                "portrait_url" => $media_m->findOne($_player->getPortrait())->getUrl(),
                "portrait_alt" => $media_m->findOne($_player->getPortrait())->getAlt(),
                "matchs" => $player_games,
                "mates" => $mates
            ];

        $this->render('_player', $player_info);
    }

    public function matchs()
    {

        $media_m = new MediaManager();
        $player_m = new PlayerManager();
        $team_m = new TeamManager();
        $game_m = new GameManager();

        // 
        $games = $game_m->findAll();
        $all_games = [];
        foreach ($games as $game) {
            $game = $game_m->findOne($game['id']);
            $game->setLoser();
            if ($game->getTeam1() === $game->getWinner()) {
                $bool = 'True';
                $bool2 = 'False';
            } else {
                $bool = 'False';
                $bool2 = 'True';
            }
            $all_games[$game->getId()] = [
                "id" => $game->getId(),
                "name" => mb_strtoupper($game->getName(), 'UTF-8'),
                "date" => $game->getDate()->format("d/m/Y"),
                'teams' => [
                    'team1' => [
                        'win' => $bool,
                        'logo_url' => $media_m->findOne($team_m->findOne($game->getTeam1())->getLogo())->getUrl(),
                        'logo_alt' => $media_m->findOne($team_m->findOne($game->getTeam1())->getLogo())->getAlt()
                    ],
                    'team2' => [
                        'win' => $bool2,
                        'logo_url' => $media_m->findOne($team_m->findOne($game->getTeam2())->getLogo())->getUrl(),
                        'logo_alt' => $media_m->findOne($team_m->findOne($game->getTeam2())->getLogo())->getAlt()
                    ]
                ]
            ];

        }
        // 

        $this->render('_matchs', $all_games);
    }

    public function match()
    {
        $media_m = new MediaManager();
        $player_m = new PlayerManager();
        $team_m = new TeamManager();
        $game_m = new GameManager();

        $id = $_GET['id'];

        $game = $game_m->findOne($id);
        $game->setLoser();
        if ($game->getTeam1() === $game->getWinner()) {
            $bool = 'True';
            $bool2 = '';
        } else {
            $bool = '';
            $bool2 = 'True';
        }

        $players = $game_m->findPlayers($game->getId());
        $all_players = [];

        foreach ($players as $player) {
            $player_m->addPerformances($player, $game->getId());
            $all_players[] = [
                'id' => $player->getId(),
                'name' => $player->getNickname(),
                'team' => $team_m->findOne($player->getTeam())->getName(),
                'stats' => $player->getStats()
            ];
        }

        $this->render(
            '_match',
            [
                "id" => $game->getId(),
                "name" => mb_strtoupper($game->getName(), 'UTF-8'),
                "date" => $game->getDate()->format("d/m/Y"),
                'teams' => [
                    'team1' => [
                        'win' => $bool,
                        'logo_url' => $media_m->findOne($team_m->findOne($game->getTeam1())->getLogo())->getUrl(),
                        'logo_alt' => $media_m->findOne($team_m->findOne($game->getTeam1())->getLogo())->getAlt()
                    ],
                    'team2' => [
                        'win' => $bool2,
                        'logo_url' => $media_m->findOne($team_m->findOne($game->getTeam2())->getLogo())->getUrl(),
                        'logo_alt' => $media_m->findOne($team_m->findOne($game->getTeam2())->getLogo())->getAlt()
                    ]
                ],
                "players" => $all_players
            ]
        );
    }

    public function error_404(){
        $this->render('_404', []);
    }
}