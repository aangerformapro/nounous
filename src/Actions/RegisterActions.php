<?php

namespace Actions;

use App\Application\Validation\ValidationException;
use Models\Gender;
use Models\User;
use Models\UserType;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

use function NGSOFT\Tools\some;

class RegisterActions extends BaseAction
{
    public function display(ServerRequest $request, Response $response): ResponseInterface
    {
        return $this->phpRenderer->render($response, 'register', ['pagetitle' => 'Créer un compte']);
    }

    public function createUser(ServerRequest $request, Response $response, array $params): ResponseInterface
    {
        try
        {
            $data = $this->validateUser($params);

            if (User::createUser($data))
            {
                return $this->redirectRenderer->redirectFor($response, 'home');
            }

            return $this->phpRenderer->render($response, 'register', [
                'errors'    => ['user'],
                'pagetitle' => 'Créer un compte',
            ]);
        } catch (ValidationException $error)
        {
            return $this->phpRenderer->render($response, 'register', [
                'errors'    => $error->getErrors(),
                'pagetitle' => 'Créer un compte',
            ]);
        }
    }

    protected function validateUser(array $params): array
    {
        $errors = $result = [];

        if ( ! filter_var($params['email'] ?? '', FILTER_VALIDATE_EMAIL))
        {
            $errors[] = 'email';
        }

        if (empty($params['type']) || ! some(fn ($case) => $case->value === $params['type'], UserType::cases()))
        {
            $errors[] = 'type';
        }

        if (empty($params['nom']))
        {
            $errors[] = 'nom';
        }

        if (empty($params['prenom']))
        {
            $errors[] = 'prenom';
        }

        if (empty($params['address']))
        {
            $errors[] = 'address';
        }

        if ( ! isset($params['zip']) || ! preg_match('#^\d{5}$#', $params['zip']))
        {
            $errors[] = 'zip';
        }

        if (empty($params['city']))
        {
            $errors[] = 'city';
        }

        if ( ! isset($params['phone']) || ! preg_match('#^0[1-7]\d{8}$#', $params['phone']))
        {
            $errors[] = 'phone';
        }

        if ( ! isset($params['gender']) || ! some(fn ($case) => $case->value === $params['gender'], Gender::cases()))
        {
            $errors[] = 'gender';
        }

        if ( ! isset($params['password']) || ! isSecurePassword($params['password']))
        {
            $errors[] = 'password';

            $params['password'] ??= '';
        }

        if ( ! isset($params['confirmpassword']) || $params['confirmpassword'] !== $params['password'])
        {
            $errors[] = 'confirmpassword';
        }

        if (count($errors) > 0)
        {
            throw new ValidationException(
                'Not all fields are corrects',
                $errors
            );
        }

        foreach (
            [
                'email',
                'type',
                'nom',
                'prenom',
                'address',
                'zip',
                'city',
                'phone',
                'gender',
                'password',
            ] as $key
        ) {
            $result[$key] = $params[$key];
        }
        return $result;
    }
}
