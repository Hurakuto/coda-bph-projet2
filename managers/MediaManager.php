<?php

class MediaManager extends AbstractManager
{

    public function __construct()
    {
        parent::__construct();
    }

    // public function create(Media $media)
    // {
    //     $query = $this->db->prepare('INSERT INTO media (url, alt) VALUES(:url, :alt)');
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

    public function findOne(int $id): Media
    {
        $query = $this->db->prepare("SELECT * FROM media WHERE id=:id");
        $parameters = [
            "id" => $id
        ];

        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $media = new Media($result['url'], $result['alt'], $result['id']);

        return $media;
    }

    public function findAll(): array
    {
        $query = $this->db->prepare("SELECT * FROM media");
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }
}