<?php

declare(strict_types=1);

use Actions\Api\CalendarAction;
use Actions\EspaceUtilisateur;
use Actions\FacturesNounous;
use Actions\FacturesParents;
use Actions\GardesParents;
use Actions\LoginActions;
use Actions\MesGardesAction;
use Actions\RegisterActions;
use Actions\ValidationGardes;
use App\Application\Renderers\RedirectRenderer;
use Models\Session;
use Models\UserType;
use Slim\App;
use Slim\Http\Response;
use Slim\Http\ServerRequest;
use Slim\Interfaces\RouteCollectorProxyInterface;

return function (App $app)
{
    $app->group('/api', function (RouteCollectorProxyInterface $group)
    {
        $group->get('/calendar', CalendarAction::class);
    });

    $app->map(['GET', 'POST'], '/login', function (ServerRequest $request, Response $response)
    {
        if ($request->getAttribute('user'))
        {
            return $this->get(RedirectRenderer::class)->redirectFor($response, 'home');
        }

        $controller = $this->get(LoginActions::class);

        if ($data = $request->getAttribute('postdata'))
        {
            return $controller->connectUser($request, $response, $data);
        }

        return $controller->display($request, $response);
    })->setName('login');

    $app->map(['GET', 'POST'], '/register', function (ServerRequest $request, $response, $args)
    {
        if ($request->getAttribute('user'))
        {
            return $this->get(RedirectRenderer::class)->redirectFor($response, 'home');
        }

        $controller = $this->get(RegisterActions::class);

        if ($data = $request->getAttribute('postdata'))
        {
            return $controller->createUser($request, $response, $data);
        }

        return $controller->display($request, $response);
    })->setName('register');

    $app->get('/logout', function ($request, $response)
    {
        $request->getAttribute('session')->removeItem('user');

        if ($session = $request->getAttribute('cookies')->readCookie('usersession'))
        {
            $request->getAttribute('cookies')->removeCookie('usersession');

            Session::removeSession($session);
        }

        return $this->get(RedirectRenderer::class)->redirectFor($response, 'home');
    })->setName('logout');

    $app->get('/contacts', function ($request, $response)
    {
        return $this->get('view')->render($response, 'contact');
    })->setName('contact');

    $app->map(['GET', 'POST'], '/espace-utilisateur', function (ServerRequest $request, Response $response)
    {
        if ( ! $request->getAttribute('user'))
        {
            return $this->get(RedirectRenderer::class)->redirectFor($response, 'login');
        }

        $controller = $this->get(EspaceUtilisateur::class);

        if ($data = $request->getAttribute('postdata'))
        {
            $action = $data['action'] ?? '';

            if ('mod_user' === $action)
            {
                return $controller->modifyUser($request, $response, $data);
            }

            if ('mod_pwd' === $action)
            {
                return $controller->modifyPassword($request, $response, $data);
            }

            if ('add_child' === $action)
            {
                return $controller->addChild($request, $response, $data);
            }
        }
        return $controller->display($request, $response);
    })->setName('espace-utilisateur');

    $app->get(
        '/espace-utilisateur/factures[/{slug:.+}]',
        function (ServerRequest $request, Response $response, array $args)
        {
            if ( ! $request->getAttribute('user'))
            {
                return $this->get(RedirectRenderer::class)->redirectFor($response, 'login');
            }

            if (UserType::BABYSITTER === $request->getAttribute('user')->getType())
            {
                $controller = $this->get(FacturesNounous::class);
            } else
            {
                $controller = $this->get(FacturesParents::class);
            }

            return $controller($request, $response, $args);
        }
    )->setName('factures');

    $app->get('/espace-utilisateur/calendar', function (ServerRequest $request, Response $response)
    {
        if ( ! $request->getAttribute('user'))
        {
            return $this->get(RedirectRenderer::class)->redirectFor($response, 'login');
        }
        return $this->get('view')->render($response, 'calendar');
    })->setName('calendar');

    $app->map(
        ['GET', 'POST'],
        '/espace-utilisateur/gardes[/{id:\d+}]',
        function (ServerRequest $request, Response $response, array $args)
        {
            if ( ! $request->getAttribute('user'))
            {
                return $this->get(RedirectRenderer::class)->redirectFor($response, 'login');
            }

            /** @var GardesParents $controller */
            $controller = $this->get(GardesParents::class);

            return $controller->display($request, $response, $args['id'] ?? null);
        }
    )->setName('gardes');

    $app->map(
        ['GET', 'POST'],
        '/espace-utilisateur/mes-gardes[/{id:\d+}]',
        function (ServerRequest $request, Response $response, array $args)
        {
            if ( ! $request->getAttribute('user'))
            {
                return $this->get(RedirectRenderer::class)->redirectFor($response, 'login');
            }

            $controller = $this->get(MesGardesAction::class);

            if ($data = $request->getAttribute('postdata'))
            {
                $action = $data['action'];
                unset($data['action']);

                if ('add_availability' === $action)
                {
                    return $controller->addAvailability($request, $response, $data);
                }

                if ('set_declined' === $action && isset($data['id_disp']))
                {
                    return $controller->setGardeStatus(
                        $request,
                        $response,
                        $args['id'],
                        $data['id_disp'],
                        false
                    );
                }

                if ('set_accepted' === $action && isset($data['id_disp']))
                {
                    return $controller->setGardeStatus(
                        $request,
                        $response,
                        $args['id'],
                        $data['id_disp'],
                        true
                    );
                }
            }

            if ( ! isset($args['id']))
            {
                return $controller->display($request, $response);
            }

            return $controller->displayDisponibilite($request, $response, $args['id']);
        }
    )->setName('mes-gardes');

    $app->map(
        ['GET', 'POST'],
        '/espace-utilisateur/validation-gardes',
        function (ServerRequest $request, Response $response)
        {
            if ( ! $request->getAttribute('user'))
            {
                return $this->get(RedirectRenderer::class)->redirectFor($response, 'login');
            }

            $controller = $this->get(ValidationGardes::class);
            return $controller->display($request, $response);
        }
    )->setName('validation-gardes');

    $app->get('/', function ($request, $response, $args)
    {
        return $this->get('view')->render($response, 'home', $args);
    })->setName('home');
};
