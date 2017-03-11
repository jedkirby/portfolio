<?php

namespace App\Domain\Project;

use App\Domain\Project\Entity\Post\AdminPanel;
use App\Domain\Project\Entity\Post\AMElectrical;
use App\Domain\Project\Entity\Post\BlitzGames;
use App\Domain\Project\Entity\Post\BlitzGamesStudios;
use App\Domain\Project\Entity\Post\BlitzTech;
use App\Domain\Project\Entity\Post\CocaCola;
use App\Domain\Project\Entity\Post\PhpWarwickshire;
use App\Domain\Project\Entity\Post\ShrekAlarm;
use App\Domain\Project\Entity\Post\UmbersladeAdventure;
use App\Domain\Project\Entity\Post\VictoriaJeffs;
use App\Domain\Project\Entity\Post\Vuven;
use App\Domain\Project\Entity\Post\WellForgedFilms;
use App\Domain\Project\Entity\PostInterface;
use App\Domain\Project\Exception\PostNotFoundException;

class ProjectManager
{
    /**
     * @var array
     */
    private $posts = [
        'victoria-jeffs' => VictoriaJeffs::class,
        'php-warwickshire' => PhpWarwickshire::class,
        'a-m-electrical' => AMElectrical::class,
        'admin-panel' => AdminPanel::class,
        'shrek-alarm' => ShrekAlarm::class,
        'blitz-games' => BlitzGames::class,
        'vuven' => Vuven::class,
        'blitz-tech' => BlitzTech::class,
        'blitz-games-studios' => BlitzGamesStudios::class,
        'umberslade-adventure' => UmbersladeAdventure::class,
        'coca-cola' => CocaCola::class,
        'well-forged-films' => WellForgedFilms::class,
    ];

    /**
     * @param int|bool $limit
     *
     * @return array
     */
    public function getPosts($limit = false)
    {
        $posts = [];
        foreach ($this->posts as $id => $post) {
            $posts[$id] = new $post();
        }

        return $limit ? array_slice($posts, 0, $limit) : $posts;
    }

    /**
     * @return int
     */
    public function getPostsCount()
    {
        return count($this->posts);
    }

    /**
     * @param string $id
     *
     * @throws PostNotFoundException
     *
     * @return PostInterface
     */
    public function getPost($id)
    {
        if (!array_key_exists($id, $this->posts)) {
            throw new PostNotFoundException();
        }

        return new $this->posts[$id]();
    }
}
