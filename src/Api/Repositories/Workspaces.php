<?php

declare(strict_types=1);

/*
 * This file is part of Bitbucket API Client.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bitbucket\Api\Repositories;

use Bitbucket\Api\Repositories\Workspaces\Repositories;

/**
 * The users api class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class Workspaces extends AbstractRepositoriesApi
{
    /**
     * @param string $repo
     *
     * @return \Bitbucket\Api\Repositories\Workspaces\Repositories
     */
    public function repositories(string $repo)
    {
        return new Repositories($this->getHttpClient(), $this->username, $repo);
    }

    /**
     * @param string $repo
     * @param $scm
     * @param $project_key
     * @param $is_private
     *
     * @return array
     *
     * @throws \Http\Client\Exception
     */
    public function createRepository(string $repo, $scm, $project_key, $is_private)
    {
        $params = [
            'scm' => $scm,
            'project' => (object)[
                'key' => $project_key
            ],
            'is_private' => $is_private
        ];

        $path = $this->buildRepositoriesPath($repo).static::URI_SEPARATOR;

        return $this->post($path, $params);
    }

    /**
     * @param string $repo
     * @param array $params
     * @return array
     * @throws \Http\Client\Exception
     */
    public function showRepositories(string $repo, array $params = [])
    {
        $path = $this->buildRepositoriesPath($repo);

        return $this->get($path, $params);
    }

    /**
     * @param string ...$parts
     * @return string
     */
    protected function buildRepositoriesPath(string ...$parts)
    {
        return static::buildPath('repositories', $this->username, ...$parts);
    }
}