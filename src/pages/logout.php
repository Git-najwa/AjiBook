<?php

include_once('../models/user.php');

session_start();
session_destroy();

header('Location: ../pages');
