<?php

class Pages extends Controller
{

    public function index(){
        $this->view('pages/index');
    }

    public function loan(){
        $this->view('pages/loan');
    }

    public function about(){
        $this->view('pages/about');
    }



}