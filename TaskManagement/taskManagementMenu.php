<?php
require_once(dirname(__DIR__)."/header.php");

//The upper part of each page
echo <<<_MAIN
    <body>
        <div data-role='page'>
            <div data-role='header'>
                <div id='logo'><img id='secLogo' src='/ABCSecurity/logo.jpeg'>       
                    ABC Security Company</div>
                <div class='username'>$userstr</div>
            </div>
        <div data-role='content'>
_MAIN;

switch (getUserIdentifier($_SESSION['password'])){
    case "Administrator":
        echo <<<_TASKMANAGEMENT
        <div id='wrapper'>
            <div id='menu'>
                <ul>
                    <li><a class="item" href="/ABCSecurity/index.php">Home</a></lis>
                    <li><a class="item" href="AssignTask.php?action=Assign">Assign Tasks</a></li>
                    <li><a class="item" href="UpdateTask.php">Update Tasks</a></li>
                    <li><a class="item" href="DeleteTask.php">Delete Tasks</a></li>
                    <li><a class="item" href="viewTasks.php?user=Administrator">View Tasks</a></li>
                </ul>
            </div>
        </div>
_TASKMANAGEMENT;
        break;
    case "Security":
        echo <<<_TASKMANAGEMENT
        <div id='wrapper'>
            <div id='menu'>
                <ul>
                    <li><a class="item" href="/ABCSecurity/index.php">Home</a></lis>
                    <li><a class="item" href="viewTasks.php?user=Security">View Tasks</a></li>
                </ul>
            </div>
        </div>
_TASKMANAGEMENT;
        break;
}

