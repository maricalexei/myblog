<?php

//    Load the model and the view
class Controller
{
    public function model($model)
    {
//          Require model file
        require_once '../app/models/' . $model . '.php';
//          Instantiate model
        return new $model();
    }

//    Load the view file if exists
    public function view($view, $data = [])
    {
//        echo '../app/views' . $view . '.php';exit();
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            die("View does not exists.");
        }
    }
}