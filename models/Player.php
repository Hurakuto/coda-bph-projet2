<?php

class Player {

    

    public function __construct(private string $nickname, private string $bio, private int $portrait, private int $team, private ?int $id=NULL){}

    public function getNickname(){
        return $this->nickname;
    }

    public function setNickname($name){
        $this->nickname = $name;
    }

    public function getBio(){
        return $this->bio;
    }

    public function setBio($bio){
        $this->bio = $bio;
    }

    public function getPortrait(){
        return $this->portrait;
    }

    public function setPortrait($portrait){
        $this->portrait = $portrait;
    }

    public function getTeam(){
        return $this->team;
    }

    public function setTeam($team){
        $this->team = $team;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }
}