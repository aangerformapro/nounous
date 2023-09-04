<?php

declare(strict_types=1);

use App\Application\Renderers\RedirectRenderer;
use Models\Session;
use Models\User;
use NGSOFT\Facades\Container;
use NGSOFT\Middlewares\CookieMiddleware;
use NGSOFT\Session\Session as SessionMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\App;
use Slim\Http\ServerRequest;

return function (App $app)
{
    $app->add(function (ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        /** @var CookieMiddleware $cookies */
        /** @var SessionMiddleware $session */
        $session = $request->getAttribute('session');
        $cookies = $request->getAttribute('cookies');

        if ( ! $session->getItem('user') && $sessid = $cookies->readCookie('usersession'))
        {
            if ($usersession = Session::loadSession($sessid))
            {
                if ($user = $usersession->getUser())
                {
                    $session->setItem('user', $user->getId());
                } else
                {
                    $cookies->removeCookie('usersession');
                    Session::removeEntry($usersession);
                }
            }
        }

        if ($userId = $session->getItem('user'))
        {
            if ($user = User::findById($userId))
            {
                $request = $request->withAttribute('user', $user);
                Container::set('user', $user);
            } else
            {
                $session->removeItem('user');
            }
        }

        return $next->handle($request);
    });

    // post later
    $app->add(function (ServerRequest $request, RequestHandlerInterface $next) use ($app): ResponseInterface
    {
        /** @var SessionMiddleware $session */
        $session = $request->getAttribute('session');

        if (
            'POST' === $request->getMethod()
            && ! str_contains($request->getHeaderLine('accept'), 'application/json')
        ) {
            $uri         = $request->getUri();
            $destination = $uri->getPath();
            $query       = $request->getQueryParams();

            if ($postdata = $request->getParsedBody())
            {
                $session->setItem('postdata', $postdata);
            } else
            {
                $session->setItem('postdata', []);
            }

            return $this->get(RedirectRenderer::class)->redirect($app->getResponseFactory()->createResponse(), $destination, $query);
        }

        if ($session->hasItem('postdata'))
        {
            $request = $request->withAttribute('postdata', $session->getItem('postdata')->toArray());
            $session->removeItem('postdata');
        }

        return $next->handle($request);
    });
};
