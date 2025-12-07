<?php

class Router
{

    public function handleRequest(array $get): void
    {
        $main_c = new DefaultController();

        if (!empty($get)) {
            if (isset($get['route'])) {
                if ($get['route'] === 'matchs') {
                    $main_c->matchs();
                } elseif ($get['route'] === 'match') {
                    if (isset($get['id'])) {
                        $main_c->match();
                    } else {
                        $main_c->error_404();
                    }
                } elseif ($get['route'] === 'players') {
                    $main_c->players();
                } elseif ($get['route'] === 'player') {
                    if (isset($get['id'])) {
                        $main_c->player();
                    } else {
                        $main_c->error_404();
                    }
                } elseif ($get['route'] === 'teams') {
                    $main_c->teams();
                } elseif ($get['route'] === 'team') {
                    if (isset($get['id'])) {
                        $main_c->team();
                    } else {
                        $main_c->error_404();
                    }
                } else {
                    $main_c->error_404();
                }
            } else {
                $main_c->home();
            }
        } else {
            $main_c->home();
        }
    }
}