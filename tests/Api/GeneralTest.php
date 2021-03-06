<?php

/*
 * This file is part of Cachet.
 *
 * (c) Cachet HQ <support@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Tests\Cachet\Api;

use CachetHQ\Tests\Cachet\AbstractTestCase;

class GeneralTest extends AbstractTestCase
{
    public function testGetPing()
    {
        $this->get('/api/v1/ping');
        $this->seeJson(['data' => 'Pong!']);
        $this->assertResponseOk();
        $this->seeHeader('Content-Type', 'application/json');
    }

    public function testErrorPage()
    {
        $this->get('/api/v1/not-found');

        $this->assertResponseStatus(404);
        $this->seeHeader('Content-Type', 'application/json');
        $this->seeJson(['errors' => [[
            'status' => 404,
            'title'  => 'Not Found',
            'detail' => 'The requested resource could not be found but may be available again in the future.',
        ]]]);
    }

    public function testNotAcceptableContentType()
    {
        $this->get('/api/v1/ping', ['HTTP_Accept' => 'text/html']);

        $this->assertResponseStatus(406);
    }
}
