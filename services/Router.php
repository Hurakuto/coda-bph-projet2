<?php

class Router {

    public function handleRequest(array $get): void {
        $main_c = new DefaultController();

        if(!empty($get)){
            if(isset($get['route'])){
                if($get['route']==='matchs'){
                    $main_c->matchs();
                }
                
                else if($get['route']==='match'){
                    $main_c->match();
                }

                else if($get['route']==='players'){
                    $main_c->players();
                }
                
                else if($get['route']==='player'){
                    $main_c->player();
                }

                else if($get['route']==='teams'){
                    $main_c->teams();
                }
                
                else if($get['route']==='team'){
                    $main_c->team();
                }
            }

            else{
                $main_c->home();
            }
        }

        else{
            $main_c->home();
        }
    }
}