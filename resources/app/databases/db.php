<?php

require "../../views/functions.php";

if (!isset($_POST['submit'])) {
    abort_conection();
    die();
}


$_POST = form_sanitizer($_POST);

switch ($_POST['task']) {

    case "add user":
        if ($_POST['terms'] !== "on") {
            abort_conection();
        }
        add_new_user(db(), $_POST);
        break;


    case "sign in":
        echo "Sign in procees!";
        login(db(), $_POST);
        break;

    case "update user":
        echo "Update user!";
        update_user(db(), $_POST);
        break;

    case "Create Post":
        echo "Create Post!";
        if ($_POST['title'] === "" && !isset($_POST['description']) && $_POST['lnk'] !== "") {
            echo "Check link";
            check_link(db(), $_POST['lnk']);
            die();
        } else if ($_POST['title'] !== "" && $_POST['description'] !== "" && $_POST['lnk'] !== "") {
            echo "Add Post!";
            add_post(db(), $_POST);
            die();
        } else {
            $_SESSION['error_msgs'] = "Please fill in all fields properly.";
            header("Location: ../posts/new-post.php#post_form");
            die();
        }

        break;

    case "vote":
        echo "voting!";
        session_start();
        if ($_POST['update'] !== "true") {
            vote(db(), (int)$_POST['post_id'], (int)$_SESSION['user_id'], (int)$_POST['score'], $_POST['update']);
        } else {

            vote(db(), (int)$_POST['post_id'], (int)$_SESSION['user_id'], (int)$_POST['score'], $_POST['update']);
        }
        break;

    case "edit_post":
        echo "Edit post!";
        if ($_POST['title'] !== "" && $_POST['description'] !== "") {
            echo "Update Post!";
            update_post(db(), $_POST);
            die();
        } else {
            session_start();
            $_SESSION['error_msgs'] = "Please fill in all fields properly.";
            header("Location: ../posts/posts.php?post=" . $_POST['post_id'] . "&action=edit");
            die();
        }
        break;

    case "add_comment":
        var_dump("Comment");
        echo "Add a comment!";
        manage_comment(db(), $_POST, "Add");
        break;

    case "edit_comment":
        echo "Edit comment!";
        manage_comment(db(), $_POST, "Edit");
        break;

    default:
        echo "Unkown form <br>";
        die(var_dump($_POST['task']));
        break;
}
