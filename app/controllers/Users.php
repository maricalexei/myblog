<?php

class Users extends Controller
{
    public function __construct (){
        $this->userModel = $this->model('User');
    }

    public function login(){
        $data = [
           'title'=> 'Login page',
           'username'=> '',
           'password'=> '',
           'usernameError'=>'',
           'passwordError'=>''
        ];

//        Check for post
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
//            Sanitize data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'username'=>trim($_POST['username']),
                'password'=>trim($_POST['password']),
                'usernameError' => '',
                'passwordError' => ''
            ];
//            Validate username
            if(empty($data['username'])){
                $data['usernameError'] = 'please enter a username';
            }

            if(empty($data['password'])){
                $data['passwordError'] = 'please enter a password';
            }

//            Check if all errors are empty
            if(empty($data['usernameError']) && empty($data['passwordError'])){
                $loggedInUser = $this->userModel->login($data['username'], $data['password']);
                if($loggedInUser) {
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['passwordError'] = 'Password or username is incorrect.';

                    $this->view('user/login', $data);
                }
            } else {
                $data = [
                    'username'=> '',
                    'password'=> '',
                    'usernameError'=>'',
                    'passwordError'=>''
                ];
            }
        }
        $this->view('users/login', $data);
    }

    public function createUserSession($user){
        $_SESSION['user_id'] = $user->id;
        $_SESSION['username'] = $user->username;
        $_SESSION['email'] = $user->email;
        header('Location:' . URLROOT . '/pages/index');
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['email']);
        header('location:'. URLROOT . '/users/login');
    }

    public function register(){
        $data = [
           'username'=>'',
           'email'=>'',
           'password'=>'',
           'confirmPassword'=>'',
           'usernameError'=>'',
           'emailError'=>'',
           'passwordError'=>'',
           'confirmPasswordError'=>''
        ];

//        Dit is een vervanging van de oude manier
//        if(isset($_POST['submit'])){}

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
//            Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'username'=>trim($_POST['username']),
                'email'=>trim($_POST['email']),
                'password'=>trim($_POST['password']),
                'confirmPassword'=>trim($_POST['confirmPassword']),
                'usernameError'=>'',
                'emailError'=>'',
                'passwordError'=>'',
                'confirmPasswordError'=>''
            ];

            $nameValidation = "/^[a-zA-Z0-9]*$/";
            $passwordValidation = "/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/";
//            Validate username on letters/numbers
            if(empty($data['username'])){
                $data['usernameError'] = 'Please enter username';
            } elseif (!preg_match($nameValidation, $data['username'])){
                $data['usernameError'] = 'Name can only contain letters and numbers';
            }

//            Validate Email
            if(empty($data['email'])){
                $data['emailError'] = 'Please enter E-mail address';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                $data['emailError'] = 'Please enter a valid E-mail address';
            } else {
                if($this->userModel->findUserByEmail($data['email'])){
                $data['emailError'] = 'Email address already exists';
                }
            }
//            Validate password on length and numeric values
            if(empty($data['password'])){
                $data['passwordError'] = 'Please enter a password!';
            } elseif (strlen($data['password']) < 8){
                $data['passwordError'] = 'Password has to have at least 8 characters';
            } elseif (!preg_match($passwordValidation, $data['password'])){
            $data['passwordError'] = 'password must have at least one numeric value';
        }

//            Validate confirm password
            if(empty($data['confirmPassword'])){
                $data['confirmPasswordError'] = 'Please enter a password!';
            } else {
            if($data['confirmPassword'] != $data['password']){
                $data['confirmPasswordError'] = 'passwords do not match, please try again';
                }
            }

//            Make sure the error are empty
            if (empty($data['usernameError']) &&
                empty($data['emailError']) &&
                empty($data['passwordError']) &&
                empty($data['confirmPasswordError'])){
//                Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

//                Register user from model function
                if($this->userModel->register($data)){
//                    Redirect to the login page
                    header('Location: '. URLROOT . '/users/login');
                } else {

                    die('Something went wrong');
                }
            }
        }

        $this->view('users/register', $data);
    }
}