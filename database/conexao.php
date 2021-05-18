<?php

const HOST = "localhost";
const USER = "root";
const PASSWORD = "abc45101922072";
const DATABASE = "icatalogo";

$conexao = mysqli_connect(HOST, USER, PASSWORD, DATABASE) or die(mysqli_connect_error());

