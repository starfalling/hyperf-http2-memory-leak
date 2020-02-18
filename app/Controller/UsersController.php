<?php


namespace App\Controller;

use Hyperf\HttpServer\Annotation\AutoController;
use App\Model\AccessToken;

/**
 * @AutoController(prefix="/api/users")
 */
class UsersController
{

    public function current()
    {
        $model = AccessToken::query()->first();
        return $model->toJson();
    }

}
