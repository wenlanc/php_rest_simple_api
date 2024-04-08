<?php
    require_once 'base.php';
    require_once dirname(dirname(__FILE__)) . "/model/Clients.php";

    class UserController extends BASE
    {
        
        /**
         * Authorize the user with idnumber and password
         * @return `id`, `token`
         */
        public function login($args) {
            if ($this->method == 'POST') {

                $idnumber = isset($_POST['idnumber']) ? $_POST['idnumber'] : "";
                $password = isset($_POST['password']) ? $_POST['password'] : "";
                
                $model = new Clients();
                $found = $model->readOne($idnumber);

                if($found !== -1){
                    $id = $found['id'];
                    $dbpassword = $found['password']; 
                    if(password_verify($password, $dbpassword)){
                        $payload = [
                            'id' => $id,
                            'idnumber' => $idnumber,
                            'iss' => 'jwt.local',
                            'aud' => 'token@westore.ge'
                        ];
                        $token = $this->generateToken($payload);
                        $response['id'] = $id;
                        $response['token'] = $token;
                        return $response;
                    }
                    else return array("error" => "Incorrect Password!");
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

                $idnumber = isset($_POST['idnumber']) ? $_POST['idnumber'] : "";
                $password = isset($_POST['password']) ? $_POST['password'] : "";
                $status = isset($_POST['status']) ? $_POST['status'] : "";
                $company = isset($_POST['company']) ? $_POST['company'] : "";
                $email = isset($_POST['email']) ? $_POST['email'] : "";
                $phone = isset($_POST['phone']) ? $_POST['phone'] : "";
                $finances = isset($_POST['finances']) ? $_POST['finances'] : "";
                $edit_product_name = isset($_POST['edit_product_name']) ? $_POST['edit_product_name'] : "";
                
                if(empty($idnumber) || empty($password)) {
                    return array("error" => "Input invalid!");
                }
                
                $model = new Clients();
                $find = $model->readOne($idnumber);
                if($find !== -1)
                    return array("error" => "This idnumber is already in use!");

                $user_id = $model->insert($status, $company, $email, $phone, $idnumber, $password, $finances, $edit_product_name);

                if($user_id == -1)
                    return array("error" => "Not Registered!");
                
                $payload = [
                    'id' => $user_id,
                    'idnumber' => $idnumber,
                    'iss' => 'jwt.local',
                    'aud' => 'token@westore.ge'
                ];
                $token = $this->generateToken($payload);
                $response['id'] = $user_id;
                $response['token'] = $token;
                return $response;
            }
        }
    }
?>