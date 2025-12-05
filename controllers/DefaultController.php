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
        foreach($team->getPlayers() as $player){
            $team_players[] = [
                "name" => $player->getNickname(),
                "portrait_url" => $media_m->findOne($player->getPortrait())->getUrl(),
                "portrait_alt" => $media_m->findOne($player->getPortrait())->getAlt()
            ];
        }
        // 

        // Partie Joueurs à la une
        $joueurs = [3, 14, 12];
        $top_players = [];
        foreach($joueurs as $id_joueur){
            $joueur = $player_m->findOne($id_joueur);
            $top_players[] = [
                "name" => $joueur->getNickname(),
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
                    'name' => $last_game->getName(),
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
        $this->render('_teams', []);
    }

    public function players()
    {
        $this->render('_players', []);
    }

    public function matchs()
    {
        $this->render('_matchs', []);
    }
}