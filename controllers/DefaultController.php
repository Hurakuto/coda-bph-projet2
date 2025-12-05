<?php

class DefaultController extends AbstractController {

    public function home(){
        $this->render('_home', []);
    }

    public function teams(){
        $this->render('_teams', []);
    }

    public function players(){
        $this->render('_players', []);
    }

    public function matchs(){
        $this->render('_matchs', []);
    }
}