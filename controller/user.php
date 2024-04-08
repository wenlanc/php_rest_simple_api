<?php
    require_once 'base.php';
    require_once dirname(dirname(__FILE__)) . "/model/Clients.php";

    class UserController extends BASE
    {
        
        /**
         * Authorize the user with idnumber and password
         * @return `id`, `token`
         */
        public function auth($args) {
            if ($this->method == 'POST') {
                global $conn;

                $idnumber = $_POST['idnumber'];
                $password = $_POST['password'];
                
                $model = new Clients($conn);
                $result = $model->readOne($idnumber);

                if($result !== -1){
                    $id = $result['id'];
                    $dbpassword = $result['password']; 
                    if(password_verify($password, $dbpassword)){
                        global $jwt;

                        $payload = [
                            'id' => $id,
                            'idnumber' => $idnumber,
                            'iss' => 'jwt.local',
                            'aud' => 'token@westore.ge'
                        ];
                        $token = $jwt->generate($payload);
                        $response['id'] = $id;
                        $response['token'] = $token;
                        return $response;
                    }
                    else return array("error" => "Invalid Password!");
                }
                return array("error" => "Invalid Credentials!");
            } else {
                return array("error" => "Only accepts POST requests!");
            }
        }

        /**
         * Register user with full information
         * @return  `id`, `token`
         */
        public function register() {
            if ($this->method == 'POST') {
                global $conn;

                $idnumber = $_POST['idnumber'];
                $password = $_POST['password'];
                $status = $_POST['status'];
                $company = $_POST['company'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $finances = $_POST['finances'];
                $edit_product_name = $_POST['edit_product_name'];

                $model = new Clients($conn);
                $find = $model->readOne($idnumber);
                if($find !== -1)
                    return array("error" => "This idnumber is already in use!");

                $user_id = $model->insert($status, $company, $email, $phone, $idnumber, $password, $finances, $edit_product_name);

                if($user_id == -1)
                    return array("error" => "Not Registered!");
                
                global $jwt;
                $payload = [
                    'id' => $user_id,
                    'idnumber' => $idnumber,
                    'iss' => 'jwt.local',
                    'aud' => 'token@westore.ge'
                ];
                $token = $jwt->generate($payload);
                $response['id'] = $user_id;
                $response['token'] = $token;
                return $response;
            }
        }
    }
?>