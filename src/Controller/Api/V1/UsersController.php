<?php

namespace App\Controller\Api\V1;

use App\Controller\AppController;
use Firebase\JWT\JWT;
use Cake\Utility\Security;

/*Controller de API*/

class UsersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['login']);
    }

    public function login()
    {
        $user = $this->Auth->identify();
        if ($user) {
            $this->Auth->setUser($user);
            $data = [
                'token' => JWT::encode([
                    'sub' => $user['id'],
                    'exp' => time() + 3600 * 24 * 7
                ], Security::salt())
            ];

            $this->set([
                'data' => $data,
                '_serialize' => ['data']
            ]);

        } else {
            $this->response = $this->response->withStatus(400);
            $this->set([
                'data' => 'Usuário ou senha inválida.',
                '_serialize' => ['data']
            ]);
        }
    }

    public function index()
    {
        $users = $this->Users->find('all');
        $this->set([
            'data' => $users,
            '_serialize' => ['data'] //Nome da chave (data) não o $users
        ]);
    }

    public function view($id){
        $user = $this->Users->get($id);
        $this->set([
            'data' => $user,
            '_serialize' => ['data'] //Nome da chave (data) não o $users
        ]);
    }

    public function add(){
        $user = $this->Users->newEntity($this->request->getData());
        if($this->Users->save($user)){
            $msg = 'Saved';
        }else{
            $msg = 'Error';
        }

        $this->set([
            'data' => $user,
            'msg' => $msg,
            '_serialize' => ['data', 'msg'] //Nome da chave (data) não o $users
        ]);
    }

    public function edit($id){
        $user = $this->Users->get($id);
        $user = $this->Users->patchEntity($user, $this->request->getData());
        if($this->Users->save($user)){
            $msg = 'Saved';
        }else{
            $msg = 'Error';
        }

        $this->set([
            'data' => $user,
            'msg' => $msg,
            '_serialize' => ['data', 'msg'] //Nome da chave (data) não o $users
        ]);
    }

    public function delete($id){
        $user = $this->Users->get($id);
        if($this->Users->delete($user)){
            $msg = 'Deleted';
        }else{
            $msg = 'Error';
        }

        $this->set([
            'data' => $user,
            'msg' => $msg,
            '_serialize' => ['data', 'msg'] //Nome da chave (data) não o $users
        ]);
    }
}
